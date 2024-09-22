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
                        <p class=" text-lg font-bold">Isi form kode rekenig</p>
                        <!-- description -->
                        <p> Isi formulir kode rekening baru</p>
                    </div>

                    <div class="grid grid-cols-1 gap-6">
                        <div class="">
                            <label for="nama_lengkap" class="block text-sm font-medium text-gray-700">Nomor Kode Rekening</label>
                            <input id="nama_lengkap" v-model="form.nomor_rekening" type="text"
                                @input="formatNumber($event)"
                                class="mt-1 block w-full border-gray-300 rounded-md 
                                shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                :placeholder="jenis_rekening.id+'.x.x.x...'" />
                            <p v-if="errors.nomor_rekening" class="text-red-600 text-sm mt-1">{{ errors.nomor_rekening[0] }}</p>
                        </div>

                        <div class="">
                            <label for="nama_lengkap" class="block text-sm font-medium text-gray-700">Tipe Akun</label>
                            <input id="nama_lengkap" v-model="form.jenis_saldo" type="text"
                                class="mt-1 block w-full border-gray-300 rounded-md 
                                shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" 
                                placeholder="Kredit atau Debit"
                                />
                            <p v-if="errors.jenis_saldo" class="text-red-600 text-sm mt-1">{{ errors.jenis_saldo[0] }}</p>
                        </div>

                        <div class="">
                            <label for="nama_lengkap" class="block text-sm font-medium text-gray-700">Nama Rekening</label>
                            <input id="nama_lengkap" v-model="form.nama_kode_rekening" type="text"
                                class="mt-1 block w-full border-gray-300 rounded-md 
                                shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" 
                                placeholder="Nama kode rekening"
                                />
                            <p v-if="errors.nama_kode_rekening" class="text-red-600 text-sm mt-1">{{ errors.nama_kode_rekening[0] }}</p>
                        </div>

                        <button @click="sumbit">
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
import { Head,Link, useForm  } from '@inertiajs/vue3';
import CardBody from '@/Components/CardBody.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue'
import Toast from '@/Toast';
import axios from 'axios';

export default {
    components:{
        AuthenticatedLayout,Head,Link, CardBody,PrimaryButton
    },
    props: {
        jenis_rekening:Object
    },
    data() {
        return {
            form:useForm({
                jenis_rekening_id:this.jenis_rekening.id,
                nomor_rekening:null,
                jenis_saldo: null,
                nama_kode_rekening:null
            }),
            errors:{},
            blockSizes: [1], // Ukuran setiap blok dalam array
            separator: '.',
        }
    },
    computed: {
        
    },
    methods: {
        formatNumber(event) {
            let rawNumber = event.target.value.replace(/\D/g, ''); // Menghapus semua karakter non-digit
            let formatted = [];
            let startIndex = 0;
            let blockIndex = 0; // Index untuk mengulang array blockSizes

            // Loop untuk memformat nomor dengan blok
            while (startIndex < rawNumber.length) {
                const size = this.blockSizes[blockIndex % this.blockSizes.length]; // Mengulang ukuran blok dengan modulo
                const block = rawNumber.substr(startIndex, size);
                
                if (block) {
                formatted.push(block);
                }
                startIndex += size;
                blockIndex++; // Pindah ke index blok berikutnya
            }

            // Gabungkan blok-blok dengan separator
            this.form.nomor_rekening = formatted.join(this.separator);
        },
        async sumbit(){
            try {
                await axios.post(route('kode_rekening.store'),this.form)
                Toast.fire({
                    icon: 'success',
                    title: 'Data Berhasil disimpan',
                })
                this.$inertia.visit(route('kode_rekening.index',{jenis_rekening: this.jenis_rekening.id}));
            } catch (error) {
                if (error.response.status === 422) {
                    this.errors = error.response.data.errors
                }
                Toast.fire({
                    icon: 'error',
                    title: 'Data gagal disimpan',
                })
            }
        }
        
    }
}
</script>