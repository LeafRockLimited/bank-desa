<template>
    <Head title="Akun" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Nasabah</h2>
        </template>

        <CardBody>
            <template v-slot:content>
                
                <div class="space-y-4">
                    <p class=" text-lg font-bold">Buat akun baru</p>
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                        <input id="name" v-model="form.name" type="text"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                        <p v-if="errors.name" class="text-red-600 text-sm mt-1">{{ errors.name }}</p>
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input id="email" v-model="form.email" type="text"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                        <p v-if="errors.email" class="text-red-600 text-sm mt-1">{{ errors.email }}</p>
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input id="password" v-model="form.password" type="password"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                        <p v-if="errors.password" class="text-red-600 text-sm mt-1">{{ errors.password }}</p>
                    </div>
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                        <select id="role" v-model="form.role" class="w-full bg-gray-50 border border-gray-300 text-gray-900 
                            text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 
                            block p-2.5">
                                <option value="admin">Admin</option>
                                <option value="teller">Teller</option>
                                <option value="nasabah">Nasabah</option>
                            </select>
                            <p v-if="errors.role" class="text-red-600 text-sm mt-1">{{ errors.role }}</p>
                    </div>
                    <div>
                        <button @click="postData"
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Simpan
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
    data() {
        return {
            form: useForm({
                'name' : null,
                'email' : null,
                'password' : null,
                'role' : null
            }),
            errors: {}
        }
    },
    methods: {
        async postData() {
            try {
                await axios.post(route('user.store'), this.form);
                this.$inertia.visit(route('user.index'));
            } catch (e) {
                this.errors = e.response.data.errors;
            }
        }
    },
}
</script>