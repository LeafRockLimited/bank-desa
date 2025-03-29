<template>
    <Head title="Buku Besar" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Buku Besar
            </h2>
        </template>

        <!-- Tabel Buku Besar -->
        <CardBody>
            <template v-slot:content>
                <Table
                    :headers="headers"
                    :data="tableData"
                    :startRow="startRow"
                    :links="links"
                    :lengthProps="length"
                    :totalData="totalData"
                    :endRow="endRow"
                    :actionUsingId=true
                    :with-pagination=false
                    :searchProps="searchQuery"
                    @refreshed-data="getData"
                    @click-page="page = $event"
                    @change-length="length = $event"
                    @on-search="searchQuery = $event"
                >
                    <template v-slot:action="{item}">
                        <PrimaryButton @click="requestData">Cari</PrimaryButton>
                    </template>

                    <template v-slot:filter>
                        <div class="w-full grid grid-flow-row grid-cols-1 gap-6">
                            <div class="w-full">
                                <label class="text-sm" for="rekening">Akun Rekening</label>
                                <v-select v-model="selectedRekening" class="w-full"
                                  :label="label"
                                  :reduce="(rekening) => rekening.code"
                                  :options="rekeningList"></v-select>
                            </div>
                        </div>
                    </template>
                </Table>
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
import Table from '@/components/Table.vue';
import CardBody from '@/components/CardBody.vue';
import PrimaryButton from '@/components/PrimaryButton.vue';
import Helper from '@/Helper';
import axios from 'axios';

export default {
    components: {
        AuthenticatedLayout, Head, Link, Table, CardBody, PrimaryButton
    },
    props: {
        rekening:Array,
        buku_besar: Object,
        length: Number,
        search: String,
        rekening_props: Number
    },
    data() {
        return {
            page: 1,
            length: 10,
            dataResponse: {},
            searchQuery: this.search,
            selectedRekening: this.rekening_props ,
        };
    },
    computed: {
        startRow() {
            return this.buku_besar.from ?? 0;
        },
        endRow() {
            return this.buku_besar.to ?? 0;
        },
        headers() {
            return ['jurnal.keterangan' ,'jurnal.tanggal_transaksi', 'debit', 'kredit', 'saldo'];
        },
        links() {
            return this.buku_besar.links ?? [];
        },
        totalData() {
            return this.buku_besar.total ?? 0;
        },
        tableData(){
            const data = JSON.parse(JSON.stringify(this.buku_besar.data))
            return data?.map((item) => {
                item.debit = Helper.rupiah(item.debit??0)
                item.kredit = Helper.rupiah(item.kredit)
                item.saldo = Helper.rupiah(item.saldo)
                return item
            })??[]
        },
        rekeningList(){
            const data = JSON.parse(JSON.stringify(this.rekening))
            return data?.map((item)=>{
                return {
                    code: item.id,
                    label: `${item.nomor_rekening} - ${item.nama_rekening}`
                }
            })
        }
    },
    watch: {
        page() {
            this.getData();
        },
        length() {
            this.requestData();
        },
    },
    methods: {
        requestData() {
            this.$inertia.get(route('buku_besar.index'), {
                page: this.page,
                length: this.length,
                searchQuery: this.searchQuery,
                rekeningQuery: this.selectedRekening
            });
        }
    }
};
</script>
