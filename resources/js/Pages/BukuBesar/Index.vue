<template>
    <Head title="Buku Besar" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Buku Besar
            </h2>
        </template>

        <!-- Tombol Tambah Buku Besar -->
        <CardBody>
            <template v-slot:content>
                <div class="flex flex-row space-x-4">
                    <div class="w-fit">
                        <p class="text-lg font-bold">Buku Besar</p>
                        <p>Isi data transaksi buku besar</p>
                        <div class="mt-4">
                            <Link :href="route('buku_besar.create')">
                                <PrimaryButton>+ Tambah</PrimaryButton>
                            </Link>
                        </div>
                    </div>
                </div>
            </template>
        </CardBody>

        <!-- Tabel Buku Besar -->
        <CardBody>
            <template v-slot:content>
                <Table
                    :headers="headers"
                    :data="tableData"
                    :startRow="startRow"
                    :links="links"
                    :lengthProps="lengthProps"
                    :deleteData="true"
                    deleteRoute="buku_besar.delete"
                    :edit-data="true"
                    edit-route="buku_besar.edit"
                    :totalData="totalData"
                    :endRow="endRow"
                    :actionUsingId=true
                    @refreshed-data="getData"
                    @click-page="page = $event"
                    @change-length="length = $event"
                    @on-search="searchQuery = $event"
                />
            </template>
        </CardBody>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import Table from '@/Components/Table.vue';
import CardBody from '@/Components/CardBody.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Helper from '@/Helper';
import axios from 'axios';

export default {
    components: {
        AuthenticatedLayout, Head, Link, Table, CardBody, PrimaryButton
    },
    data() {
        return {
            page: 1,
            length: 10,
            dataResponse: {},
            tableData: [],
            searchQuery: null,
        };
    },
    computed: {
        startRow() {
            return this.dataResponse.from ?? 0;
        },
        endRow() {
            return this.dataResponse.to ?? 0;
        },
        headers() {
            return ['kode_rekening.nama_kode_rekening', 'keterangan' ,'tanggal', 'debit', 'kredit', 'saldo'];
        },
        links() {
            return this.dataResponse.links ?? [];
        },
        totalData() {
            return this.dataResponse.total ?? 0;
        },
    },
    watch: {
        page() {
            this.getData();
        },
        length() {
            this.getData();
        },
        searchQuery() {
            this.getData();
        }
    },
    beforeMount() {
        this.getData();
    },
    methods: {
        getData() {
            axios.get(route('buku_besar.show', {
                page: this.page,
                length: this.length,
                searchQuery: this.searchQuery
            }))
            .then(response => {
                this.dataResponse = response.data;
                
                this.tableData = response.data.data.map(item => {
                    item.tanggal = Helper.tanggal(item.tanggal);
                    item.debit = Helper.rupiah(item.debit);
                    item.kredit = Helper.rupiah(item.kredit);
                    item.saldo = Helper.rupiah(item.saldo);
                    return item;
                });

              
            })
            .catch(error => {
                console.log(error);
            });
        }
    }
};
</script>
