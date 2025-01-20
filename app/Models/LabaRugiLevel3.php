<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabaRugiLevel3 extends Model
{
    use HasFactory;

    protected $fillable = [
        'level_two_id',
        'level_three',
        'is_shown',
        'tahun',
        'bulan',
        'total_this_month',
        'total_till_this_month'
    ];

    public function level_one(){
        return $this->hasOneThrough(LabaRugiLevel1::class,LabaRugiLevel2::class,'id','id','level_two_id','level_one_id');
    }
    public function level_two(){
        return $this->belongsTo(LabaRugiLevel2::class,'level_two_id');
    }
}
