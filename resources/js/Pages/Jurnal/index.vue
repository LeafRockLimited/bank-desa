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
                        <div class="mt-4">
                            <Link :href="route('jurnal.create')">
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

export default {
    components:{
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
            searchQuery: this.search
        }
    },
    methods: {
        requestData(){
            this.$inertia.get(route('jurnal.index'),{
                page: this.page,
                length: this.lengthQuery,
                searchQuery: this.searchQuery
            })
        }
    }

}
</script>
