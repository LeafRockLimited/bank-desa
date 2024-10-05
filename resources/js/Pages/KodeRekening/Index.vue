<template>
    <Head title="Kode Rekening" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Kode Rekening
            </h2>
        </template>

        <CardBody>
            <template v-slot:content>
                <div class="flex flex-row space-x-4">
                    <div class=" w-fit">
                        <p class=" text-lg font-bold">Kode Rekening</p>
                        <!-- description -->
                        <p> Isi data kode rekening</p>
                        <div class="mt-4">
                            <Link :href="route('kode_rekening.create',{jenis_rekening:jenis_rekening})">
                                <PrimaryButton class="">+ Tambah</PrimaryButton>
                            </Link>
                        </div>
                    </div>
                </div>
            </template>
        </CardBody>

        <CardBody>
            <template v-slot:content>
                <Table
                        :headers="headers"
                        :data="tableData"
                        :startRow="startRow"
                        :links="links"
                        :lengthProps="lengthProps"
                        :deleteData="true"
                        deleteRoute="kode_rekening.delete"
                        :edit-data="true"
                        edit-route="kode_rekening.edit"
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
                    </Table>
            </template>
        </CardBody>
    </AuthenticatedLayout>
    
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AdminLayout.vue';
import { Head,Link  } from '@inertiajs/vue3';
import Table from '@/Components/Table.vue';
import CardBody from '@/Components/CardBody.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'
import Helper from '@/Helper';

export default {
    components:{
        AuthenticatedLayout,Head,Link, Table, CardBody,PrimaryButton,SecondaryButton
    },
    props: {
        jenis_rekening:Object
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
    computed: {
        startRow() {
            return this.dataResponse.from??0
        },
        endRow() {
            return this.dataResponse.to??0
        },
        headers(){
            return ['nomor_rekening','nama_rekening', 'tipe', 'sub_tipe', 'deskripsi','created_at']
        },
        links(){
            return this.dataResponse.links??[]
        },
        totalData(){
            return this.dataResponse.total??0
        }
    },
    data() {
        return {
            page: 1,
            length: 10,
            dataResponse:{},
            tableData: [],
            searchQuery: null,
        }
    },
    beforeMount() {
      this.getData()  
    },
    methods: {
        getData(url = route('kode_rekening.show', { 
            jenis_rekening: this.jenis_rekening,
            page: this.page,
            length : this.length,
            searchQuery: this.searchQuery
         })) {
            try {
                axios.get(url).then(response => {
                    console.log(response.data)
                    this.dataResponse = response.data
                    this.tableData = response.data.data.map((item)=>{
                        item.created_at = Helper.tanggal(item.created_at)
                        return item
                    })
                })
            } catch (error) {
                console.log(error)
            }
        },

    }
} 
</script>