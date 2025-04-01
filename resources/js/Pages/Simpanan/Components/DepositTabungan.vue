<template>
    <Head title="Setor Tabungan" />

        <Card class="w-full mx-auto p-6  rounded-lg shadow">
            <h2 class="text-2xl font-bold mb-4">Setor Tabungan</h2>
            <form @submit.prevent="submitSetoran" class="space-y-4">
                <!-- Input Rekening Simpanan -->
                <div class="">
                    <Label>Rekening Simpanan</Label>
                    <DropdownInfinite v-if="selectedNasabahData != null"
                    :url="route('simpanan.tabungan_nasabah',{'nasabah_id':selectedNasabahData.id})"
                    label-key="rekening_simpanan"
                    value-key="rekening_simpanan"
                    @on-select="(value) => {
                        form.rekening_simpanan = value.rekening_simpanan
                    }"
                    placeholder="pilih rekening"
                    ></DropdownInfinite>
                    <p v-else>
                        Pilih nasabah untuk melihat detail
                    </p>
                </div>


                <!-- riwayat tabungan button -->
                 <p class="text-sm" v-if="form.rekening_simpanan">
                    Lihat riwayat transaksi
                 </p>

                <!-- Input Nominal Setoran -->
                <div class="mb-4">
                    <Label>Nominal Setoran</Label>
                    <CurrencyInput
                    v-model="form.nominal"
                    :min="10000"
                    ></CurrencyInput>
                </div>

                <!-- Tombol Simpan -->
                <Button type="submit" class="w-full mt-4" :disabled="isSubmitting">
                    {{ isSubmitting ? "Menyimpan..." : "Setor Tabungan" }}
                </Button>
            </form>
        </Card>
</template>

<script setup>
import { ref, watch } from 'vue';
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Card from '@/components/ui/card/Card.vue';
import DropdownInfinite from '@/components/Input/DropdownInfinite.vue';
import CurrencyInput from '@/components/Input/CurrencyInput.vue';
import { onErrorCaptured } from 'vue';
import { useToast } from '@/components/ui/toast';

const props = defineProps({
    selectedNasabahData: Object
})

const isSubmitting = ref(false);
const form = ref({
    rekening_simpanan : null,
    nominal: ''
});

watch(() => props.selectedNasabahData, (newNasabah) => {
    console.log(newNasabah)
}, { immediate: true });


const submitSetoran = async () => {
    isSubmitting.value = true;
    await axios.post(route('simpanan.deposit'), form.value)
    .then((result) => {
        toast({
            title: 'Berhasil setor tabungan',
            description: `${new Date().toLocaleString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })}`,
        });
    })
    .catch((err) => {
        toast({
            title: 'Gagal setor tabungan',
            variant: 'destructive',
        });
    })

    isSubmitting.value = false;
};


const { toast } = useToast()


</script>
