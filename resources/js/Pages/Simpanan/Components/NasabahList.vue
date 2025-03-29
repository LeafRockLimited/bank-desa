<template>
    <Card class="bg-white p-4 rounded-xl shadow-md mt-2">
        <h2 class="text-xl font-semibold mb-4">Daftar Nasabah</h2>
        <Input v-model="searchQuery" @input="searchNasabah" placeholder="Cari nama nasabah..." class="mb-4" />

        <div class="max-h-80 overflow-y-auto">
            <ul>
                <li v-for="nasabah in nasabahList" :key="nasabah.id" @click="selectNasabah(nasabah)"
                    class="p-3 rounded-md cursor-pointer hover:bg-gray-100"
                    :class="{ 'bg-gray-200': selectedNasabah === nasabah.id.toString() }">
                    {{ nasabah.nama_lengkap }}
                </li>
            </ul>
        </div>

        <!-- Pagination -->
        <div class="flex justify-between items-center mt-4">
            <Button @click="fetchNasabah(currentPage - 1)" :disabled="currentPage === 1">Prev</Button>
            <span>Halaman {{ currentPage }} dari {{ totalPages }}</span>
            <Button @click="fetchNasabah(currentPage + 1)" :disabled="currentPage === totalPages">Next</Button>
        </div>
    </Card>
</template>

<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import Card from '@/components/ui/card/Card.vue';
import Input from '@/components/ui/input/Input.vue';
import axios from 'axios';
import { onMounted, ref } from 'vue';

const nasabahList = ref<Array<any>>([]);
const selectedNasabah = ref<string>('');
const selectedNasabahData = ref<any | null>(null);
const searchQuery = ref<string>('');
const currentPage = ref<number>(1);
const totalPages = ref<number>(1);
const perPage = ref<number>(10);

const props = defineProps({
  selectedNasabahData: Object
})

const emits = defineEmits(['updateNasabah']);

// Fetch daftar nasabah
const fetchNasabah = async (page: number = 1) => {
  try {
    const response = await axios.get(route('nasabah.show'), {
      params: {
        searchQuery: searchQuery.value,
        length: perPage.value,
        page: page
      }
    });
    
    nasabahList.value = response.data.data;
    totalPages.value = response.data.last_page;
    currentPage.value = response.data.current_page;
  } catch (error) {
    console.error('Gagal mengambil daftar nasabah:', error);
  }
};

// Fungsi pencarian
const searchNasabah = () => {
  currentPage.value = 1;
  fetchNasabah();
};

// Pilih nasabah dan tampilkan detail
const selectNasabah = (nasabah: any) => {
  selectedNasabah.value = nasabah.id.toString();
  selectedNasabahData.value = nasabah;
  emits('updateNasabah', nasabah);
};

onMounted(fetchNasabah);
</script>