<template>
    <Head title="Edit Pinjaman" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Formulir Peminjaman</h2>
        </template>

        <CardBody>
            <template v-slot:content>
                <div class="space-y-3">
                    <p class="text-xl font-semibold">Perbarui data peminjaman</p>
                    <v-select v-model="form.nasabah_id" :options="dataNasabah" :filterable="false" @search="onSearch">
                        <template #list-footer>
                            <li class="flex flex-row space-x-2 justify-center">
                                <button :class="{ 'bg-gray-100 !text-black': hasPrevPage == true }" @click="page -= 1" class="w-full h-8 text-gray-200" :disabled="!hasPrevPage">Prev</button>
                                <button :class="{ 'bg-gray-100 !text-black': hasNextPage == true }" @click="page += 1" class="w-full h-8 text-gray-200" :disabled="!hasNextPage">Next</button>
                            </li>
                        </template>
                    </v-select>
                    <span v-if="errors.nasabah_id" class="text-red-600 text-sm">{{ errors.nasabah_id }}</span>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jenis Pinjaman</label>
                        <select v-model="form.jenis_pinjaman" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="mingguan">Mingguan</option>
                            <option value="bulanan">Bulanan</option>
                            <option value="musiman">Musiman</option>
                            <option value="tahunan">Tahunan</option>
                        </select>
                        <span v-if="errors.jenis_pinjaman" class="text-red-600 text-sm">{{ errors.jenis_pinjaman }}</span>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jumlah Pinjaman</label>
                        <input type="number" v-model="form.jumlah_pinjaman" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                        <label class="block text-sm font-medium text-gray-700 text-end">{{ formattedRupiah(form.jumlah_pinjaman) }}</label>
                        <span v-if="errors.jumlah_pinjaman" class="text-red-600 text-sm">{{ errors.jumlah_pinjaman }}</span>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Bunga (%)</label>
                        <input type="number" step="0.01" v-model="form.bunga" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                        <span v-if="errors.bunga" class="text-red-600 text-sm">{{ errors.bunga }}</span>
                    </div>

                    <div class="py-6 grid grid-cols-1 lg:flex lg:flex-row lg:justify-between">
                        <span class="lg:text-lg lg:font-medium text-gray-700">Nominal yang harus dibayar:</span>
                        <span class="lg:text-lg font-bold text-gray-700">{{ nominalBayarFormatted }}</span>
                    </div>

                    <hr>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal Pengajuan</label>
                        <input type="date" v-model="form.tanggal_pengajuan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                        <span v-if="errors.tanggal_pengajuan" class="text-red-600 text-sm">{{ errors.tanggal_pengajuan }}</span>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal Disetujui</label>
                        <input type="date" v-model="form.tanggal_disetujui" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                        <span v-if="errors.tanggal_disetujui" class="text-red-600 text-sm">{{ errors.tanggal_disetujui }}</span>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal Jatuh Tempo</label>
                        <input type="date" v-model="form.tanggal_jatuh_tempo" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                        <span v-if="errors.tanggal_jatuh_tempo" class="text-red-600 text-sm">{{ errors.tanggal_jatuh_tempo }}</span>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status Pinjaman</label>
                        <select v-model="form.status_pinjaman" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="pending">Pending</option>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                            <option value="paid">Paid</option>
                        </select>
                        <span v-if="errors.status_pinjaman" class="text-red-600 text-sm">{{ errors.status_pinjaman }}</span>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button @click="updateDataHandler" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Simpan Perubahan
                    </button>
                </div>
            </template>
        </CardBody>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Table from '@/Components/Table.vue';
import CardBody from '@/Components/CardBody.vue';
import axios from 'axios';
import PrimaryButton from '@/Components/PrimaryButton.vue'
import Helper from '@/Helper.js'

export default {
    components: {
        AuthenticatedLayout, Head, Link, Table, CardBody, PrimaryButton
    },
    props:{
        pinjaman:Object
    },
    data() {
        return {
            nasabahs: {},
            page: 1,
            searchQuery: null,
            form:useForm({
                nasabah_id: this.pinjaman.mapped_nasabah,
                jenis_pinjaman: this.pinjaman.jenis_pinjaman,
                jumlah_pinjaman: parseInt(this.pinjaman.nominal_diterima),
                bunga: parseFloat(this.pinjaman.bunga),
                tanggal_pengajuan: this.pinjaman.tanggal_pengajuan,
                tanggal_disetujui: this.pinjaman.tanggal_disetujui,
                tanggal_jatuh_tempo: this.pinjaman.tanggal_jatuh_tempo,
                status_pinjaman: this.pinjaman.status_pinjaman,
            }),
            errors: {}
        }
    },
    beforeMount() {
        this.getNasabah()
    },
    watch: {
        page() {
            this.getNasabah()
        },
        searchQuery() {
            this.getNasabah()
        }
    },
    computed: {
        dataNasabah() {
            return this.nasabahs.data?.map((item) => {
                return {
                    code: item.id,
                    label: item.nama_lengkap
                }
            })
        },
        hasNextPage() {
            return this.nasabahs.next_page_url != null ?? false
        },
        hasPrevPage() {
            return this.page > 1
        },
        nominalBayar() {
            return this.form.jumlah_pinjaman + (this.form.jumlah_pinjaman * (this.form.bunga / 100));
        },
        nominalBayarFormatted() {
            return this.formattedRupiah(this.nominalBayar);
        }
    },
    methods: {
        async getNasabah() {
            const request = await axios.get(route('nasabah.show', {
                page: this.page,
                searchQuery: this.searchQuery

            }));
            if (request.status == 200) {
                const response = request.data;
                this.nasabahs = response
            }
        },
        onSearch(value) {
            this.searchQuery = value
        },
        formattedRupiah(value){
            return Helper.rupiah(value)
        },
        async prosesPinjam(){
            try {
                this.form.nasabah_id = this.form.nasabah_id?.code??null;
                this.form.nominal_diterima = this.form.jumlah_pinjaman

                const request = await axios.post(route('pinjaman.store'),this.form);
                const response = request.data;
                this.$inertia.visit(route('pinjaman.index'));
            } catch (error) {
                
                this.errors = error.response.data.errors;
            }
        },
        async updateDataHandler(){
            try {

                this.form.nasabah_id = this.form.nasabah_id?.code??null;
                this.form.nominal_diterima = this.form.jumlah_pinjaman
                console.log(this.form);
                const request = await axios.put(route('pinjaman.update',this.pinjaman.id),this.form);
                this.$inertia.visit(route('pinjaman.index'));
            } catch (error) {
                this.errors = error.response.data.errors;
            }
        }
    },
}
</script>