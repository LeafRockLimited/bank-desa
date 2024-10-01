<template>
    <Head title="Edit Transaksi Buku Besar" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Transaksi Buku Besar
            </h2>
        </template>

        <CardBody>
            <template v-slot:content>
                <form @submit.prevent="submitForm">
                    <!-- Dropdown Kode Rekening menggunakan Vue Select -->
                    <div class="mb-4">
                        <label for="id_kode_rekening" class="block text-gray-700">Kode Rekening</label>
                        <v-select 
                            v-model="form.id_kode_rekening" 
                            :options="kodeRekenings"
                            :reduce="rekening => rekening.id"
                            :loading="isLoading"
                            @search="fetchKodeRekening"
                            :pagination="pagination"
                            label="nama_kode_rekening"
                            placeholder="Pilih kode rekening"
                        />
                    </div>

                    <div class="mb-4">
                        <label for="tanggal" class="block text-gray-700">Tanggal</label>
                        <input v-model="form.tanggal" type="date" id="tanggal" class="w-full border-gray-300 rounded-md" />
                    </div>

                    <div class="mb-4">
                        <label for="debit" class="block text-gray-700">Debit</label>
                        <input v-model="form.debit" type="number" id="debit" class="w-full border-gray-300 rounded-md" />
                    </div>

                    <div class="mb-4">
                        <label for="kredit" class="block text-gray-700">Kredit</label>
                        <input v-model="form.kredit" type="number" id="kredit" class="w-full border-gray-300 rounded-md" />
                    </div>

                    <!-- Keterangan Field -->
                    <div class="mb-4">
                        <label for="keterangan" class="block text-gray-700">Keterangan</label>
                        <textarea v-model="form.keterangan" id="keterangan" rows="3"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            placeholder="Tambahkan keterangan transaksi"></textarea>
                    </div>

                    <PrimaryButton type="submit">Update</PrimaryButton>
                </form>
            </template>
        </CardBody>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AdminLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import CardBody from '@/Components/CardBody.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import axios from 'axios';
import vSelect from 'vue-select';

export default {
    props: {
        bukuBesar: Object,  // Prop untuk menerima data buku besar dari controller
        kodeRekenings: Array // Prop untuk menerima data kode rekening
    },
    components: {
        AuthenticatedLayout, Head, CardBody, PrimaryButton, vSelect
    },
    data() {
        return {
            form: useForm({
                id_kode_rekening: this.bukuBesar.id_kode_rekening, // Diisi dengan data yang ada
                tanggal: this.bukuBesar.tanggal, 
                debit: parseInt(this.bukuBesar.debit),
                kredit: parseInt(this.bukuBesar.kredit),
                keterangan: this.bukuBesar.keterangan // Keterangan yang sudah ada
            }),
            kodeRekenings: [], 
            pagination: {
                page: 1,
                length: 10
            },
            isLoading: false,
            searchQuery: null
        };
    },
    methods: {
        // Fetch data kode rekening with search query and pagination
        fetchKodeRekening(search = null) {
            this.isLoading = true;

            const params = {
                searchQuery: search,
                length: this.pagination.length,
                page: this.pagination.page
            };

            axios.get(route('kode_rekening.show'), { params })
                .then(response => {
                    this.kodeRekenings = response.data.data; // Update options with paginated data
                    this.pagination = {
                        ...this.pagination,
                        total: response.data.total,
                        links: response.data.links
                    };
                })
                .finally(() => {
                    this.isLoading = false;
                });
        },

        // Submit form data for updating the record
        submitForm() {
            axios.put(route('buku_besar.update', this.bukuBesar.id), this.form)
                .then(() => {
                    this.$inertia.visit(route('buku_besar.index'));
                })
                .catch(error => {
                    console.log(error);
                });
        }
    },
    mounted() {
        // Fetch initial data for kode rekening
        this.fetchKodeRekening();
    }
};
</script>
