<script setup lang="ts">
import { ref, watch } from 'vue';
import { Head } from '@inertiajs/vue3';
import Card from '@/components/ui/card/Card.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';

const props = defineProps<{ selectedNasabahData: any | null }>();
const tabunganList = ref<Array<any>>([]);

// Watch perubahan nasabah terpilih untuk menampilkan daftar tabungan
watch(() => props.selectedNasabahData, (newNasabah) => {
  tabunganList.value = newNasabah?.tabungan || [];
}, { immediate: true });
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
                <TableCell>{{ tabungan.saldo_awal }}</TableCell>
                <TableCell>{{ tabungan.saldo_terkini }}</TableCell>
                <TableCell>{{ tabungan.status_simpanan }}</TableCell>
              </TableRow>
            </TableBody>
          </Table>
        </CardContent>
      </Card>
</template>
