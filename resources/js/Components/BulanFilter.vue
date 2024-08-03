<template>
    <select v-model="selectedMonth" class="min-w-32 bg-gray-50 border border-gray-300 text-gray-900 
    text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 
    block p-2.5">
        <option selected :value="null"> Pilih Bulan </option>
        <option :value="item.value" v-for="(item, index) in bulanList" :key="index">
            {{ item.nama }}
        </option>
    </select>
</template>

<script>
import Helper from '@/Helper.js';

export default {
    data() {
        return {
            bulanList: Helper.bulan,
            thisMonth : this.$moment().month() + 1,
            selectedMonth:this.$moment().month() + 1,
        }
    },
    watch: {
        selectedMonth(newVal){
            this.$emit('on-change',newVal)
        }
    },
}
</script>