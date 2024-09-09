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
                                <Link :href="route('angsuran.create')">
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
                        <template v-slot:filter>
                            <a :href="route('angsuran.download',{tahun : tahun, bulan: bulan})" class="border px-3 rounded-md border-gray-300 bg-gray-50 inline-flex items-center text-gray-600 space-x-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 32 32"><path fill="#20744a" fill-rule="evenodd" d="M28.781 4.405h-10.13V2.018L2 4.588v22.527l16.651 2.868v-3.538h10.13A1.16 1.16 0 0 0 30 25.349V5.5a1.16 1.16 0 0 0-1.219-1.095m.16 21.126H18.617l-.017-1.889h2.487v-2.2h-2.506l-.012-1.3h2.518v-2.2H18.55l-.012-1.3h2.549v-2.2H18.53v-1.3h2.557v-2.2H18.53v-1.3h2.557v-2.2H18.53v-2h10.411Z"/><path fill="#20744a" d="M22.487 7.439h4.323v2.2h-4.323zm0 3.501h4.323v2.2h-4.323zm0 3.501h4.323v2.2h-4.323zm0 3.501h4.323v2.2h-4.323zm0 3.501h4.323v2.2h-4.323z"/><path fill="#fff" fill-rule="evenodd" d="m6.347 10.673l2.146-.123l1.349 3.709l1.594-3.862l2.146-.123l-2.606 5.266l2.606 5.279l-2.269-.153l-1.532-4.024l-1.533 3.871l-2.085-.184l2.422-4.663z"/></svg>
                                <span>Download</span>
                            </a>
                            <TahunFilter 
                            @on-change="(value)=>{tahun = value}"/>
                            <BulanFilter @on-change="(value) => {bulan = value}"/>
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
import Helper from '@/Helper';
export default {
    components: {
        AuthenticatedLayout,Head,Link, Table,
        CardBody,PrimaryButton
    },
    computed: {
        startRow() {
            return this.rekeningResponse.from??0
        },
        endRow() {
            return this.rekeningResponse.to??0
        },
        headers(){
            return ['nama','created_at']
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
        }
    },
    methods: {
        getData() {
            axios.get(route('jenis_rekening.show'), {
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
        },
    },
    beforeMount() {
        this.getData()
    }
}
</script>