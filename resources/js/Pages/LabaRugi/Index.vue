<template>
    <Head title="Laba Rugi"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Laba Rugi
            </h2>
        </template>

        <!-- Tabel Buku Besar -->
        <CardBody>

            <template v-slot:content>

                <table class="divide-y w-full divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            Rekening
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            Uraian
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            Uraian
                        </td>
                    </tr>
                    </thead>
<!--                    <tbody>-->
<!--                        <tr class="transition duration-300 ease-in-out hover:bg-gray-100">-->
<!--                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{laba_rugi_data.kode_4.rekening}}</td>-->
<!--                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{laba_rugi_data.kode_4.label}}</td>-->
<!--                        </tr>-->

<!--                        <tr class="transition duration-300 ease-in-out hover:bg-gray-100">-->
<!--                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{laba_rugi_data.kode_4.kode_1.rekening}}</td>-->
<!--                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{laba_rugi_data.kode_4.kode_1.label}}</td>-->
<!--                        </tr>-->
<!--                        <tr class="transition duration-300 ease-in-out hover:bg-gray-100">-->
<!--                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{laba_rugi_data.kode_4.kode_1['01'].nomor_rekening}}</td>-->
<!--                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{laba_rugi_data.kode_4.kode_1['01'].nama_rekening}}</td>-->
<!--                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{laba_rugi_data.kode_4.kode_1['01'].laba_rugi.total_this_month}}</td>-->
<!--                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{laba_rugi_data.kode_4.kode_1['01'].laba_rugi.total_till_this_month}}</td>-->
<!--                        </tr>-->
<!--                        <tr class="transition duration-300 ease-in-out hover:bg-gray-100">-->
<!--                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{laba_rugi_data.kode_4.kode_1['02']?.nomor_rekening}}</td>-->
<!--                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{laba_rugi_data.kode_4.kode_1['02']?.nama_rekening}}</td>-->
<!--                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{laba_rugi_data.kode_4.kode_1['02']?.laba_rugi?.total_this_month>>0}}</td>-->
<!--                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{laba_rugi_data.kode_4.kode_1['02']?.laba_rugi?.total_till_this_month>>0}}</td>-->
<!--                        </tr>-->
<!--                        <tr class="transition duration-300 ease-in-out hover:bg-gray-100">-->
<!--                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{laba_rugi_data.kode_4.kode_1['03']?.nomor_rekening}}</td>-->
<!--                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{laba_rugi_data.kode_4.kode_1['03']?.nama_rekening}}</td>-->
<!--                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{laba_rugi_data.kode_4.kode_1['03']?.laba_rugi?.total_this_month>>0}}</td>-->
<!--                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{laba_rugi_data.kode_4.kode_1['03']?.laba_rugi?.total_till_this_month>>0}}</td>-->
<!--                        </tr>-->
<!--                        <tr class="transition duration-300 ease-in-out hover:bg-gray-100">-->
<!--                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{laba_rugi_data.kode_4.kode_1['04']?.nomor_rekening}}</td>-->
<!--                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{laba_rugi_data.kode_4.kode_1['04']?.nama_rekening}}</td>-->
<!--                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{laba_rugi_data.kode_4.kode_1['04']?.laba_rugi?.total_this_month>>0}}</td>-->
<!--                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{laba_rugi_data.kode_4.kode_1['04']?.laba_rugi?.total_till_this_month>>0}}</td>-->
<!--                        </tr>-->
<!--                        <tr class="transition duration-300 ease-in-out hover:bg-gray-100">-->
<!--                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{laba_rugi_data.kode_4.kode_1['05']?.nomor_rekening}}</td>-->
<!--                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{laba_rugi_data.kode_4.kode_1['05']?.nama_rekening}}</td>-->
<!--                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{laba_rugi_data.kode_4.kode_1['05']?.laba_rugi?.total_this_month>>0}}</td>-->
<!--                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{laba_rugi_data.kode_4.kode_1['05']?.laba_rugi?.total_till_this_month>>0}}</td>-->
<!--                        </tr>-->
<!--                        <tr class="transition duration-300 ease-in-out hover:bg-gray-100">-->
<!--                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{laba_rugi_data.kode_4.kode_1['06']?.nomor_rekening}}</td>-->
<!--                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{laba_rugi_data.kode_4.kode_1['06']?.nama_rekening}}</td>-->
<!--                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{laba_rugi_data.kode_4.kode_1['06']?.laba_rugi?.total_this_month>>0}}</td>-->
<!--                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{laba_rugi_data.kode_4.kode_1['06']?.laba_rugi?.total_till_this_month>>0}}</td>-->
<!--                        </tr>-->
<!--                        <tr class="transition duration-300 ease-in-out hover:bg-gray-100">-->
<!--                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{laba_rugi_data.kode_4.kode_1['07']?.nomor_rekening}}</td>-->
<!--                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{laba_rugi_data.kode_4.kode_1['07']?.nama_rekening}}</td>-->
<!--                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{laba_rugi_data.kode_4.kode_1['07']?.laba_rugi?.total_this_month>>0}}</td>-->
<!--                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{laba_rugi_data.kode_4.kode_1['07']?.laba_rugi?.total_till_this_month>>0}}</td>-->
<!--                        </tr>-->
<!--                        <tr class="transition duration-300 ease-in-out hover:bg-gray-100">-->
<!--                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{laba_rugi_data.kode_4.kode_1['08']?.nomor_rekening}}</td>-->
<!--                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{laba_rugi_data.kode_4.kode_1['08']?.nama_rekening}}</td>-->
<!--                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{laba_rugi_data.kode_4.kode_1['08']?.laba_rugi?.total_this_month>>0}}</td>-->
<!--                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{laba_rugi_data.kode_4.kode_1['08']?.laba_rugi?.total_till_this_month>>0}}</td>-->
<!--                        </tr>-->
<!--                        <tr class="transition duration-300 ease-in-out hover:bg-gray-100">-->
<!--                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{laba_rugi_data.kode_4.kode_1['09']?.nomor_rekening}}</td>-->
<!--                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{laba_rugi_data.kode_4.kode_1['09']?.nama_rekening}}</td>-->
<!--                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{laba_rugi_data.kode_4.kode_1['09']?.laba_rugi?.total_this_month>>0}}</td>-->
<!--                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{laba_rugi_data.kode_4.kode_1['09']?.laba_rugi?.total_till_this_month>>0}}</td>-->
<!--                        </tr>-->
<!--                        <tr class="transition duration-300 ease-in-out hover:bg-gray-100">-->
<!--                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{laba_rugi_data.kode_4.kode_1['10']?.nomor_rekening}}</td>-->
<!--                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{laba_rugi_data.kode_4.kode_1['10']?.nama_rekening}}</td>-->
<!--                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{laba_rugi_data.kode_4.kode_1['10']?.laba_rugi?.total_this_month>>0}}</td>-->
<!--                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{laba_rugi_data.kode_4.kode_1['10']?.laba_rugi?.total_till_this_month>>0}}</td>-->
<!--                        </tr>-->
<!--                        <tr class="transition duration-300 ease-in-out hover:bg-gray-100">-->
<!--                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{laba_rugi_data.kode_4.kode_1['11']?.nomor_rekening}}</td>-->
<!--                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{laba_rugi_data.kode_4.kode_1['11']?.nama_rekening}}</td>-->
<!--                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{laba_rugi_data.kode_4.kode_1['11']?.laba_rugi?.total_this_month>>0}}</td>-->
<!--                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{laba_rugi_data.kode_4.kode_1['11']?.laba_rugi?.total_till_this_month>>0}}</td>-->
<!--                        </tr>-->

<!--&lt;!&ndash;                        <tr>&ndash;&gt;-->
<!--&lt;!&ndash;                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{laba_rugi_data.kode_4.kode_2}}</td>&ndash;&gt;-->
<!--&lt;!&ndash;                        </tr>&ndash;&gt;-->
<!--&lt;!&ndash;                        <tr>&ndash;&gt;-->
<!--&lt;!&ndash;                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{laba_rugi_data.kode_4.kode_3}}</td>&ndash;&gt;-->
<!--&lt;!&ndash;                        </tr>&ndash;&gt;-->



<!--                    </tbody>-->
                </table>

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
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Helper from '@/Helper';
import TahunFilter from "@/Components/TahunFilter.vue";
import BulanFilter from "@/Components/BulanFilter.vue";
import moment from "moment";
export default {
    components: {
        BulanFilter,
        TahunFilter,
        AuthenticatedLayout, Head, Link, Table, CardBody, PrimaryButton
    },
    props: {
        length: Number,
        search: String,
        laba_rugi_data:Array
    },
    data() {
        return {
            page: 1,
            length: 10,
            dataResponse: {},
            searchQuery: this.search,
            selectedRekening: null,
            selectedYear: moment().year(),
            selectedBulan: moment().month()
        };
    },
    beforeMount() {
        let data = JSON.parse(JSON.stringify(this.laba_rugi_data))
        let kode_4 = data['kode_4']

        let sub_kode_4 = {
            'label' : kode_4.label,
            'rekening' : kode_4.rekening
        }

        sub_kode_4['sub'] = Object.values(kode_4).filter((item) => {
            if (typeof item == 'object'){
                return item
            }
        }).map((item) => {

            let sub_data = Object.values(item).map((sub_item) => {
                return {
                    'label' : sub_item.nama_rekening,
                    'rekening' : sub_item.nomor_rekening,
                    'laba_rugi' : sub_item.laba_rugi
                }
            })

            const total_data = sub_data.reduce((total, item) => {
                return {
                    'total_this_month' : item?.laba_rugi?.total_this_month??0 + total?.laba_rugi?.total_this_month,
                    'total_till_this_month' : item?.laba_rugi?.total_till_this_month??0 + total?.laba_rugi?.total_till_this_month
                }

            },{
                'total_this_month' : 0,
                'total_till_this_month' : 0
            })

            // console.log(total_data)

            return {
                'total' : total_data,
                'detail' : sub_data
            }
        })


        console.log(sub_kode_4)

    },
    computed: {
        rekeningList(){
            const data = JSON.parse(JSON.stringify(this.rekening_props))
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
            this.requestData();
        },
        length() {
            this.requestData();
        },
    },
    methods: {
        requestData() {
          try {
            this.$inertia.get(route('laba_rugi.index'), {
                page: this.page,
                length: this.length,
                searchQuery: this.searchQuery,
                rekeningQuery: this.selectedRekening['code'],
                yearQuery: this.selectedYear,
                monthQuery: this.selectedBulan
            });
          } catch (error) {
            console.log(error);
          }
        }
    }
};
</script>
