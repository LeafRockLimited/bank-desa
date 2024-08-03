<template>
   <Head title="Detail" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Nasabah</h2>
        </template>
        <CardBody>
            <template v-slot:content>
                <p class=" text-lg font-bold">Data Nasabah</p>
    
                <div class="space-y-4">
                    <!-- Nama Lengkap -->
                    <div>
                    <label for="nama_lengkap" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                    <input
                        id="nama_lengkap"
                        v-model="form.nama_lengkap"
                        type="text"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    />
                    <p v-if="errors.nama_lengkap" class="text-red-600 text-sm mt-1">{{ errors.nama_lengkap }}</p>
                    </div>
    
                    <!-- Alamat -->
                    <div>
                    <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                    <textarea
                        id="alamat"
                        v-model="form.alamat"
                        rows="4"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    ></textarea>
                    <p v-if="errors.alamat" class="text-red-600 text-sm mt-1">{{ errors.alamat }}</p>
                    </div>
    
                    <!-- Nomor Telepon -->
                    <div>
                    <label for="nomor_telepon" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                    <input
                        id="nomor_telepon"
                        v-model="form.nomor_telepon"
                        type="text"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    />
                    <p v-if="errors.nomor_telepon" class="text-red-600 text-sm mt-1">{{ errors.nomor_telepon }}</p>
                    </div>
    
                    <!-- Email -->
                    <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input
                        id="email"
                        v-model="form.email"
                        type="email"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    />
                    <p v-if="errors.email" class="text-red-600 text-sm mt-1">{{ errors.email }}</p>
                    </div>
    
                    <!-- Tanggal Lahir -->
                    <div>
                    <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                    <input
                        id="tanggal_lahir"
                        v-model="form.tanggal_lahir"
                        type="date"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    />
                    <p v-if="errors.tanggal_lahir" class="text-red-600 text-sm mt-1">{{ errors.tanggal_lahir }}</p>
                    </div>
    
                    <!-- Nomor Identitas -->
                    <div>
                    <label for="nomor_identitas" class="block text-sm font-medium text-gray-700">Nomor Identitas</label>
                    <input
                        id="nomor_identitas"
                        v-model="form.nomor_identitas"
                        type="text"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    />
                    <p v-if="errors.nomor_identitas" class="text-red-600 text-sm mt-1">{{ errors.nomor_identitas }}</p>
                    </div>
    
                    <!-- Pekerjaan -->
                    <div>
                    <label for="pekerjaan" class="block text-sm font-medium text-gray-700">Pekerjaan</label>
                    <input
                        id="pekerjaan"
                        v-model="form.pekerjaan"
                        type="text"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    />
                    <p v-if="errors.pekerjaan" class="text-red-600 text-sm mt-1">{{ errors.pekerjaan }}</p>
                    </div>
    
                    <!-- Submit Button -->
                    <div>
                    <button
                        @click="updateData"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        Simpan data nasabah
                    </button>
                    </div>
                </div>
    
            </template>
        </CardBody>
    </AuthenticatedLayout>


</template>

<script>
import AuthenticatedLayout from '@/Layouts/AdminLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import Table from '@/Components/Table.vue';
import CardBody from '@/Components/CardBody.vue';
import axios from 'axios';
import PrimaryButton from '@/Components/PrimaryButton.vue'


export default {
    components: {
        AuthenticatedLayout, Head, Table, CardBody, PrimaryButton
    },
    props:{
        nasabah:Object
    },
    data() {
        return {
            form:useForm({
                nama_lengkap: this.nasabah.nama_lengkap || '',
                alamat: this.nasabah.alamat || '',
                nomor_telepon: this.nasabah.nomor_telepon || '',
                email: this.nasabah.email || '',
                tanggal_lahir: this.nasabah.tanggal_lahir || '',
                nomor_identitas: this.nasabah.nomor_identitas || '',
                pekerjaan: this.nasabah.pekerjaan || ''
            }),
            errors: {}
        }
    },
    methods: {
        async updateData() {
            try {
                await axios.put(route('nasabah.update',this.nasabah), this.form);
                this.$inertia.visit(route('nasabah.index'));
            } catch (e) {
                console.log(e);
                this.errors = e.response.data.errors;
            }
        }
    },
}
</script>