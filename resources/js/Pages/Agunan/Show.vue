<template>
    <Head title="Daftar Agunan Berdasarkan Pinjaman" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Daftar Agunan untuk Pinjaman</h2>
        </template>

        <CardBody>
            <template v-slot:content>
                <!-- Pesan jika tidak ada agunan terkait -->
                <div v-if="agunans.length === 0" class="text-gray-600">
                    <p>Tidak ada agunan yang terkait dengan pinjaman ini.</p>
                </div>

                <!-- Tabel agunan jika ada data yang terkait -->
                <div v-else>
                    <div class="space-y-4">
                        <div v-for="agunan in agunans" :key="agunan.id" class="bg-white p-4 rounded-lg flex flex-col">
                            <div class="flex items-center mb-4">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">{{ agunan.jenis_agunan }}</h3>
                                    <p class="">
                                        <span class="text-xl font-bold">{{ formattedRupiah(agunan.nilai_agunan) }}</span>
                                    </p>
                                    <div class="text-sm text-gray-500 flex flex-row space-x-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 72 72"><path fill="#fff" d="m12 28.122l-.003 31.97l31.66-.006l16.09-12.048c-.008-.049.253-3.946.253-3.946l-.003-16z"/><path fill="#ea5a47" d="m12.194 28.292l47.803-.2l.003-16.47h-9.54l.052 5.273c1.727.456 2.15 3.087 2.15 3.087c-.022 2.192-2.678 2.53-2.69 2.527c-1.848-.378-2.489-1.282-2.468-2.802c.014-1.068.046-1.33.808-2.078c.513-.502.634-.608 1.311-.78l-.028-5.226H22.344l.07 5.226c1.728.456 2.293.853 2.276 2.719c-.02 2.193-2.706 3.28-2.719 3.28c-2.205-.02-2.992-1.037-2.971-3.242c.01-1.068.877-1.864 1.64-2.612c.511-.502.698-.822 1.375-.994l-.24-4.377H12z"/><path fill="#d0cfce" d="M59.997 48.038H43.138s-.898 6.104-.97 5.623v5.425l1.488 1z"/><g fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><circle cx="22.002" cy="19.849" r="3"/><path d="M26.006 12.122h20.05m7.96 0H60v16H12v-16h6.032m3.983-3.434v10.31"/><circle cx="50.003" cy="19.847" r="3"/><path d="M50.016 8.688v10.31m-15.68 19.094a5.63 5.63 0 0 1 5.513-4.494h0c1.554 0 2.96.63 3.98 1.649c1.584 1.584 1.437 4.217-.05 5.893l-9.558 10.78h4.76M23.276 37.398l5.073-3.8v18.321"/><path d="M11.997 28.092v32l31.659-.006l16.341-12.048V28.092"/><path d="M59.746 48.038H43.138v5.479"/></g></svg>
                                        <span>{{ agunan.tanggal_diserahkan }}</span>
                                    </div>
                                    <p class="text-sm text-gray-500 font-semibold uppercase">{{ agunan.status_agunan }}</p>
                                </div>
                            </div>
                            <img v-if="agunan.gambar_agunan" 
                                    :src="`/storage/${agunan.gambar_agunan}`" 
                                    alt="Gambar Agunan" 
                                    class="h-32 object-cover cursor-pointer mr-4"
                                    @click="showImage(agunan.gambar_agunan)">
                            <div v-else class="h-32 bg-gray-200 flex items-center justify-center mr-4">
                                <span class="text-gray-500">No Image</span>
                            </div>
                        
                        </div>
                    </div>
                </div>
            </template>
        </CardBody>

        <!-- Modal untuk menampilkan gambar agunan -->
        <div v-if="isModalOpen" 
             class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
             @click.self="closeImage"
        >
            <div class="bg-white p-4 w-3/4 rounded-lg shadow-lg">
                <img :src="`/storage/${modalImage}`" alt="Gambar Agunan" class="max-h-screen max-w-screen rounded-lg" />
                <button @click="closeImage" class="mt-4 bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Tutup</button>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
import CardBody from '@/Components/CardBody.vue';

export default {
    components: {
        AuthenticatedLayout, Head, CardBody
    },
    props: {
        pinjamanId: {
            type: Number,
            required: true
        },
        agunans: {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            isModalOpen: false,
            modalImage: null
        };
    },
    methods: {
        formattedRupiah(value) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(value);
        },
        showImage(imagePath) {
            this.modalImage = imagePath;
            this.isModalOpen = true;
        },
        closeImage() {
            this.isModalOpen = false;
            this.modalImage = null;
            document.removeEventListener('keydown', this.handleEscapeKey); // Remove event listener when closing the modal
        },
        handleEscapeKey(event) {
            if (event.key === 'Escape') {
                this.closeImage();
            }
        }
    }
}
</script>

<style scoped>
.fixed {
    position: fixed;
}
.inset-0 {
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
}
.flex {
    display: flex;
}
.items-center {
    align-items: center;
}
.justify-center {
    justify-content: center;
}
.bg-opacity-50 {
    background-color: rgba(0, 0, 0, 0.5);
}
.z-50 {
    z-index: 50;
}
</style>
