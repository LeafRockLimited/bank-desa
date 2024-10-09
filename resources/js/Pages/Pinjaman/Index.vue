<template>
<Head title="Pinjaman" />

<AuthenticatedLayout>
    <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pinjaman Nasabah</h2>
    </template>

    <CardBody>
        <template v-slot:content>
            <div class="flex flex-row space-x-4">
                <div class=" w-fit">
                    <p class=" text-lg font-bold">Isi formulir peminjaman</p>
                    <p>Tambahkan data pinjaman nasabah dengan menekan tombol dibawah ini, pastikan semua formulir diisi
                        dengan valid</p>
                    <div class="mt-4">
                        <Link :href="route('pinjaman.create')">
                        <PrimaryButton class="">+ Formulir Peminjaman</PrimaryButton>
                        </Link>
                    </div>
                </div>
            </div>
        </template>
    </CardBody>

    <CardBody>
        <template v-slot:content>
            <div class="space-y-3">
                <div>
                    <p class=" text-md lg:text-lg font-bold">Rekap pinjaman nasabah tahun {{ tahun }}</p>
                </div>
                <div class=" grid grid-cols-1 gap-6 lg:flex lg:flex-row lg:justify-between">
                    <div>
                        <p class="text-gray-500">Total pengajuan pinjaman</p>
                        <p class="font-bold text-xl">{{ dataRekap.total_pengajuan ?? 0 }} Pengajuan</p>
                    </div>
                    <hr class=" max-lg:show">
                    <div>
                        <p class=" text-gray-500">Uang dipinjamkan (Total)</p>
                        <p class="font-bold text-xl lg:text-right">{{ dataRekap.uang_diterima_nasabah }}</p>
                    </div>
                    <hr class=" max-lg:show">
                    <div>
                        <p class=" text-gray-500">Jumlah nominal pengembalian</p>
                        <p class="font-bold text-xl lg:text-right">{{ dataRekap.jumlah_pinjaman }}</p>
                    </div>
                    <hr class=" max-lg:show">
                    <div>
                        <p class=" text-gray-500">Potensi keuntungan</p>
                        <p class=" font-extrabold text-xl text-indigo-700 lg:text-right">{{ dataRekap.keuntungan }}</p>
                    </div>
                </div>
            </div>
        </template>
    </CardBody>

    <CardBody>
        <template v-slot:content>
            <Table :headers="headers" :data="dataRow" :startRow="startRow" :links="links" :lengthProps="lengthProps"
                :deleteData="true" deleteRoute="pinjaman.delete" :editData="true" editRoute="pinjaman.edit"
                :totalData="totalData" :endRow="endRow" :actionUsingId=true @refreshed-data="() => {
                    getData();
                    getRekapData()
                }" @click-page="(value) => {
                    page = value
                }" @change-length="(value) => {
                        length = value
                    }" @on-search="(value) => {
                        searchQuery = value
                    }">
                <template v-slot:filter>
                    <div class="grid grid-cols-1 gap-6">
                        <div class="flex flex-row space-x-3">
                            <a :href="route('pinjaman.download', { tahun: tahun, bulan: bulan, status: status })"
                                class="border px-3 rounded-md border-gray-300 bg-gray-50 inline-flex items-center text-gray-600 space-x-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 32 32">
                                    <path fill="#20744a" fill-rule="evenodd"
                                        d="M28.781 4.405h-10.13V2.018L2 4.588v22.527l16.651 2.868v-3.538h10.13A1.16 1.16 0 0 0 30 25.349V5.5a1.16 1.16 0 0 0-1.219-1.095m.16 21.126H18.617l-.017-1.889h2.487v-2.2h-2.506l-.012-1.3h2.518v-2.2H18.55l-.012-1.3h2.549v-2.2H18.53v-1.3h2.557v-2.2H18.53v-1.3h2.557v-2.2H18.53v-2h10.411Z" />
                                    <path fill="#20744a"
                                        d="M22.487 7.439h4.323v2.2h-4.323zm0 3.501h4.323v2.2h-4.323zm0 3.501h4.323v2.2h-4.323zm0 3.501h4.323v2.2h-4.323zm0 3.501h4.323v2.2h-4.323z" />
                                    <path fill="#fff" fill-rule="evenodd"
                                        d="m6.347 10.673l2.146-.123l1.349 3.709l1.594-3.862l2.146-.123l-2.606 5.266l2.606 5.279l-2.269-.153l-1.532-4.024l-1.533 3.871l-2.085-.184l2.422-4.663z" />
                                </svg>
                                <span>Download</span>
                            </a>
                            <TahunFilter @on-change="(value) => { tahun = value }" />
                            <BulanFilter @on-change="(value) => { bulan = value }" />

                            <!-- status pinjaman filter -->
                            <select v-model="status" class="min-w-40 bg-gray-50 border border-gray-300 text-gray-900 
                            text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 
                            block p-2.5">
                                <option selected :value="null"> Status Pinjaman </option>
                                <option value="pending"> Menunggu </option>
                                <option value="approved"> Diterima </option>
                                <option value="rejected"> Ditolak </option>
                                <option value="paid"> Lunas </option>
                            </select>
                            <!-- end status pinjaman filter -->
                        </div>


                        <!-- status pinjaman filter -->
                        <select v-model="jenisPinjaman" class="w-40 bg-gray-50 border border-gray-300 text-gray-900 
                            text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 
                            block p-2.5">
                            <option selected :value="null"> Jenis Pinjaman </option>
                            <option value="mingguan">Mingguan</option>
                            <option value="bulanan">Bulanan</option>
                            <option value="tahunan">Tahunan</option>
                            <option value="musiman">Musiman</option>
                        </select>
                        <!-- end status pinjaman filter -->
                    </div>
                </template>
            </Table>
        </template>
    </CardBody>
</AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import Table from '@/Components/Table.vue';
import CardBody from '@/Components/CardBody.vue';
import axios from 'axios';
import PrimaryButton from '@/Components/PrimaryButton.vue'
import Helper from '@/Helper.js'
import TahunFilter from '@/Components/TahunFilter.vue'
import BulanFilter from '@/Components/BulanFilter.vue'

export default {
    components: {
        AuthenticatedLayout, Head, Link, Table, CardBody, PrimaryButton, TahunFilter, BulanFilter
    },
    data() {
        return {
            dataPinjaman: [],
            dataRow: [],
            dataRekap: {
                jumlah_pinjaman: 0,
                total_pengajuan: 0,
                uang_diterima_nasabah: 0,
                keuntungan: 0,
                year: null,
            },
            page: 1,
            length: 10,
            searchQuery: null,
            tahun: this.$moment().year(),
            bulan: null,
            status: null,
            jenisPinjaman:null
        }
    },
    computed: {
        headers() {
            return ["nasabah.nama_lengkap", "jenis_pinjaman", "jumlah_pinjaman", "bunga", "nominal_diterima", "status_pinjaman", "tanggal_jatuh_tempo", "tanggal_pengajuan"]
        },
        startRow() {
            return this.dataPinjaman.from ?? 1
        },
        endRow() {
            return this.dataPinjaman.to ?? 0
        },
        totalData() {
            return this.dataPinjaman.total ?? 0
        },
        links() {
            return this.dataPinjaman.links ?? []
        },
    },
    watch: {
        page(newVal) {
            this.getData()
        },
        length(newVal) {
            this.page = 1
            this.getData()
        },
        searchQuery(newVal) {
            this.page = 1
            this.getData()
        },
        tahun(newVal) {
            this.page = 1
            this.getData()
            this.getRekapData()
        },
        bulan(newVal) {
            this.page = 1
            this.getData()
            this.getRekapData()
        },
        status(newVal) {
            this.page = 1
            this.getData()
            this.getRekapData()
        },
        jenisPinjaman(newVal) {
            this.page = 1
            this.getData()
            this.getRekapData()
        }
    },
    beforeMount() {
        this.getData();
        this.getRekapData()
    },
    methods: {
        async getData() {
            const url = route('pinjaman.show', {
                page: this.page,
                length: this.length,
                searchQuery: this.searchQuery,
                tahun: this.tahun,
                bulan: this.bulan,
                status: this.status,
                jenis_pinjaman: this.jenisPinjaman
            });

            const request = await axios.get(url);
            const response = request.data
            this.dataPinjaman = response
            this.mappingData()

        },
        mappingData() {
            this.dataRow = [];
            if (this.dataPinjaman?.data?.length > 0) {
                let data = this.dataPinjaman.data.map((item) => {
                    item.nominal_diterima = Helper.rupiah(parseInt(item.nominal_diterima))
                    item.tanggal_jatuh_tempo = Helper.tanggal(item.tanggal_jatuh_tempo);
                    item.tanggal_pengajuan = Helper.tanggal(item.tanggal_pengajuan);
                    item.jumlah_pinjaman = Helper.rupiah(parseInt(item.jumlah_pinjaman))
                    return item
                })
                this.dataRow = data
            } else {
                return []
            }
        },
        async getRekapData() {
            const request = await axios.get(route('pinjaman.show_rekap', {
                tahun: this.tahun,
                bulan: this.bulan,
                status: this.status
            }))

            const response = request.data
            this.dataRekap = {
                jumlah_pinjaman: Helper.rupiah(parseInt(response.jumlah_pinjaman)),
                total_pengajuan: response.total_pengajuan,
                uang_diterima_nasabah: Helper.rupiah(parseInt(response.uang_diterima_nasabah)),
                keuntungan: Helper.rupiah(parseInt(response.keuntungan)),
                year: response.year,
            }

        },
    },
}
</script>