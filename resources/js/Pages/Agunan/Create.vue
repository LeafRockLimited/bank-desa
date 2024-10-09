<template>
    <Head title="Tambah Agunan" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Formulir Agunan</h2>
        </template>

        <CardBody>
            <template v-slot:content>
                <div class="space-y-3">
                    <!-- Jenis Agunan -->

                   
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jenis Agunan</label>
                        <v-select
                        taggable
                        :options="['Rumah','Kendaraan','Tanah','Barang Berharga']"
                        v-model="form.jenis_agunan"
                        label="Jenis Agunan"
                        ></v-select>
                        <span v-if="errors.jenis_agunan" class="text-red-600 text-sm">{{ errors.jenis_agunan[0] }}</span>
                    </div>

                    <!-- Nilai Agunan -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nilai Agunan</label>
                        <input type="number" v-model="form.nilai_agunan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                        <span v-if="errors.nilai_agunan" class="text-red-600 text-sm">{{ errors.nilai_agunan[0] }}</span>
                    </div>

                    <!-- Deskripsi Agunan -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Deskripsi Agunan</label>
                        <textarea v-model="form.deskripsi_agunan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                        <span v-if="errors.deskripsi_agunan" class="text-red-600 text-sm">{{ errors.deskripsi_agunan[0] }}</span>
                    </div>

                    <!-- Tanggal Diserahkan -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal Diserahkan</label>
                        <input type="date" v-model="form.tanggal_diserahkan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                        <span v-if="errors.tanggal_diserahkan" class="text-red-600 text-sm">{{ errors.tanggal_diserahkan[0] }}</span>
                    </div>

                    <!-- Status Agunan -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status Agunan</label>
                        <select v-model="form.status_agunan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="tercatat">Tercatat</option>
                            <option value="diserahkan">Diserahkan</option>
                            <option value="dilepaskan">Dilepaskan</option>
                        </select>
                        <span v-if="errors.status_agunan" class="text-red-600 text-sm">{{ errors.status_agunan[0] }}</span>
                    </div>

                    <!-- Gambar Agunan -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">File Jaminan</label>
                        <input type="file" @change="handleFileChange" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                        <span v-if="errors.gambar_agunan" class="text-red-600 text-sm">{{ errors.gambar_agunan [0]}}</span>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button @click="prosesAgunan" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Tambahkan Agunan
                    </button>
                </div>
            </template>
        </CardBody>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AdminLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import CardBody from '@/Components/CardBody.vue';

export default {
    components: {
        AuthenticatedLayout, Head, CardBody
    },
    props: {
        pinjaman: {
            type: Number,
            required: true
        }
    },
    data() {
        return {
            form: useForm({
                pinjaman_id: this.pinjaman,  // Pinjaman ID akan diambil dari props
                jenis_agunan: '',
                nilai_agunan: 0,
                deskripsi_agunan: '',
                tanggal_diserahkan: null,
                status_agunan: '',
                gambar_agunan: null, // Untuk menyimpan file gambar
            }),
            errors: {}
        }
    },
    methods: {
        handleFileChange(event) {
            this.form.gambar_agunan = event.target.files[0]; // Simpan file gambar ke form
        },
        async prosesAgunan() {
           

            try {

                const request = await axios.post(route('agunan.store'), this.form,{
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                })
                console.log(request)
                this.$inertia.visit(route('pinjaman.index'));
               
            } catch (error) {

                if (error.response.status == 422) {
                    this.errors = error.response.data.errors
                }
                // console.error(error);
            }
        }
    }
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
