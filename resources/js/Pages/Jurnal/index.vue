<template>
    <Head title="Jurnal" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Jurnal
            </h2>
        </template>

        <CardBody>
            <template v-slot:content>
                <div class="flex flex-row space-x-4">
                    <div class=" w-fit">
                        <p class=" text-lg font-bold">Jurnal</p>
                        <!-- description -->
                        <p> Isi transaksi pada halaman jurnal</p>
                        <div class="flex flex-row items-center space-x-2 mt-4">
                            <div class="">
                                <Link :href="route('jurnal.create')">
                                    <PrimaryButton class="">+ Tambah</PrimaryButton>
                                </Link>
                            </div>
                            <div>
<!--                                    <input type="file" @change="handleFileChange">-->
                                <InputFile :allowedExtensions="['xlsx']" :url="route('jurnal.import')" @update:showModal="toggleModal" :show-modal="showModal" v-model="uploadedFiles"></InputFile>
                                <button @click="toggleModal" type="button" class="inline-flex items-center px-4 py-2 bg-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"><path fill="#fff" d="M10 2c2.817 0 4.415 1.923 4.647 4.246h.07C16.532 6.246 18 7.758 18 9.623q0 .143-.011.283a5.8 5.8 0 0 0-1.114-1.062c-.31-.933-1.163-1.598-2.157-1.598h-.071a1 1 0 0 1-.995-.9C13.45 4.325 12.109 3 10 3C7.886 3 6.551 4.316 6.348 6.345a1 1 0 0 1-.995.901h-.07C4.027 7.246 3 8.304 3 9.623C3 10.943 4.028 12 5.282 12h2.666a5.7 5.7 0 0 0-.177 1H5.282C3.469 13 2 11.488 2 9.623C2 7.82 3.373 6.347 5.102 6.251l.251-.005C5.587 3.908 7.183 2 10 2m3.5 7a4.5 4.5 0 1 1 0 9a4.5 4.5 0 0 1 0-9m1.602 4.898a.562.562 0 1 0 .796-.796l-2-2a.56.56 0 0 0-.796 0l-2 2a.562.562 0 1 0 .796.796L13 12.796V15.5a.5.5 0 0 0 1 0v-2.704z"/></svg>
                                    Upload
                                </button>
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
                    deleteRoute="jurnal.delete"
                    :edit-data="true"
                    edit-route="jurnal.edit"
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
import Table from '@/Components/Table.vue';
import CardBody from '@/Components/CardBody.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'
import Helper from '@/Helper';
import InputFile from "@/Components/InputFile.vue";

export default {
    components:{
        InputFile,
        AuthenticatedLayout,Head,Link, Table, CardBody,PrimaryButton,SecondaryButton
    },
    props: {
        jurnals: Object,
        search: String,
        length: Number
    },
    computed: {
        startRow() {
            return this.jurnals?.from??0
        },
        endRow() {
            return this.jurnals?.to??0
        },
        headers(){
            return ['no_bukti',
                'rekening.nomor_rekening',
                'rekening.nama_rekening',
                'debit',
                'kredit',
                'jumlah',
                'keterangan',
                'komponen_lak']
        },
        links(){
            return this.jurnals?.links??[]
        },
        totalData(){
            return this.jurnals?.total??0
        },
        tableData(){
            const data = JSON.parse(JSON.stringify(this.data))
            return data.map((item) => {
                item.debit = Helper.rupiah(item.debit??0)
                item.kredit = Helper.rupiah(item.kredit)
                item.jumlah = Helper.rupiah(item.jumlah)
                return item
            })??[]
        },
    },
    data() {
        return {
            data:this.jurnals.data,
            page: 1,
            lengthQuery: this.length,
            searchQuery: this.search,
            uploadedFiles:[],
            showModal:false,
        }
    },
    methods: {
        requestData(){
            this.$inertia.get(route('jurnal.index'),{
                page: this.page,
                length: this.lengthQuery,
                searchQuery: this.searchQuery
            })
        },
        async postData(){
            try {
                const url = route('jurnal.import')
                const formData = new FormData();
                formData.append('file',this.uploadedFile)
                const request = await axios.post(url,formData,{
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
            }
            catch (error) {
                console.log(error)
            }
        },
        handleFileChange(event){
          this.uploadedFile = event.target.files[0]
        },
        toggleModal(value){
            this.showModal = value??!this.showModal
        }
    }

}
</script>
