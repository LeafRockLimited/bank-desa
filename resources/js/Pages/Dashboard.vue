
<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 gap-6">
                <p class="text-3xl font-semibold text-neutral-500">Overview</p>

                <div class="grid grid-cols-1 lg:grid-flow-row lg:grid-cols-3 gap-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                        <!-- jumlah nominal transaksi -->
                            <div class="p-6 inline-block space-y-4">
                                <div class="text-gray-500 inline-flex items-center space-x-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="currentColor" d="M17.576 10.48a.75.75 0 0 0-1.152-.96l-1.797 2.156c-.37.445-.599.716-.786.885a.764.764 0 0 1-.163.122l-.011.005l-.011-.005a.767.767 0 0 1-.164-.122c-.187-.17-.415-.44-.786-.885l-.292-.35c-.328-.395-.625-.75-.901-1c-.301-.272-.68-.514-1.18-.514c-.5 0-.878.242-1.18.514c-.276.25-.572.605-.9 1l-1.83 2.194a.75.75 0 1 0 1.153.96l1.797-2.156c.37-.445.599-.716.786-.885a.764.764 0 0 1 .163-.122l.011-.005l.011.005a.767.767 0 0 1 .164.122c.187.17.415.44.786.885l.292.35c.329.395.625.75.901 1c.301.272.68.514 1.18.514c.5 0 .878-.242 1.18-.514c.276-.25.572-.605.9-1z"/><path fill="currentColor" fill-rule="evenodd" d="M11.943 1.25c-2.309 0-4.118 0-5.53.19c-1.444.194-2.584.6-3.479 1.494c-.895.895-1.3 2.035-1.494 3.48c-.19 1.411-.19 3.22-.19 5.529v.114c0 2.309 0 4.118.19 5.53c.194 1.444.6 2.584 1.494 3.479c.895.895 2.035 1.3 3.48 1.494c1.411.19 3.22.19 5.529.19h.114c2.309 0 4.118 0 5.53-.19c1.444-.194 2.584-.6 3.479-1.494c.895-.895 1.3-2.035 1.494-3.48c.19-1.411.19-3.22.19-5.529v-.114c0-2.309 0-4.118-.19-5.53c-.194-1.444-.6-2.584-1.494-3.479c-.895-.895-2.035-1.3-3.48-1.494c-1.411-.19-3.22-.19-5.529-.19zM3.995 3.995c.57-.57 1.34-.897 2.619-1.069c1.3-.174 3.008-.176 5.386-.176s4.086.002 5.386.176c1.279.172 2.05.5 2.62 1.069c.569.57.896 1.34 1.068 2.619c.174 1.3.176 3.008.176 5.386s-.002 4.086-.176 5.386c-.172 1.279-.5 2.05-1.069 2.62c-.57.569-1.34.896-2.619 1.068c-1.3.174-3.008.176-5.386.176s-4.086-.002-5.386-.176c-1.279-.172-2.05-.5-2.62-1.069c-.569-.57-.896-1.34-1.068-2.619c-.174-1.3-.176-3.008-.176-5.386s.002-4.086.176-5.386c.172-1.279.5-2.05 1.069-2.62" clip-rule="evenodd"/></svg>
                                     <span>Transaksi bulan ini </span>
                                </div>
                                <p class=" inline-flex space-x-2">
                                    <p class="text-xl font-semibold">{{angsuran.bulan_ini}}</p>
                                    <div class="inline-flex space-x-1">
                                        <badge v-show="angsuran.selisih > 0" class="text-sm text-green-500 inline-flex items-center bg-green-100 px-3 py-1 rounded-full space-x-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10.5" height="12" viewBox="0 0 448 512"><path fill="currentColor" d="M246.6 41.4c-12.5-12.5-32.8-12.5-45.3 0l-160 160c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L224 109.3l137.4 137.3c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3l-160-160zm160 352l-160-160c-12.5-12.5-32.8-12.5-45.3 0l-160 160c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L224 301.3l137.4 137.3c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3z"/></svg>
                                            <span>{{angsuran.persentase}} %</span>
                                        </badge>
                                        <badge v-show="angsuran.selisih == 0" class="text-sm text-orange-500 inline-flex items-center bg-orange-100 px-3 py-1 rounded-full space-x-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 7.927C6.667 4.928 9.333 5.806 12 8s5.333 3.072 8 .073M4 15.927c2.667-2.999 5.333-2.121 8 .073s5.333 3.072 8 .073" color="currentColor"/></svg>
                                            <span>{{angsuran.persentase}} %</span>
                                        </badge>
                                        <badge v-show="angsuran.selisih < 0" class="text-sm text-red-500 inline-flex items-center bg-red-100 px-3 py-1 rounded-full space-x-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10.5" height="12" viewBox="0 0 448 512"><path fill="currentColor" d="M246.6 470.6c-12.5 12.5-32.8 12.5-45.3 0l-160-160c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L224 402.7l137.4-137.3c12.5-12.5 32.8-12.5 45.3 0s12.5 32.8 0 45.3l-160 160zm160-352l-160 160c-12.5 12.5-32.8 12.5-45.3 0l-160-160c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L224 210.7L361.4 73.4c12.5-12.5 32.8-12.5 45.3 0s12.5 32.8 0 45.3z"/></svg>
                                            <span>{{angsuran.persentase}} %</span>
                                        </badge>
                                    </div>
                                </p>
                                <span class="text-gray-500 text-xs inline-flex items-center"> 
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="m8 18.98l-.708-.713l3.095-3.094H3v-1h7.387l-3.095-3.094l.708-.713l4.308 4.307zm8-5.365l-4.308-4.307L16 5l.708.714l-3.094 3.094H21v1h-7.386l3.094 3.094z"/></svg>
                                    <span>Perbandingan bulan lalu</span>
                                </span>
                            </div>
                        <!-- end jumlah nominal transaksi -->


                        
                    </div>


                <!-- jumlah nasbaah -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 grid grid-cols-1 space-y-4">
                            <div class="text-gray-500 inline-flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" d="M8 13h8c1.71 0 3.15 1.28 3.35 2.98L20 21.5M8 13a7.459 7.459 0 0 1-5.618-5.472L2 6m6 7v5c0 1.886 0 2.828.586 3.414C9.172 22 10.114 22 12 22c1.886 0 2.828 0 3.414-.586C16 20.828 16 19.886 16 18v-1"/><circle cx="12" cy="6" r="4"/></g></svg>
                                    <span>Nasabah tahun ini </span>
                            </div>
                            <div class=" inline-flex space-x-2">
                                <p class="text-lg font-semibold">{{ nasabah.tahun_ini }} Nasabah</p>
                                <div class="inline-flex space-x-1">
                                    <badge v-show="nasabah.selisih > 0" class="text-sm text-green-500 inline-flex items-center bg-green-100 px-3 py-1 rounded-full space-x-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10.5" height="12" viewBox="0 0 448 512"><path fill="currentColor" d="M246.6 41.4c-12.5-12.5-32.8-12.5-45.3 0l-160 160c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L224 109.3l137.4 137.3c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3l-160-160zm160 352l-160-160c-12.5-12.5-32.8-12.5-45.3 0l-160 160c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L224 301.3l137.4 137.3c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3z"/></svg>
                                        <span>{{ nasabah.persentase }} %</span>
                                    </badge>
                                    <badge v-show="nasabah.selisih < 0" class="text-sm text-red-500 inline-flex items-center bg-red-100 px-3 py-1 rounded-full space-x-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10.5" height="12" viewBox="0 0 448 512"><path fill="currentColor" d="M246.6 470.6c-12.5 12.5-32.8 12.5-45.3 0l-160-160c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L224 402.7l137.4-137.3c12.5-12.5 32.8-12.5 45.3 0s12.5 32.8 0 45.3l-160 160zm160-352l-160 160c-12.5 12.5-32.8 12.5-45.3 0l-160-160c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L224 210.7L361.4 73.4c12.5-12.5 32.8-12.5 45.3 0s12.5 32.8 0 45.3z"/></svg>
                                        <span>{{ nasabah.persentase }} %</span>
                                    </badge>
                                </div>
                            </div>
                            <span class="text-gray-500 text-xs inline-flex items-center"> 
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="m8 18.98l-.708-.713l3.095-3.094H3v-1h7.387l-3.095-3.094l.708-.713l4.308 4.307zm8-5.365l-4.308-4.307L16 5l.708.714l-3.094 3.094H21v1h-7.386l3.094 3.094z"/></svg>
                                <span>Perbandingan tahun lalu</span>
                            </span>
                        </div>
                    </div>
                <!-- end jumlah nasabah -->
                </div>


            </div>
        </div>
    </AuthenticatedLayout>
</template>


<script>
import AuthenticatedLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
import Helper from '@/Helper.js';

export default {
    components:{
        AuthenticatedLayout,Head
    },
    beforeMount() {
        this.getNasabahRekap()
        this.getAngsuranRekap()
    },
    data() {
        return {
            nasabah:{
                "tahun_ini":0,
                "tahun_lalu":0,
                "selisih":0,
                "persentase":0,
            },
            angsuran:{
                "bulan_ini":0,
                "tahun_lalu":0,
                "selisih":0,
                "persentase":0,
            }
        }
    },
    methods: {
        async getNasabahRekap(){
            const request = await axios.get(route('nasabah.rekap_tahunan'))
            const response = request.data
            response.persentase = parseInt(response.persentase)
            this.nasabah = response
        },
        async getAngsuranRekap(){
            const request = await axios.get(route('angsuran.rekap_bulanan'))
            const response = request.data
            response.persentase = parseInt(response.persentase)
            response.bulan_ini = Helper.rupiah(response.bulan_ini)
            this.angsuran = response
        }
    },
}
</script>