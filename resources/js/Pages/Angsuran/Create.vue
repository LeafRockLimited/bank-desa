<template>
<Head title="Angsuran" />

<AuthenticatedLayout>
  <template #header>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Angsur Pinjaman</h2>
  </template>

  <CardBody>
    <template v-slot:content>
      <div class="space-y-4">

        <!-- select nasabah component -->
        <div>
          <p>Pilih Nasabah</p>
          <NasabahSelect @on-change="(value)=> { 
            selectedNasabah = value
          }"></NasabahSelect>
        </div>
        <!-- end select nasabah component -->


        <!-- select pinjaman component -->
         <div>
          <p>Pinjaman Nasabah</p>
           <PinjamanSelect :nasabah_id="selectedNasabah" @on-change="(value) => { 
              form.pinjaman_id = value.id
              selectedPinjaman = value
            }"
            :dataComplete="true"></PinjamanSelect>
          <span v-if="errors.pinjaman_id" class="text-red-600 text-sm">{{ errors.pinjaman_id }}</span>
        </div>
        <!-- end select pinjaman component -->


        <!-- Tanggal Bayar -->
        <div>
          <label for="tanggal_bayar" class="block text-sm font-medium text-gray-700">Tanggal Bayar</label>
          <input id="tanggal_bayar" v-model="form.tanggal_bayar" type="date"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
          <p v-if="errors.tanggal_bayar" class="text-red-600 text-sm mt-1">{{ errors.tanggal_bayar }}</p>
        </div>

        <!-- Jumlah Bayar -->
        <div>
          <label for="jumlah_bayar" class="block text-sm font-medium text-gray-700">Jumlah Bayar</label>
          <input id="jumlah_bayar" v-model="form.jumlah_bayar" type="number"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
            <p v-if="errors.jumlah_bayar" class="text-red-600 text-sm mt-1">{{ errors.jumlah_bayar }}</p>
            <span class="block text-sm font-medium text-gray-700 text-end">{{ nominalBayarFormatted }}</span>
        </div>


        <!-- pembayaran -->
        <div class="w-full self-end py-6 space-y-4">
          <div class="flex flex-row border-b justify-between text-md font-medium text-gray-700"><span>Total Pinjaman :</span> <span>{{ formattedRupiah(selectedPinjaman.jumlah_pinjaman) }}</span></div>
          <div class="flex flex-row border-b justify-between text-md font-medium text-gray-700"><span>Dibayar :</span> <span>{{ formattedRupiah(form.jumlah_bayar) }}</span></div>
          
          <span class="block text-xl font-medium text-gray-700 text-end">Sisa Pinjaman : {{ formattedRupiah(parseInt(angsuranTerakhir?.sisa_pinjaman??0) - parseInt(form.jumlah_bayar)) }}</span>
        </div>
        <!-- end pembayaran -->

        <!-- Submit Button -->
        <div class="mt-6 flex justify-end">
          <button @click="submitForm"
            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Simpan Angsuran
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
import Table from '@/Components/Table.vue';
import CardBody from '@/Components/CardBody.vue';
import axios from 'axios';
import PrimaryButton from '@/Components/PrimaryButton.vue'
import Helper from '@/Helper.js'
import NasabahSelect from '@/Components/NasabahSelect.vue';
import PinjamanSelect from '@/Components/PinjamanSelect.vue';

export default {
  components: {
    AuthenticatedLayout, Head, Link, Table, CardBody,
    PrimaryButton, NasabahSelect, PinjamanSelect
  },
  data() {
    return {
      selectedNasabah: null,
      selectedPinjaman:{
        bunga: 0,
        created_at: null,
        id: null,
        jenis_pinjaman: null,
        jumlah_pinjaman: 0,
        nasabah: null,
        nasabah_id: null,
        nominal_diterima: 0,
        status_pinjaman: null,
        tanggal_disetujui: null,
        tanggal_jatuh_tempo: null,
        tanggal_pengajuan: null,
        updated_at: null
      },
      angsuranTerakhir:{
        pinjaman_id: null,
        tanggal_bayar: 0,
        jumlah_bayar: 0,
        bunga: 0,
        sisa_pinjaman: 0,
      },
      form: useForm({
        pinjaman_id: null,
        tanggal_bayar: null,
        jumlah_bayar: 0,
        bunga: 0
      }),
      errors: {}
    }
  },
  computed: {
    nominalBayarFormatted() {
        return this.formattedRupiah(this.form.jumlah_bayar);
    }
  },
  watch: {
    form:{
      handler(value, oldVal) {
        
      },
      deep:true,
      immediate:true
    },
    selectedPinjaman(){
      this.getAngsuranTerakhir()
    }
  },
  methods: {
    async submitForm() {
      try {
        await axios.post(route('angsuran.store'), this.form);
        this.$inertia.visit(route('angsuran.index'));

      } catch (error) {
        if (error.response && error.response.status === 422) {
          this.errors = error.response.data.errors;
        }
      }
    },
    formattedRupiah(value){
        if (Array.isArray(value)) {
          value = value.reduce((partialSum, a) => partialSum + a, 0)
        }
        return Helper.rupiah(value)
    },
    async getAngsuranTerakhir(){
      try {
        const request = await axios.get(route('angsuran.angsuran_terakhir',{id: this.form.pinjaman_id}))
        const response = request.data
        
       

        if (Object.keys(response).length > 0) {
          this.angsuranTerakhir = response
        }else{
          this.angsuranTerakhir = {
            pinjaman_id: null,
            tanggal_bayar: 0,
            jumlah_bayar: 0,
            bunga: 0,
            sisa_pinjaman: this.selectedPinjaman.jumlah_pinjaman,
          }
        }

      } catch (error) {
        
      }
    }
  }
}
</script>