<template>
    <Head title="Rekening" />

       <AuthenticatedLayout>
           <template #header>
               <h2 class="font-semibold text-xl text-gray-800 leading-tight">Rekening</h2>
           </template>

           <CardBody>
                <template v-slot:content>
                    <div class="flex flex-row space-x-4">
                        <div class=" w-fit">
                            <p class=" text-lg font-bold">Rekening</p>
                            <!-- description -->
                            <p> Isi data rekening untuk transaksi buku kas, untuk memudahkan proses transaksi yang ada didalam aplikasi</p>
                            <div class="mt-4">
                                <Link :href="route('jenis_rekening.create')">
                                    <PrimaryButton class="">+ Tambah</PrimaryButton>
                                </Link>
                            </div>
                        </div>
                    </div>
                </template>
            </CardBody>


            <!-- table content -->
            <CardBody>
                <template v-slot:content>
                    <Table
                        :headers="headers"
                        :data="tableData"
                        :startRow="startRow"
                        :links="links"
                        :lengthProps="lengthProps"
                        :deleteData="true"
                        deleteRoute="jenis_rekening.delete"
                        :edit-data="true"
                        edit-route="jenis_rekening.edit"
                        :totalData="totalData"
                        :endRow="endRow"
                        :actionUsingId=true
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

                        <template #options="{item}">
                            <SecondaryButton @click="()=>{$inertia.visit(route('kode_rekening.index',{jenis_rekening:item.id}))}">
                                daftar kode rekening
                            </SecondaryButton>
                        </template>
                    </Table>
                </template>
            </CardBody>
            <!-- end table content -->
       </AuthenticatedLayout>
       
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AdminLayout.vue';
import { Head,Link  } from '@inertiajs/vue3';
import Table from '@/Components/Table.vue';
import CardBody from '@/Components/CardBody.vue';
import axios from 'axios';
import PrimaryButton from '@/Components/PrimaryButton.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'
import Helper from '@/Helper';

export default {
    components: {
        AuthenticatedLayout,Head,Link, Table,
        CardBody,PrimaryButton,SecondaryButton
    },
    computed: {
        startRow() {
            return this.rekeningResponse.from??0
        },
        endRow() {
            return this.rekeningResponse.to??0
        },
        headers(){
            return ['id_jenis','nama','created_at']
        },
        links(){
            return this.rekeningResponse.links??[]
        },
        totalData(){
            return this.rekeningResponse.total??0
        }
    },
    data() {
        return {
            page: 1,
            length: 10,
            rekeningResponse:{},
            tableData: [],
            searchQuery: null,
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
        }
    },
    methods: {
        getData() {
            try {
                axios.get(route('jenis_rekening.show_all'), {
                    params: {
                        page: this.page,
                        length: this.length,
                        search: this.searchQuery
                    }
                }).then(response => {
                    this.rekeningResponse = response.data
                    
                    this.tableData = response.data.data.map((item) => {
                        item.created_at = Helper.tanggal(item.created_at)
                        return item
                    })
                })
            } catch (error) {
                throw error
            }
        },
    },
    beforeMount() {
        this.getData()
    }
}
</script>