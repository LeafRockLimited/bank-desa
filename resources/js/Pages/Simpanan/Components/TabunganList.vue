<script setup lang="ts">
import { ref, watch } from 'vue';
import { Head } from '@inertiajs/vue3';
import Card from '@/components/ui/card/Card.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import axios from 'axios';
import { useToast } from '@/components/ui/toast';
import { Button } from '@/components/ui/button/index';

const props = defineProps<{ selectedNasabahData: any | null }>();

const tabunganList = ref<Array<any>>([]);
const currentPage = ref(1);
const totalPages = ref(1);
const perPage = ref(15);
const { toast } = useToast();

const fetchTabunganByNasabahId = async (nasabahId: number, page = 1) => {
  try {
    const response = await axios.get(route('simpanan.tabungan_nasabah', {
      nasabah_id: nasabahId,
      page: page
    }));

    tabunganList.value = response.data.data;  // Data tabungan
    currentPage.value = response.data.current_page;
    totalPages.value = response.data.last_page;
    perPage.value = response.data.per_page;
  } catch (err) {
    toast({
      title: 'Gagal menampilkan daftar tabungan',
      variant: 'destructive',
    });
  }
};

// Watch perubahan nasabah terpilih untuk menampilkan daftar tabungan
watch(() => props.selectedNasabahData, (newNasabah) => {
  if (newNasabah) {
    fetchTabunganByNasabahId(newNasabah.id, 1);
  }
}, { immediate: true });

// Fungsi untuk navigasi halaman
const changePage = (newPage: number) => {
  if (newPage >= 1 && newPage <= totalPages.value) {
    currentPage.value = newPage;
    fetchTabunganByNasabahId(props.selectedNasabahData?.id, newPage);
  }
};

</script>

<template>
  <Head title="Setoran Nasabah" />

  <Card>
    <CardHeader>
      <h2 class="text-lg font-semibold">Daftar Tabungan Nasabah</h2>
    </CardHeader>
    <CardContent>
      <Table>
        <TableHeader>
          <TableRow>
            <TableHead>Rekening</TableHead>
            <TableHead>Jenis Simpanan</TableHead>
            <TableHead>Tanggal Buka</TableHead>
            <TableHead>Saldo Awal</TableHead>
            <TableHead>Saldo Terkini</TableHead>
            <TableHead>Status</TableHead>
          </TableRow>
        </TableHeader>
        <TableBody>
          <TableRow v-for="tabungan in tabunganList" :key="tabungan.id">
            <TableCell>{{ tabungan.rekening_simpanan }}</TableCell>
            <TableCell>{{ tabungan.jenis_simpanan_id }}</TableCell>
            <TableCell>{{ tabungan.tanggal_buka }}</TableCell>
            <TableCell>{{ tabungan.saldo_awal_rupiah }}</TableCell>
            <TableCell>{{ tabungan.saldo_terkini_rupiah }}</TableCell>
            <TableCell>{{ tabungan.status_simpanan }}</TableCell>
          </TableRow>
        </TableBody>
      </Table>

      <!-- Navigasi Pagination -->
      <div class="flex justify-between items-center mt-4">
        <Button @click="changePage(currentPage - 1)" :disabled="currentPage === 1">
          Previous
        </Button>
        <span>Page {{ currentPage }} of {{ totalPages }}</span>
        <Button @click="changePage(currentPage + 1)" :disabled="currentPage === totalPages">
          Next
        </Button>
      </div>
    </CardContent>
  </Card>
</template>
