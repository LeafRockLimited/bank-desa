<template>
    <Card class="flex gap-6 p-2">
      <!-- Detail Nasabah -->
      <div class="w-1/3  p-4 border-r">
        <dic v-if="selectedNasabahData" class="space-y-4">
          <div>
            <h2 class="text-xl font-bold">{{ selectedNasabahData.nama_lengkap }}</h2>
          </div>
          <div class="space-y-2">
            <div class="text-sm text-gray-500">{{ selectedNasabahData.alamat }}</div>
            <div class="text-sm inline-flex items-center space-x-1">
              <Icon icon="mdi-light:phone" /> 
              <span>{{ selectedNasabahData.nomor_telepon }}</span>
            </div>
            <div class="text-sm inline-flex items-center space-x-1">
              <Icon icon="mdi-light:email" />
              <span>{{ selectedNasabahData.email }}</span>
            </div>
            <div class="text-sm">
              <p>
                Tanggal Lahir
              </p> 
              <p class="font-semibold">
                {{ selectedNasabahData.tanggal_lahir }}
              </p>
            </div>
            <div class="text-sm">
              <p>NIK</p>
              <p class="font-semibold">
                {{ selectedNasabahData.nomor_identitas }}
              </p>
            </div>
            <div class="text-sm">
              <p>
                Pekerjaan
              </p> 
              <p>
                {{ selectedNasabahData.pekerjaan }}
              </p>
            </div>
          </div>
        </dic>
        <div v-else class="text-center text-gray-500">Pilih nasabah untuk melihat detail</div>
      </div>
  
      <!-- Form Pembukaan Tabungan -->
      <div class="w-2/3 p-4">
        <h2 class="text-xl font-bold mb-4">Buka Tabungan Baru</h2>
        <form @submit.prevent="submitTabungan">
          <!-- Pilih Jenis Simpanan -->
          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Simpanan</label>
            <Select v-model="form.jenis_simpanan_id">
            <SelectTrigger class="w-full border p-2 rounded">
                <SelectValue placeholder="Pilih jenis simpanan" />
            </SelectTrigger>
            <SelectContent>
                <SelectGroup>
                <SelectLabel>Jenis Simpanan</SelectLabel>
                <SelectItem v-for="jenis in jenisSimpanan" :key="jenis.id" :value="jenis.id">
                    {{ jenis.nama_jenis_simpanan }} (Min: {{ new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(jenis.minimal_setoran) }})
                </SelectItem>
                </SelectGroup>
            </SelectContent>
            </Select>
        </div>
  
          <!-- Input Nominal -->
          <div class="mb-4">
            <Label>Nominal Setoran</Label>
            <Input v-model.number="form.nominal" type="number" min="50000" class="w-full" required />
          </div>
  
          <!-- Tanggal Buka -->
          <div class="mb-4">
            <Label>Tanggal Buka</Label>
            <Input v-model="form.tanggal_buka" type="date" class="w-full" required />
          </div>
  
          <!-- Saldo Awal -->
          <div class="mb-4">
            <Label>Saldo Awal</Label>
            <Input v-model.number="form.saldo_awal" type="number" min="50000" class="w-full" required />
          </div>
  
          <!-- Status Simpanan -->
          <div class="mb-4">
            <Label>Status Simpanan</Label>
            <Input v-model="form.status_simpanan" type="text" class="w-full" readonly />
          </div>
  
          <!-- Tombol Simpan -->
          <Button type="submit" class="w-full mt-4" :disabled="isSubmitting">
            {{ isSubmitting ? "Menyimpan..." : "Buka Tabungan" }}
          </Button>
        </form>
      </div>
    </Card>
  </template>
  
  <script setup>
  import { ref, onMounted, defineProps, watch } from 'vue';
  import axios from 'axios';
  import Button from '@/components/ui/button/Button.vue';
  import Input from '@/components/ui/input/Input.vue';
  import Label from '@/components/ui/label/Label.vue';
  import {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectLabel,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select'
import Card from '@/components/ui/card/Card.vue';


  const props = defineProps({
    selectedNasabahData: Object
  });
  
  const jenisSimpanan = ref([]);
  const isSubmitting = ref(false);
  const form = ref({
    jenis_simpanan_id: '',
    nasabah_id: '',
    nominal: '',
    tanggal_buka: '',
    saldo_awal: 50000,
    status_simpanan: 'Aktif'
  });
  
  watch(() => props.selectedNasabahData, (newVal) => {
    if (newVal) {
      form.value.nasabah_id = newVal.id;
    }
  });
  
  const fetchJenisSimpanan = async () => {
    try {
      const response = await axios.get('/api/jenis-simpanan');
      jenisSimpanan.value = response.data;
    } catch (error) {
      console.error('Gagal mengambil jenis simpanan:', error);
    }
  };
  
  const submitTabungan = async () => {
    isSubmitting.value = true;
    try {
      await axios.post('/api/tabungan', form.value);
      alert('Tabungan berhasil dibuka!');
    } catch (error) {
      console.error('Gagal menyimpan tabungan:', error);
    } finally {
      isSubmitting.value = false;
    }
  };
  
  const formatCurrency = (value) => {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(value);
  };
  
  onMounted(fetchJenisSimpanan);
  </script>
  