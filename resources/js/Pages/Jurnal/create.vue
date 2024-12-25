<template>
    <Head title="Jurnal" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tambah Jurnal
            </h2>
        </template>

        <CardBody>
            <template v-slot:content>
                <div class="grid grid-cols-1 gap-6">
                    <div class=" w-full">
                        <p class="text-lg font-bold">Isi form jurnal transaksi</p>
                    </div>

                    <div class="grid grid-cols-1 gap-6">
                        <div class="grid grid-flow-row grid-cols-2 items-end gap-4">
                            <div class="">
                                <label for="nomor_bukti" class="block text-sm font-medium text-gray-700">Nomor Bukti</label>
                                <input id="nomor_bukti" type="text" v-model="form.no_bukti"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                       placeholder="01/RPR-LP/I/2024" />
                                <p class="text-red-600 text-sm mt-1"></p>
                            </div>

                            <!-- Rekening -->
                            <div class="">
                                <label for="rekening" class="block text-sm font-medium text-gray-700">Rekening</label>
                                <v-select class="mt-1" id="rekening" v-model="form.id_rekening"
                              :label="label"
                              :reduce="(rekenings) => rekenings.code"
                              taggable :options="rekenings">
                                </v-select>
                                <p  class="text-red-600 text-sm mt-1"></p>
                            </div>
                        </div>

                        <div class="">
                            <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal Transaksi</label>
                            <VueDatePicker teleport-center auto-position="bottom" format="yyyy-MM-dd" v-model="form.tanggal_transaksi"></VueDatePicker>
                        </div>

                        <div class="grid grid-flow-row grid-cols-2 items-end gap-4">
                            <div>
                                <label for="debit" class="block text-sm font-medium text-gray-700">Debit</label>
                                <InputCurrency @update:value="(value) => {form.debit = isNaN(value)? 0 :value}"></InputCurrency>
                            </div>
                            <div>
                            <label for="kredit" class="block text-sm font-medium text-gray-700">Kredit</label>
                                <InputCurrency @update:value="(value) => {form.kredit = isNaN(value)? 0 :value}"></InputCurrency>
                            </div>
                        </div>


                        <div class="grid grid-flow-row grid-cols-2 items-end gap-4">
                            <!-- Keterangan Field -->
                            <div class="">
                                <label for="keterangan_transaksis" class="block text-sm font-medium text-gray-700">Keterangan Transaksi</label>
                                <v-select
                                    id="keterangan_transaksis" v-model="form.keterangan" taggable :options="keteranganTransaksis">
                                </v-select>
                                <p  class="text-red-600 text-sm mt-1"></p>
                            </div>

                            <!-- Komponent LAK -->
                            <div class="">
                                <label for="komponen_lak" class="block text-sm font-medium text-gray-700">Komponen Laporan Arus Kas</label>
                                <v-select id="komponen_lak" v-model="form.komponen_lak" taggable :options="komponenLaks">
                                </v-select>
                                <p  class="text-red-600 text-sm mt-1"></p>
                            </div>
                        </div>


                        <div class="flex justify-center">
                            <primary-button @click="store">Simpan</primary-button>
                        </div>
                    </div>
                </div>
            </template>
        </CardBody>
    </AuthenticatedLayout>

</template>
<script>

import {Head, useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AdminLayout.vue";
import CardBody from "@/Components/CardBody.vue";
import moment from "moment";
import Helper from "@/Helper.js";
import InputCurrency from "@/Components/InputCurrency.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Toast from "@/Toast.js";

export default {
    components: {PrimaryButton, InputCurrency, CardBody, AuthenticatedLayout, Head},
    props:{
        rekening: Array,
        komponen_lak : Array,
        keterangan_transaksi: Array
    },
    watch: {
        form: {
            deep: true,
        },
    },
    computed: {
        Helper() {
            return Helper
        },
        rekenings(){
            return this.rekening?.map((item) => {
                return {
                    code: item.id,
                    label: `${item.nomor_rekening} - ${item.nama_rekening}`
                }
            })
        },
        komponenLaks() {
            return this.komponen_lak?.map((item) => {
                return item.name
            })??[];
        },
        keteranganTransaksis(){
            return this.keterangan_transaksi?.map((item) => {
                return item.name
            })??[]
        }
    },
    data() {
        return {
            form: useForm({
                'no_bukti' : '',
                'id_rekening' : null,
                'debit' : 0,
                'kredit' : 0,
                'keterangan' : '',
                'tanggal_transaksi' : moment().format('YYYY-MM-DD'),
                'komponen_lak' : '',
            })
        }
    },
    methods: {
        async store() {
            try {
                await axios.post(route('jurnal.store'), this.form);
                Toast.fire('Berhasil','jurnal berhasil disimpan','success');
                this.$inertia.visit(route('jurnal.index'));
            } catch (error) {
                Toast.fire('Gagal','jurnal gagal disimpan','error');
            }
        }
    }
}

</script>
