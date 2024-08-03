<template>
    <Head title="Akun" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Akun</h2>
        </template>

        <CardBody>
            <template v-slot:content>
                <div class="flex flex-row space-x-4">
                    <div class=" w-fit">
                        <p class=" text-lg font-bold">Buat akun baru</p>
                        <p>Daftarkan akun baru untuk mengakses fitur diaplikasi ini</p>
                        <div class="mt-4">
                            <Link :href="route('user.create')">
                                <PrimaryButton class="">+ Tambahkan akun</PrimaryButton>
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
                    :data="dataRow"
                    :startRow="startRow"
                    :links="links"
                    :lengthProps="lengthProps"
                    :deleteData="true"
                    deleteRoute="user.delete"
                    :editData="true"
                    editRoute="user.edit"
                    :totalData="totalData"
                    :endRow="endRow"
                    :actionUsingId=true
                    @refreshed-data="()=>{
                        getData()
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
import axios from 'axios';
import PrimaryButton from '@/Components/PrimaryButton.vue'
import Helper from '@/Helper.js'

export default {
    components:{
        AuthenticatedLayout,Head,Link, Table, CardBody,PrimaryButton
    },
    data() {
        return {
            dataUser:[],
            dataRow:[],
            page:1,
            length: 10,
            searchQuery:null,
        }
    },
    computed: {
        headers(){
            return ["name", "email", 'roles.name','created_at']
        },
        startRow(){
            return this.dataUser.from??1
        },
        endRow(){
            return this.dataUser.to??0
        },
        totalData(){
            return this.dataUser.total??0
        },
        links(){
            return this.dataUser.links??[]
        },
    },
    watch: {
        page(newVal){
            this.getData()
        },
        length(newVal){
            this.page = 1
            this.getData()
        },
        searchQuery(newVal){
            this.page = 1
            this.getData()
        },
        tahun(newVal){
            this.page = 1
            this.getData()
        },
        bulan(newVal){
            this.page = 1
            this.getData()
        },
        status(newVal){
            this.page = 1
            this.getData()
        },
    },
    beforeMount() {
        this.getData()
    },
    methods: {
        async getData(){
            const url = route('user.show', { 
                page: this.page,
                length : this.length,
                searchQuery: this.searchQuery,
             });
             
             const request = await axios.get(url);
             const response = request.data
             this.dataUser = response
             this.mappingData()
        },
        mappingData(){
            this.dataRow = [];
            if (this.dataUser?.data?.length > 0) {
                let data = this.dataUser.data.map((item) => {
                    item.nominal_diterima = Helper.rupiah(parseInt(item.nominal_diterima))
                    item.tanggal_jatuh_tempo = Helper.tanggal(item.tanggal_jatuh_tempo);
                    item.tanggal_pengajuan = Helper.tanggal(item.tanggal_pengajuan);
                    item.jumlah_pinjaman = Helper.rupiah(parseInt(item.jumlah_pinjaman))
                    item.roles = item.roles[0]
                    console.log(item)
                    return item
                })
                this.dataRow = data
            }else{
                return []
            }
        },
    },
}
</script>