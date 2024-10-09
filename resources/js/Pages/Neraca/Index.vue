<template>
    <Head title="Neraca" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Rekap Neraca</h2>
        </template>

        <CardBody>
            <template v-slot:content>
                <div class="flex flex-col space-y-4">
                    <div class="w-full">
                        <p class="text-lg font-bold">Rekap Neraca</p>
                        <!-- description -->
                        <p> Laporan neraca ini menampilkan total debit, kredit, dan saldo berdasarkan tahun dan kode rekening.</p>
                    </div>

                    <!-- Table untuk menampilkan rekap neraca -->
                    <Table 
                    :headers="headers" 
                    :data="tableData"
                    :startRow="startRow"
                    :links="links"
                    :totalData="totalData"
                    :endRow="endRow"
                    @refreshed-data="()=>{
                        getData();
                    }"
                    @click-page="(value) => {
                        page = value
                    }"
                    @change-length="(value) => {
                        length = value
                    }"
                    @on-search="(value) => {
                        searchQuery = value
                    }"
                    >
                    <template v-slot:filter>
                        <a v-if="route().has('neraca.download')" :href="route('neraca.download',{tahun : tahun, bulan: bulan})" class="border px-3 rounded-md border-gray-300 bg-gray-50 inline-flex items-center text-gray-600 space-x-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 32 32"><path fill="#20744a" fill-rule="evenodd" d="M28.781 4.405h-10.13V2.018L2 4.588v22.527l16.651 2.868v-3.538h10.13A1.16 1.16 0 0 0 30 25.349V5.5a1.16 1.16 0 0 0-1.219-1.095m.16 21.126H18.617l-.017-1.889h2.487v-2.2h-2.506l-.012-1.3h2.518v-2.2H18.55l-.012-1.3h2.549v-2.2H18.53v-1.3h2.557v-2.2H18.53v-1.3h2.557v-2.2H18.53v-2h10.411Z"/><path fill="#20744a" d="M22.487 7.439h4.323v2.2h-4.323zm0 3.501h4.323v2.2h-4.323zm0 3.501h4.323v2.2h-4.323zm0 3.501h4.323v2.2h-4.323zm0 3.501h4.323v2.2h-4.323z"/><path fill="#fff" fill-rule="evenodd" d="m6.347 10.673l2.146-.123l1.349 3.709l1.594-3.862l2.146-.123l-2.606 5.266l2.606 5.279l-2.269-.153l-1.532-4.024l-1.533 3.871l-2.085-.184l2.422-4.663z"/></svg>
                            <span>Download</span>
                        </a>
                        <TahunFilter 
                        @on-change="(value)=>{selectedYear = value}"/>
                    </template>
                      
                    </Table>
                </div>
            </template>
        </CardBody>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import Table from '@/Components/Table.vue';
import CardBody from '@/Components/CardBody.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import axios from 'axios';
import Helper from '@/Helper';
import TahunFilter from '@/Components/TahunFilter.vue';
export default {
    components: {
        AuthenticatedLayout, Head, Link, Table, CardBody, SecondaryButton,
        TahunFilter
    },
    data() {
        return {
            selectedYear: new Date().getFullYear(),  // Default tahun saat ini
            page: 1,
            length: 10,
            responseData:{},
            tableData: [],
            searchQuery: null,
        };
    },
    computed: {
        startRow() {
            return this.responseData.from??0
        },
        endRow() {
            return this.responseData.to??0
        },
        headers(){
            return ['kode_rekening','nama_rekening','total_debit','total_kredit','total_saldo']
        },
        links(){
            return this.responseData.links??[]
        },
        totalData(){
            return this.responseData.total??0
        }
    },
    watch: {
        searchQuery(newVal) {
            this.page = 1
            this.getData()
        },
        page(newVal) {
            this.getData()
        },
        length(newVal) {
            this.page = 1
            this.getData()
        },
        selectedYear(newVal) {
            this.page = 1
            this.getData()
        }
    },
    methods: {
        getData() {
            console.log(this.length)
            // Mengambil data rekap neraca berdasarkan tahun yang dipilih
            axios.get(route('neraca.show', { 
                page: this.page,
                length : this.length,
                search: this.searchQuery,
                tahun: this.selectedYear 
            })).then(response => {
                this.responseData = response.data;
                this.tableData = response.data.data.map(item => ({
                    kode_rekening: item.kode_rekening,
                    nama_rekening: item.nama_rekening,
                    total_debit: Helper.rupiah(item.total_debit),
                    total_kredit: Helper.rupiah(item.total_kredit),
                    total_saldo: Helper.rupiah(item.total_saldo),
                    kode_rekening_id: item.kode_rekening_id  // Untuk navigasi ke halaman detail
                }));
            }).catch(error => {
                console.error('Error fetching neraca data:', error);
            });
        },
    },
    mounted() {
        // this.fetchAvailableYears();
        this.getData();
    }
}
</script>
