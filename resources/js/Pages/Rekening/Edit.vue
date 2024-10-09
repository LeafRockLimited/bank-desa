<template>
    <Head title="Rekening" />
 
     <AuthenticatedLayout>
         <template #header>
             <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Rekening</h2>
         </template>
 
         <CardBody>
             <template v-slot:content>
                 <div class="grid grid-cols-1 gap-6">
                     
                     <div class=" w-full">
                         <p class=" text-lg font-bold">Tambah Rekening</p>
                         <!-- description -->
                         <p> Isi formulir rekening baru</p>
                     </div>
 
 
                     <div class="grid grid-cols-1 gap-6">
                         <div class="">
                             <label for="nama_lengkap" class="block text-sm font-medium text-gray-700">Id Jenis Rekening</label>
                             <input id="nama_lengkap" v-model="form.id_jenis" type="text"
                                 class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                             <p v-if="errors.id_jenis" class="text-red-600 text-sm mt-1">{{ errors.id_jenis }}</p>
                         </div>
 
                         <div class="">
                             <label for="nama_lengkap" class="block text-sm font-medium text-gray-700">Nama Rekening</label>
                             <input id="nama_lengkap" v-model="form.nama" type="text"
                                 class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                             <p v-if="errors.nama" class="text-red-600 text-sm mt-1">{{ errors.nama }}</p>
                         </div>
                         
                         <button @click="sumbit">
                             <PrimaryButton class="">Ubah</PrimaryButton>
                         </button>
 
                     </div>
                     
                 </div>
             </template>
         </CardBody>
 
     </AuthenticatedLayout>
     
 
 </template>
 
 <script>
 import AuthenticatedLayout from '@/Layouts/AdminLayout.vue';
 import { Head,Link, useForm  } from '@inertiajs/vue3';
 import PrimaryButton from '@/Components/PrimaryButton.vue'
 import CardBody from '@/Components/CardBody.vue';
 import Toast from '@/Toast';
 
 export default {
     components:{
         AuthenticatedLayout,Head,Link, PrimaryButton,CardBody
     },
     props:{
        jenisRekening:Object
     },
     data() {
         return {
             form:useForm({
                 id_jenis:this.jenisRekening.id_jenis,
                 nama:this.jenisRekening.nama
             }),
             errors:{}
         }
     },
     methods: {
         async sumbit(){
             try {
 
                 await axios.put(route('jenis_rekening.update',{id:this.jenisRekening.id}), this.form);
                 
                 Toast.fire({
                     icon: 'success',
                     title: 'Data berhasil di simpan',
                 })
                 this.$inertia.visit(route('jenis_rekening.index'));
             } catch (error) {
                 console.log(error)
                 Toast.fire({
                     icon: 'error',
                     title: 'Data gagal di simpan',
                 })
             }
         }
     },
 }
 </script>