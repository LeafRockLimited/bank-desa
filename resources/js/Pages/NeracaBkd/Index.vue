<template>
<Head title="Jurnal" />

<AuthenticatedLayout>
    <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Neraca Bank Kredit Desa
        </h2>
    </template>

    <div class="relative overflow-visible">
        <div class="sticky top-16 bg-white z-50 shadow-md px-8 py-4">
            <div class="flex flex-row space-x-6 items-center justify-between">
                <div class="">
                    <DateFilter v-model="date" month-picker></DateFilter>
                </div>

                <div class="space-x-2">
                    <a href="#neraca-container" class="text-gray-600">#Neraca</a>
                <a href="#laba-rugi-container" class="text-gray-600">#Laba Rugi</a>
                </div>
            </div>
        </div>


        <CardBody id="neraca-container">
            <template v-slot:content>
                <div class="grid grid-cols-1 gap-6">

                    <div class="grid grid-cols-1 gap-6">

                        <div id="content-header" class="flex flex-row justify-between">
                            <div>
                                <p class="text-lg font-semibold">Neraca</p>
                                <span>Badan Kredit Desa (BKD)</span>
                            </div>
                            <a :href="route('neraca.download_neraca_bkd',{bulan: date.month + 1, tahun: date.year})" class="text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28">
                                    <path fill="currentColor"
                                        d="M14 3a7 7 0 0 0-6.931 6.017A5.5 5.5 0 0 0 7.5 20h4.516a7.5 7.5 0 0 1 13.878-4.422Q26 15.055 26 14.5a5.5 5.5 0 0 0-5.069-5.483A7 7 0 0 0 14 3m12 16.5a6.5 6.5 0 1 1-13 0a6.5 6.5 0 0 1 13 0m-6-4a.5.5 0 0 0-1 0v6.793l-2.146-2.147a.5.5 0 0 0-.708.708l3 3a.5.5 0 0 0 .351.146h.006c.127 0 .254-.05.35-.146l3-3a.5.5 0 0 0-.707-.708L20 22.293z" />
                                </svg>
                            </a>
                        </div>

                        <div class="grid grid-flow-row grid-cols-2 gap-2">
                            <NeracaBkdTable :header="['no', 'Keterangan', 'Saldo']" data-label="Aktiva" :data="aktiva">
                            </NeracaBkdTable>
                            <NeracaBkdTable :header="['no', 'Keterangan', 'Saldo']" data-label="Pasiva" :data="pasiva">
                            </NeracaBkdTable>
                        </div>

                        <OverviewTotalNeracaBkd :overview-data="neracaDataOverview">
                        </OverviewTotalNeracaBkd>
                    </div>
                </div>
            </template>
        </CardBody>


        <CardBody id="laba-rugi-container">
            <template v-slot:content>
                <div class="grid grid-cols-1 gap-6">

                    <div class="grid grid-cols-1 gap-6">

                        <div id="content-header" class="flex flex-row justify-between">
                            <div>
                                <p class="text-lg font-semibold">Neraca</p>
                                <span>Badan Kredit Desa (BKD)</span>
                            </div>
                            <a :href="route('neraca.export_laba_rugi_bkd',{bulan: date.month + 1, tahun: date.year})" class="text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28">
                                    <path fill="currentColor"
                                        d="M14 3a7 7 0 0 0-6.931 6.017A5.5 5.5 0 0 0 7.5 20h4.516a7.5 7.5 0 0 1 13.878-4.422Q26 15.055 26 14.5a5.5 5.5 0 0 0-5.069-5.483A7 7 0 0 0 14 3m12 16.5a6.5 6.5 0 1 1-13 0a6.5 6.5 0 0 1 13 0m-6-4a.5.5 0 0 0-1 0v6.793l-2.146-2.147a.5.5 0 0 0-.708.708l3 3a.5.5 0 0 0 .351.146h.006c.127 0 .254-.05.35-.146l3-3a.5.5 0 0 0-.707-.708L20 22.293z" />
                                </svg>
                            </a>
                        </div>

                        <div class="grid grid-flow-row grid-cols-2 gap-2">
                            <NeracaBkdTable :header="['no', 'Keterangan', 'Saldo']" data-label="Pendapatan"
                                :data="laba_rugi_pendapatan">
                            </NeracaBkdTable>
                            <NeracaBkdTable :header="['no', 'Keterangan', 'Saldo']" data-label="Pengeluaran"
                                :data="laba_rugi_pengeluaran">
                            </NeracaBkdTable>
                        </div>

                        <div>
                            <OverviewTotalNeracaBkd :overview-data="labaRugiDataOverview" />
                            <div id="laba_rugi_tahun_berjalan"
                                class="p-4 bg-gray-100 flex flex-row justify-between items-center border-t border-gray-500">
                                <div class="uppercase">
                                    laba rugi / tahun berjalan
                                </div>
                                <div class="text-blue-600 text-lg font-semibold">
                                    {{ Helper.rupiah(props.neracas.pasiva.laba_rugi.total) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </CardBody>

    </div>



</AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AdminLayout.vue';
import { onMounted, ref, watch } from "vue";
import CardBody from '@/Components/CardBody.vue';
import DateFilter from '@/Components/DateFilter.vue';
import NeracaBkdTable from './Components/Table.vue'
import { computed } from 'vue';
import Helper from '@/Helper';
import OverviewTotalNeracaBkd from './Components/OverviewTotal.vue';
import moment from 'moment';
import { router } from '@inertiajs/vue3'

onMounted(() => {
    console.log(props.neracas.pasiva.laba_rugi)
})

const date = ref(moment().format("YYYY-MM"))

watch(date, () => {
    router.get(route('neraca.bkd'), {
        bulan: date.value.month + 1,
        tahun: date.value.year
    }, { preserveState: true })
})

const props = defineProps({
    'neracas': Object,
});


const neracaDataOverview = computed(() => {
    return {
        aktiva: {
            'label': 'Jumlah',
            'sub_label': 'Asset',
            'value': Helper.rupiah(props.neracas.aktiva.total ?? 0)
        },
        pasiva: {
            'label': 'Jumlah',
            'value': Helper.rupiah(props.neracas.pasiva.total ?? 0)
        }
    }
})

const labaRugiDataOverview = computed(() => {
    const labaRugi = props.neracas.pasiva.laba_rugi

    return {
        pendapatan: {
            'label': 'Jumlah',
            'sub_label': 'Pendapatan',
            'value': Helper.rupiah(labaRugi.pendapatan.total ?? 0)
        },
        pengeluaran: {
            'label': 'Jumlah',
            'sub_label': 'Pengeluaran',
            'class':'text-right text-red-600',
            'value': Helper.rupiah(labaRugi.pengeluaran.total ?? 0)
        }
    }
})

const laba_rugi_pendapatan = computed(() => {
    const labaRugi = props.neracas.pasiva.laba_rugi
    return [
        {
            label: 'Bunga Pinjaman Mingguan',
            saldo: {
                class: 'text-right',
                value: Helper.rupiah(labaRugi.pendapatan.bunga.bunga_mingguan ?? 0)
            }
        },
        {
            label: 'Bunga Pinjaman Bulanan',
            saldo: {
                class: 'text-right',
                value: Helper.rupiah(labaRugi.pendapatan.bunga.bunga_bulanan ?? 0)
            }
        },
        {
            label: 'Bunga Pinjaman Musiman',
            saldo: {
                class: 'text-right',
                value: Helper.rupiah(labaRugi.pendapatan.bunga.bunga_musiman ?? 0)
            }
        },
        {
            label: 'Jumlah',
            saldo: {
                class: 'text-right total',
                value: Helper.rupiah(labaRugi.pendapatan.bunga.jumlah ?? 0)
            }
        },
        {
            label: 'Bunga Giro',
            saldo: {
                class: 'text-right',
                value: Helper.rupiah(labaRugi.pendapatan.giro.bunga_giro ?? 0)
            }
        },
        {
            label: 'Bunga Britama',
            saldo: {
                class: 'text-right',
                value: Helper.rupiah(labaRugi.pendapatan.giro.bunga_britama ?? 0)
            }
        },
        {
            label: 'Bunga Simpedes',
            saldo: {
                class: 'text-right',
                value: Helper.rupiah(labaRugi.pendapatan.giro.bunga_simpedes ?? 0)
            }
        },
        {
            label: 'Jumlah',
            saldo: {
                class: 'text-right total',
                value: Helper.rupiah(labaRugi.pendapatan.giro.jumlah ?? 0)
            }
        },
        {
            label: 'Pendapatan Lainnya',
            saldo: {
                class: 'text-right',
                value: Helper.rupiah(labaRugi.pendapatan.pendapatan.pendapatan_lainnya ?? 0)
            }
        },
        {
            label: 'Pendapatan Pinjaman yang di Ph.',
            saldo: {
                class: 'text-right',
                value: Helper.rupiah(labaRugi.pendapatan.pendapatan.pendaptan_pinj_ph ?? 0)
            }
        },
        {
            label: 'Jumlah',
            saldo: {
                class: 'text-right total',
                value: Helper.rupiah(labaRugi.pendapatan.pendapatan.jumlah ?? 0)
            }
        },

    ]
})


const laba_rugi_pengeluaran = computed(() => {
    const labaRugi = props.neracas.pasiva.laba_rugi
    console.log(labaRugi)
    return [
        {
            label: 'Biaya Pengawasan',
            saldo: {
                class: 'text-right',
                value: Helper.rupiah(labaRugi.biaya_pengawasan ?? 0)
            }
        },
        {
            label: 'Bunga Pinjaman BRI',
            saldo: {
                class: 'text-right',
                value: Helper.rupiah(labaRugi.bunga_pinjaman_bri ?? 0)
            }
        },
        {
            label: 'Bunga Pinjaman BKD Lain',
            saldo: {
                class: 'text-right',
                value: Helper.rupiah(labaRugi.bunga_pinjaman_bkd_lain ?? 0)
            }
        },
        {
            label: 'Bunga Lainnya',
            saldo: {
                class: 'text-right',
                value: Helper.rupiah(labaRugi.bunga_lainnya ?? 0)
            }
        },
        {
            label: 'Bunga Tabanas',
            saldo: {
                class: 'text-right',
                value: Helper.rupiah(labaRugi.bunga_tabanas ?? 0)
            }
        },
        {
            label: 'Gaji Komisi',
            saldo: {
                class: 'text-right',
                value: Helper.rupiah(labaRugi.gaji_komisi ?? 0)
            }
        },
        {
            label: 'Gaji JTU/Dana Usaha',
            saldo: {
                class: 'text-right',
                value: Helper.rupiah(labaRugi.gaji_jtu ?? 0)
            }
        },
        {
            label: 'PH. Aktiva teetap & invent',
            saldo: {
                class: 'text-right',
                value: Helper.rupiah(labaRugi.ph_aktiva_tetap ?? 0)
            }
        },
        {
            label: 'Biaya Lainnya',
            saldo: {
                class: 'text-right',
                value: Helper.rupiah(labaRugi.biaya_lainnya ?? 0)
            }
        },
        {
            label: 'Premi Asuransi',
            saldo: {
                class: 'text-right',
                value: Helper.rupiah(labaRugi.premi_asuransi ?? 0)
            }
        },
    ]
})

const aktiva = computed(() => {
    return [
        {
            label: 'Kas',
            saldo: {
                class: 'text-right',
                value: Helper.rupiah(props.neracas.aktiva.kas_tunai ?? 0)
            }
        },
        {
            label: 'Antar Bank Aktiva',
            saldo: {
                class: 'text-right',
                value: Helper.rupiah(props.neracas.aktiva.antar_bank ?? 0)
            }
        },
        {
            label: 'Pinjaman Yang Diberikan',
            saldo: {
                class: 'text-right',
                value: Helper.rupiah(props.neracas.aktiva.pinjaman ?? 0)
            }
        },
        {
            label: 'Pinjaman BKD Lain',
            saldo: {
                class: 'text-right',
                value: Helper.rupiah(props.neracas.aktiva.pinjaman_bkd_lain_aktiva ?? 0)
            }
        },
        {
            label: 'Harta Tetap dan Inventaris',
            saldo: {
                class: 'text-right',
                value: Helper.rupiah(props.neracas.aktiva.harta_tetap ?? 0)
            }
        },
        {
            label: 'Akumulasi Penyusutan',
            saldo: {
                class: 'text-right',
                value: Helper.rupiah(props.neracas.aktiva.akumulasi_penyusutan ?? 0)
            }
        },

    ];
})


const pasiva = computed(() => {

    return [
        {
            label: 'Tabungan',
            saldo: {
                class: 'text-right',
                value: Helper.rupiah(props.neracas.pasiva.simpanan ?? 0)
            }
        },
        {
            label: 'Antar Bang Pasiva',
            saldo: {
                class: 'text-right',
                value: Helper.rupiah(props.neracas.pasiva.antar_bank ?? 0)
            }
        },
        {
            label: 'Pinjaman BKD Lain',
            saldo: {
                class: 'text-right',
                value: Helper.rupiah(props.neracas.pasiva.pinjaman_bkd_lain ?? 0)
            }
        },
        {
            label: 'Pinjaman Lainnya',
            saldo: {
                class: 'text-right',
                value: Helper.rupiah(props.neracas.pasiva.pinjaman_lainnya ?? 0)
            }
        },
        {
            label: 'Modal',
            saldo: {
                class: 'text-right',
                value: Helper.rupiah(props.neracas.pasiva.modal ?? 0)
            }
        },
        {
            label: 'Rupa - rupa pasiva',
            saldo: {
                class: 'text-right',
                value: Helper.rupiah(props.neracas.pasiva.rupa_pasiva ?? 0)
            }
        },
        {
            label: 'Laba (Rugi)',
            saldo: {
                class: 'text-right',
                value: Helper.rupiah(props.neracas.pasiva?.laba_rugi?.total ?? 0)
            }
        }
    ];
})

// Helper function untuk format currency
const formatCurrency = (value) => {
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
    }).format(value);
};
</script>


<style scoped>
.sticky-container {
    position: sticky;
    top: 20;
    background: white;
    /* Tambahkan background agar tidak transparan */
    z-index: 50;
    /* Pastikan elemen tetap di atas */
}
</style>