<template>
    <Head title="Proses pinjaman" />
  
    <AuthenticatedLayout>
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Formulir Peminjaman</h2>
      </template>
  
      <CardBody>
        <template v-slot:content>
          <div class="space-y-3">
            
            <!-- select nasabah component -->
              <div>
                <p>Pilih Nasabah</p>
                <NasabahSelect @on-change="(value)=>{form.nasabah_id = value}"></NasabahSelect>
                <span v-if="errors.nasabah_id" class="text-red-600 text-sm">{{ errors.nasabah_id }}</span>
              </div>
            <!-- end select nasabah component -->
            
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
  
            <div class="py-6 flex flex-row justify-between">
              <span class="text-lg font-medium text-gray-700">Nominal yang harus dibayar:</span>
              <span class="text-lg font-medium text-gray-700">{{ nominalBayarFormatted }}</span>
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
            <button @click="prosesPinjam" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              Buat Pinjaman
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
import NasabahSelect from '@/Components/NasabahSelect.vue';

export default {
    components: {
        AuthenticatedLayout, Head, Link, Table, CardBody, PrimaryButton,NasabahSelect
    },
    data() {
        return {
            form:useForm({
                nasabah_id: null,
                jenis_pinjaman: '',
                jumlah_pinjaman: 0,
                bunga: 0,
                tanggal_pengajuan: null,
                tanggal_disetujui: null,
                tanggal_jatuh_tempo: null,
                status_pinjaman: '',
            }),
            errors: {}
        }
    },
    beforeMount() {
       
    },
    computed: {
        nominalBayar() {
            return this.form.jumlah_pinjaman + (this.form.jumlah_pinjaman * (this.form.bunga / 100));
        },
        nominalBayarFormatted() {
            return this.formattedRupiah(this.nominalBayar);
        }
    },
    watch: {
       
    },
    methods: {
        formattedRupiah(value){
            return Helper.rupiah(value)
        },
        async prosesPinjam(){
          this.form.nominal_diterima = this.form.jumlah_pinjaman
            this.form.transform((data) => ({
                  ...data,
                  nominal_diterima: data.jumlah_pinjaman,
                })).post(route('pinjaman.store'),
              {
                onError: (errors) => {
                  this.errors = errors
                }
              }
            );
            
        }
    },
}
</script>

<style scoped>
.pagination {
    display: flex;
    margin: 0.25rem 0.25rem 0;
}

.pagination button {
    flex-grow: 1;
}

.pagination button:hover {
    cursor: pointer;
}
</style>