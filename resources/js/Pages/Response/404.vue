<template>
     <Head title="Error" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Error</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-2xl font-semibold">Tidak Ditemukan</p>
                        <p>Data yang anda cari tidak ditemukan</p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
export default {
    components:{
        AuthenticatedLayout,Head
    }
}
</script>