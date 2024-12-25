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
                <div class="grid grid-cols-1 gap-6">

                    <div class=" w-full">
                        <p class="text-lg font-bold">Isi form kode rekening</p>
                        <p>Isi formulir kode rekening baru</p>
                    </div>

                    <div class="grid grid-cols-1 gap-6">
                        <!-- Nomor Kode Rekening -->
                        <div class="">
                            <label for="nomor_rekening" class="block text-sm font-medium text-gray-700">Nomor Kode Rekening</label>
                            <input id="nomor_rekening" v-model="form.nomor_rekening" type="text"
                                @input="formatNumber($event)"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                :placeholder="'.x.x.x...'" />
                            <p v-if="errors.nomor_rekening" class="text-red-600 text-sm mt-1">{{ errors.nomor_rekening[0] }}</p>
                        </div>

                        <!-- Nama Rekening -->
                        <div class="">
                            <label for="nama_rekening" class="block text-sm font-medium text-gray-700">Nama Rekening</label>
                            <input id="nama_rekening" v-model="form.nama_rekening" type="text"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                placeholder="Nama kode rekening"
                                />
                            <p v-if="errors.nama_rekening" class="text-red-600 text-sm mt-1">{{ errors.nama_rekening[0] }}</p>
                        </div>

                        <!-- Tipe Akun -->
                        <div class="">
                            <label for="tipe" class="block text-sm font-medium text-gray-700">Saldo Normal</label>
                            <v-select v-model="form.saldo_normal" taggable :options="['Debit','Kredit']">
                            </v-select>
                            <p v-if="errors.sub_tipe" class="text-red-600 text-sm mt-1">{{ errors.sub_tipe[0] }}</p>
                        </div>

                        <!-- Status -->
                        <div class="">
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select id="status" v-model="form.status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="aktif">Aktif</option>
                                <option value="nonaktif">Nonaktif</option>
                            </select>
                            <p v-if="errors.status" class="text-red-600 text-sm mt-1">{{ errors.status[0] }}</p>
                        </div>

                        <!-- Deskripsi -->
                        <div class="">
                            <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                            <textarea id="deskripsi" v-model="form.deskripsi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Deskripsi kode rekening"></textarea>
                            <p v-if="errors.deskripsi" class="text-red-600 text-sm mt-1">{{ errors.deskripsi[0] }}</p>
                        </div>

                        <!-- Tombol Tambah -->
                        <button @click="submit">
                            <PrimaryButton class="">+ Tambah Kode Rekening</PrimaryButton>
                        </button>
                    </div>
                </div>
            </template>
        </CardBody>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import CardBody from '@/Components/CardBody.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Toast from '@/Toast';
import axios from 'axios';
import NumberFormating from "@/Service/NumberFormating.js";

export default {
    components: {
        AuthenticatedLayout, Head, Link, CardBody, PrimaryButton
    },
    props: {

    },
    data() {
        return {
            form: useForm({
                nomor_rekening: null,
                nama_rekening: null,
                saldo_normal: null,
                status: 'aktif',
                deskripsi: null,
            }),
            errors: {},
            blockSizes: [1], // Ukuran setiap blok dalam array
            separator: '.',
        }
    },
    computed: {
        tipeList(){
            return []
        },
        subTipeList(){
           return []
        }
    },
    methods: {
        formatNumber(event) {
            const value = event.target.value;
            const formatRekening = NumberFormating.rekeningFormat(value)
            this.form.nomor_rekening = formatRekening;
        },
        async submit() {
            try {
                await axios.post(route('kode_rekening.store'), this.form);
                Toast.fire({
                    icon: 'success',
                    title: 'Data Berhasil disimpan',
                });
                this.$inertia.visit(route('kode_rekening.index'));
            } catch (error) {
                if (error.response.status === 422) {
                    this.errors = error.response.data.errors;
                }
                Toast.fire({
                    icon: 'error',
                    title: 'Data gagal disimpan',
                });
            }
        }
    }
}
</script>
