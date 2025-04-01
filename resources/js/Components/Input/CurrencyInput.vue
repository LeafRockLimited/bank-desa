<script setup lang="ts">
import { ref, watch } from 'vue'
import { Input } from '@/components/ui/input/index'

// Props definition
interface Props {
  modelValue?: number // Numeric value
  min?: number // Minimum allowed value
}

const props = defineProps<Props>()
const emit = defineEmits(['update:modelValue'])

// Reactive reference for formatted input
const inputValue = ref(formatCurrency(props.modelValue ?? 0))

// Function to format number as Rupiah currency
function formatCurrency(value: number): string {
  return new Intl.NumberFormat('id-ID', { 
    style: 'decimal', 
    minimumFractionDigits: 0, 
    maximumFractionDigits: 0 
  }).format(value)
}

// Function to parse formatted currency back to a number
function parseCurrency(value: string): number {
  return parseFloat(value.replace(/[^0-9,-]/g, '').replace(',', '.')) || 0
}

// Watch inputValue changes and update model in numeric format
watch(inputValue, (newValue) => {
  const numericValue = parseCurrency(newValue)
  emit('update:modelValue', numericValue)
})

// Watch modelValue changes and update inputValue in formatted currency
watch(() => props.modelValue, (newValue) => {
  inputValue.value = formatCurrency(newValue ?? 0)
})
</script>

<template>
  <div class="flex items-center gap-2 px-3 py-2 w-full">
    <span class="text-gray-500">Rp</span>
    <Input 
      v-model="inputValue"
      type="text"
      placeholder="0,00"
      class="w-full "
    />
  </div>
</template>
