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
                       <div class="flex flex-row space-x-6 items-start">
                           <div class="mt-4">
                               <Link :href="route('kode_rekening.create')">
                                   <PrimaryButton class="">+ Tambah</PrimaryButton>
                               </Link>
                           </div>

                           <div class="mt-4 border p-4">
                               <label for="">Upload data Akun Rekening</label>
                               <form @submit.prevent="uploadFile" enctype="multipart/form-data">
                                   <input type="file" @change="handleFileChange" />
                                   <PrimaryButton class="" type="submit">Upload</PrimaryButton>
                               </form>
                           </div>
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
                        :lengthProps="lengthQuery"
                        :searchProps="searchQuery"
                        :deleteData="true"
                        deleteRoute="kode_rekening.delete"
                        :edit-data="true"
                        edit-route="kode_rekening.edit"
                        :totalData="totalData"
                        :endRow="endRow"
                        :actionUsingId=true
                        :with-pagination=false
                        @click-page="(value) => {
                            page = value
                        }"
                        @change-length="(value) => {
                            lengthQuery = value
                        }"
                        @on-search="(value) => {
                            searchQuery = value
                        }"
                        @action-success="(value)=>{
                            console.log(value)
                            requestData()
                        }"

                    >
                    <template v-slot:action="{item}">
                        <PrimaryButton @click="requestData">Cari</PrimaryButton>
                    </template>
                    </Table>
                <div class="grid grid-cols-1 lg:flex lg:flex-row lg:justify-between">
                    <span>Menampilkan data {{ startRow }} - {{ endRow }} dari {{ totalData }}</span>
                    <nav aria-label="Page navigation example">
                        <ul class="inline-flex -space-x-px text-base h-10">
                            <li v-for="(item, index) in links" :key="index">
                                <div @click="()=>{
                                    this.$inertia.get(item.url)
                                }" class="flex items-center justify-center
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
import { Head,Link  } from '@inertiajs/vue3';
import Table from '@/components/Table.vue';
import CardBody from '@/components/CardBody.vue';
import PrimaryButton from '@/components/PrimaryButton.vue'
import SecondaryButton from '@/components/SecondaryButton.vue'
import Helper from '@/Helper';
import Toast from "@/Toast.js";

export default {
    components:{
        AuthenticatedLayout,Head,Link, Table, CardBody,PrimaryButton,SecondaryButton
    },
    props: {
        rekening: Object,
        search: String,
        length: Number
    },
    computed: {
        startRow() {
            return this.rekening.from??0
        },
        endRow() {
            return this.rekening.to??0
        },
        headers(){
            return ['nomor_rekening','nama_rekening', 'saldo_normal','deskripsi']
        },
        links(){
            return this.rekening.links??[]
        },
        totalData(){
            return this.rekening.total??0
        },
        tableData(){
            return this.rekening.data
        },
    },
    watch: {
        lengthQuery() {
            this.requestData()
        }
    },
    data() {
        return {
            page: 1,
            lengthQuery: this.length,
            dataResponse:{},
            searchQuery: this.search,
            uploadedFile:null
        }
    },
    methods: {
        requestData(){
            this.$inertia.get(route('kode_rekening.index'),{
                page: this.page,
                length: this.lengthQuery,
                searchQuery: this.searchQuery
            })
        },
        async uploadFile(){
            try {
                const formData = new FormData();
                formData.append('file', this.uploadedFile)
                const request = await axios.post(route('kode_rekening.import'), formData)
                const response = request.data
                this.dataResponse = response
                Toast.fire('Berhasil','File Berhasil disimpan','success');
            }
            catch (error) {
                Toast.fire('Gagal','File gagal disimpan','error');
            }

        },
        handleFileChange(event){
          this.uploadedFile = event.target.files[0]
            console.log(this.uploadedFile)
        }
    }

}
</script>
