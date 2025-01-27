<?php

namespace App\Http\Controllers;

use App\LabaRugiTrait;
use App\Models\KodeRekening;
use App\Models\LabaRugiLevel1;
use App\Models\LabaRugiLevel3;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;

class LabaRugiController extends Controller
{

    protected $kodeRekening = [
        [
            'key' => '4',
            'sub' => [
                [
                    'key' => '1',
                    'sub' => [
                        '01','02','03','04','05','06','07','08','09','10','11'
                    ],

                ],
                [
                    'key' => '2',
                    'sub' => [
                        '01'
                    ]
                ],
                [
                    'key' => '3',
                    'sub' => [
                        '01'
                    ]
                ],
            ]
        ],
        [
            'key' => '5',
            'sub' => [
                [
                    'key' => '1',
                    'sub' => [
                        '01'
                    ],

                ],
                [
                    'key' => '2',
                    'sub' => [
                        '01'
                    ]
                ],
            ]
        ],
        [
            'key' => '6',
            'sub' => [
                [
                    'key' => '1',
                    'sub' => [
                        '01','02','03','04','05','06','07','08','99'
                    ],

                ],
            ]
        ],
        [
            'key' => '7',
            'sub' => [
                [
                    'key' => '1',
                    'sub' => [
                        '01','02','03','04','05','99'
                    ],
                ],
                [
                    'key' => '2',
                    'sub' => [
                        '01','02','03','04'
                    ],
                ],
                [
                    'key' => '3',
                    'sub' => [
                        '01'
                    ],
                ],
            ]
        ],
        [
            'key' => '3',
            'sub' => [
                [
                    'key' => '2',
                    'sub' => [
                        '01','02'
                    ],
                ],
            ]
        ],
    ];

    private $bulan;
    private $tahun;

    use LabaRugiTrait;
    public function index(Request $request){
        $validator = Validator::make($request->all(), [
            'bulan' => 'required',
            'tahun' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $labaRugi = $this->laba_rugi_data($request['tahun'],$request['bulan']);

            return Inertia::render('LabaRugi/Index',[
                'laba_rugi' => $labaRugi
            ]);
        }
        catch (\Throwable $th){
            return $th;
        }

    }

    private function findLabaRugiLevel1($rekening){

        $rekenings = $this->mappingRekening($rekening);

        foreach ($rekenings as $rekening){

            foreach ($rekening as $data){
                $level = explode('.', $data);

                $level1 =  LabaRugiLevel1::where('level_one', $data[0])
                    ->with(['level_2' => function ($query) use ($level) {
                        $query->where('level_two', $level[1]);
                    },'level_2.level_3'=> function ($query) use ($level) {
                        $query->where('level_three', $level[2]);
                    }])
                    ->where('bulan',$this->bulan)
                    ->where('tahun',$this->tahun)
                    ->first();


                if ($level1) {
                    $resData[] = $this->mappingData($level1);
                }
            }
        }

        $tempData = collect($resData)
        ->reduce(function($carry,$item){
            if($carry['rekening'] == $item['rekening']){

                $dataDetail = collect($item['detail'])->first();
                $search = $this->array_search_recursive($dataDetail['rekening'], $carry['detail']);

                if(isset($search)){
                    $carry['detail'][$search[0]][] = $item['detail'][0]['detail'][0];
                }

            }else{
                $carry = [
                    'rekening' => $item['rekening'],
                    'nama' => $item['nama'],
                    'total_this_month' => $item['total_this_month'],
                    'total_till_this_month' => $item['total_till_this_month'],
                    'detail' => $item['detail']
                ];
            }
            return $carry;
        },[
            'rekening' => null,
            'nama' => null,
            'total_this_month' => null,
            'total_till_this_month' => null,
            'detail' => []
        ]);

        $reduce = array_reduce($resData,function($carry,$item){
            $carry[] = collect($item['detail'])->first()['detail'];

            return $carry;
        },[]);


    }

    private function mappingData(LabaRugiLevel1 $labaRugiLevel1){
        $mappingLevel1 = [
            'rekening' => $labaRugiLevel1->level_one.'.0.0',
            'nama' => $this->getRekeningLevelName($labaRugiLevel1->level_one)->uraian_level_one??null,
            'total_this_month' => $labaRugiLevel1->total_this_month,
            'total_till_this_month' => $labaRugiLevel1->total_till_this_month,
            'detail' => []
        ];

        $mappingLevel2 = $labaRugiLevel1->level_2->map(function ($item) use($labaRugiLevel1) {

            return [
                'rekening' => $labaRugiLevel1->level_one.'.'.$item->level_two.'.0',
                'nama' => $this->getRekeningLevelName($labaRugiLevel1->level_one, $item->level_two)->uraian_level_two??null,
                'total_this_month' => $item->total_this_month,
                'total_till_this_month' => $item->total_till_this_month,
                'detail' => $item->level_3->map(function ($subLevel3) use($labaRugiLevel1, $item) {
                   return [
                       'rekening' => $labaRugiLevel1->level_one.'.'.$item->level_two.'.'.$subLevel3->level_three,
                       'nama' => $this->getRekeningLevelName($labaRugiLevel1->level_one, $item->level_two, $subLevel3)->uraian_level_two??null,
                       'total_this_month' => $subLevel3->total_this_month,
                       'total_till_this_month' => $subLevel3->total_till_this_month,
                   ];
                })->toArray()
            ];
        })->toArray();
        $mappingLevel1['detail'] = $mappingLevel2;


        return $mappingLevel1;
    }


    private function getRekeningLevelName($level_one, $level_two = null, $level_three = null){
        return KodeRekening::where('level_one',$level_one)
            ->when($level_two, function ($query) use ($level_two) {
                $query->where('level_two', $level_two);
            })
            ->when($level_three, function ($query) use ($level_three) {
                $query->where('level_three', $level_three);
            })
            ->first();
    }

    private function mappingRekening($rekening){
        $masterRekening = $rekening['key'];

        $rekening = array_map(function($item) use($masterRekening){
            $subMaster = $item['key'];
            $subRekening = $item['sub'];
            $data = array_map(function($item) use ($masterRekening, $subMaster, $subRekening){
                return $masterRekening.'.'.$subMaster.'.'.$item;
            },$subRekening);
            return $data;
        },$rekening['sub']);

        return $rekening;
    }

    public function export(Request $request){
        $request = $request->validate([
            'bulan' => 'required',
            'tahun' => 'required',
        ]);


    }

    private function laba_rugi_data($tahun, $bulan){
        try {
            $data = [];
            foreach ($this->kodeRekening as $index => $rekening){

                $kodeRekeningLevel1 = $rekening['key'];

                $labaRugi = LabaRugiLevel1::select('*')
                    ->with(['level_2' => function($query) {
                        return $query->with('level_3');
                    }])
                    ->where('level_one',$kodeRekeningLevel1)
                    ->where('bulan',$bulan)
                    ->where('tahun',$tahun)
                    ->first();

                $rekeningLevel1 = KodeRekening::select('uraian_level_one as uraian')
                    ->where('level_one',$kodeRekeningLevel1)
                    ->first();

                $labaRugi['level_one'] = $kodeRekeningLevel1.'.0'.'.00';
                $labaRugi['uraian_level'] = $rekeningLevel1['uraian'];

                isset($labaRugi['level_2']) ? $labaRugi['level_2']->map(function($item) use ($kodeRekeningLevel1){
                    $level2 = KodeRekening::select('uraian_level_two as uraian','level_two')
                        ->where('level_one',$kodeRekeningLevel1)
                        ->where('level_two',$item['level_two'])
                        ->first();

                    $item['level_two'] = isset($level2['level_two']) ? $kodeRekeningLevel1.'.'.$level2['level_two'].'.00' : null;
                    $item['uraian_level'] = $level2['uraian']??null;
                    $kodeRekeningLevel2 = $level2['level_two'];

                    $item['level_3']->map(function($item) use($kodeRekeningLevel1,$kodeRekeningLevel2){;
                        $level3 = KodeRekening::select('uraian_level_three as uraian','level_three')
                            ->where('level_one',$kodeRekeningLevel1)
                            ->where('level_two',$kodeRekeningLevel2)
                            ->where('level_three',$item['level_three'])
                            ->first();

                        $item['level_three'] = isset($level3['level_three']) ? $kodeRekeningLevel1.'.'.$kodeRekeningLevel2.'.'.$item['level_three'] : null;
                        $item['uraian_level'] = $level3['uraian'];
                        return $item;
                    });

                    return $item;
                }): null;

                $data[] = $labaRugi??null;
            }

            return $data;
        }
        catch (\Throwable $th) {
            throw $th;
        }
    }

}
