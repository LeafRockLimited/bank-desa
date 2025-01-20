`<template>
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
                    :with-pagination=false
                    :searchProps="searchQuery"

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
                        <template v-slot:action="{item}">
                            <PrimaryButton @click="requestData">Cari</PrimaryButton>
                        </template>
                    </Table>
                </div>
                <div class="grid grid-cols-1 lg:flex lg:flex-row lg:justify-between">
                    <span>Menampilkan data {{ startRow }} - {{ endRow }} dari {{ totalData }}</span>
                    <nav aria-label="Page navigation example">
                        <ul class="inline-flex -space-x-px text-base h-10">
                            <li v-for="(item, index) in links" :key="index">
                                <div @click="requestData" class="flex items-center justify-center
                        px-4 h-10 ms-0 leading-tight text-gray-500 bg-white
                        border border-gray-300
                        hover:bg-gray-100
                        hover:text-gray-700 cursor-pointer" :class="{
                            'rounded-s-lg': index == 0,
                            'rounded-r-lg': index == links.length - 1,
                        }">
                                    <span v-html="item.label"></span>
                                </div>
                            </li>
                        </ul>
                    </nav>
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
import PrimaryButton from "@/Components/PrimaryButton.vue";
export default {
    components: {
        PrimaryButton,
        AuthenticatedLayout, Head, Link, Table, CardBody, SecondaryButton,
        TahunFilter
    },
    props: {
        'neracas': Object,
        'tahun': Number,
        'bulan': Number,
        'search': String,
        'length': Number
    },
    data() {
        return {
            selectedYear: this.tahun,  // Default tahun saat ini
            page: 1,
            lengthQuery: this.length,
            responseData:{},
            searchQuery: this.search,
        };
    },
    computed: {
        startRow() {
            return this.neracas.from??0
        },
        endRow() {
            return this.neracas.to??0
        },
        headers(){
            return ['rekening.nomor_rekening','rekening.nama_rekening','neraca_debit','neraca_kredit','saldo_debit','saldo_kredit','jumlah']
        },
        links(){
            return this.neracas.links??[]
        },
        totalData(){
            return this.neracas.total??0
        },
        tableData(){
            const data = JSON.parse(JSON.stringify(this.neracas.data))

                return data?.map((item) => {
                item.neraca_debit = Helper.rupiah(item.neraca_debit)
                item.neraca_kredit = Helper.rupiah(item.neraca_kredit)
                item.saldo_debit = Helper.rupiah(item.saldo_debit)
                item.saldo_kredit = Helper.rupiah(item.saldo_kredit)
                item.jumlah = Helper.rupiah(item.jumlah)
                return item
            })??[]
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
        requestData() {
            this.$inertia.get(route('neraca.index'), {
                page: this.page,
                length: this.length,
                searchQuery: this.searchQuery,
            });
        }
    },
}
</script>
