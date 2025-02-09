<script setup>
import {computed, ref, watch} from 'vue';

const props = defineProps({
    value: {
        type: String,
        default: '',
    },
});

const emit = defineEmits(['update:value']);

const rawValue = ref(props.value);

// Watcher untuk menangkap perubahan prop dari parent
watch(() => props.value, (newValue) => {
    rawValue.value = newValue;
});

const formattedValue = computed(() => {
    return formatedRupiah(rawValue.value);
});

function handleInput(event) {
    // Update rawValue
    rawValue.value = event.target.value;
    emit('update:value', removeDotParse(rawValue.value)); // Menggunakan formattedValue jika membutuhkan format yang benar
}

function removeDotParse(value) {
    return value.replace(/\./g, '');
}

function formatedRupiah(value) {
    const mapped = value.replace(/[^0-9]/g, '');
    const numberString = mapped.replace(/^0+/, ''); // Menghilangkan leading zeros
    return numberString.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}
</script>

<template>
    <input
        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
        type="text"
        :value="formattedValue"
        @input="handleInput"
        placeholder="Masukkan nilai"
    />
</template>

<style scoped>
</style>
