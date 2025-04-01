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
          <p class="text-gray-500">
            Tanggal Lahir
          </p>
          <p class="font-semibold">
            {{ selectedNasabahData.tanggal_lahir }}
          </p>
        </div>
        <div class="text-sm">
          <p class="text-gray-500">NIK</p>
          <p class="font-semibold">
            {{ selectedNasabahData.nomor_identitas }}
          </p>
        </div>
        <div class="text-sm">
          <p class="text-gray-500">
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
        <DropdownInfinite :url="route('simpanan.jenis.data')" v-model="form.jenis_simpanan_id"
          labelKey="nama_jenis_simpanan" valueKey="id" @onSelect="handleSelect" />
      </div>

      <!-- Input Nominal -->
      <div class="mb-4">
        <Label>Nominal Setoran</Label>
        <CurrencyInput v-model="form.nominal" :min="selectedJenisSimpananObj.minimal_setoran" class="w-full" required />

      </div>

      <!-- Tanggal Buka -->
      <div class="mb-4">
        <Label>Tanggal Buka</Label>
        <DatePicker v-model="form.tanggal_buka" mode="single" />
      </div>

      <!-- Saldo Awal -->
      <div class="mb-4">
        <Label>Saldo Awal</Label>
        <CurrencyInput v-model="form.saldo_awal" :min="selectedJenisSimpananObj.minimal_setoran" class="w-full"
          required />

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
import DropdownInfinite from '@/components/Input/DropdownInfinite.vue';
import DatePicker from '@/components/Input/DatePicker.vue';
import CurrencyInput from '@/components/Input/CurrencyInput.vue';
import parseDateToYMD from '@/Service/ParsingCalendarDate';
import { useToast } from '@/components/ui/toast';
import parseErrorMessages from '@/Service/ErrorInvalidFormParsing';

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
  saldo_awal: null,
  status_simpanan: 'Aktif'
});
const selectedJenisSimpananObj = ref({});
const { toast } = useToast()


watch(() => props.selectedNasabahData, (newVal) => {
  if (newVal) {
    form.value.nasabah_id = newVal.id;
  }
});


// Watch for changes in selectedJenisSimpananObj and update saldo_awal
watch(selectedJenisSimpananObj, (newVal) => {
  if (newVal?.minimal_setoran !== undefined) {
    form.value.saldo_awal = newVal.minimal_setoran; // Update saldo_awal dynamically
  }
}, { deep: true });

const fetchJenisSimpanan = async () => {
  try {
    const response = await axios.get(route('simpanan.jenis.data'));
    jenisSimpanan.value = response.data;
  } catch (error) {
    console.error('Gagal mengambil jenis simpanan:', error);
  }
};

const submitTabungan = async () => {
  isSubmitting.value = true;
  try {

    const payload = {
      ...form.value,
      tanggal_buka: form.value.tanggal_buka ? parseDateToYMD(form.value.tanggal_buka) : null
    };
    await axios.post(route('simpanan.store'), payload);
    toast({
      title: 'Berhasil menyimpan tabungan',
      description: `${new Date().toLocaleString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })}`,
    });
  } catch (error) {
    toast({
      title: 'Gagal menyimpan tabungan',
      description: parseErrorMessages(error.response.data.errors),
      variant: 'destructive',
    });
  } finally {
    isSubmitting.value = false;
  }
};

const formatCurrency = (value) => {
  return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(value);
};

const handleSelect = (selectedItem) => {
  selectedJenisSimpananObj.value = selectedItem;
};



onMounted(fetchJenisSimpanan);
</script>