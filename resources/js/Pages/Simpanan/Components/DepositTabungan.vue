<template>
    <Head title="Setor Tabungan" />

        <Card class="w-full mx-auto p-6  rounded-lg shadow">
            <h2 class="text-2xl font-bold mb-4">Setor Tabungan</h2>
            <form @submit.prevent="submitSetoran">
                <!-- Input Rekening Simpanan -->
                <div class="mb-4">
                    <Label>Rekening Simpanan</Label>
                    <Input v-model="form.rekening_simpanan" type="text" class="w-full" required />
                </div>

                <!-- Input Nominal Setoran -->
                <div class="mb-4">
                    <Label>Nominal Setoran</Label>
                    <Input v-model.number="form.nominal" type="number" min="10000" class="w-full" required />
                </div>

                <!-- Tombol Simpan -->
                <Button type="submit" class="w-full mt-4" :disabled="isSubmitting">
                    {{ isSubmitting ? "Menyimpan..." : "Setor Tabungan" }}
                </Button>
            </form>
        </Card>
</template>

<script setup>
import { ref } from 'vue';
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Card from '@/components/ui/card/Card.vue';



const isSubmitting = ref(false);
const form = ref({
    rekening_simpanan: '',
    nominal: ''
});

const submitSetoran = async () => {
    isSubmitting.value = true;
    await axios.post(route('simpanan.deposit'), form.value, {
        onFinish: () => (isSubmitting.value = false),
        onSuccess: () => alert('Setoran berhasil!')
    });
};
</script>
