<template>
<div class="content-table">
    <table class="divide-y w-full divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <td v-for="(item, index) in header" :key="index" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    {{item}}
                </td>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <tr>
                <td  colspan="3" class=" uppercase px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ dataLabel }}</td>
            </tr>
            <tr v-for="(itemRow, indexRow) in data" :key="indexRow">
                <td v-if="header.includes('no') || header.includes('No')" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ indexRow + 1 }}</td>
                <td v-for="(itemCol, indexCol) in itemRow" :key="indexCol" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    <div v-if="typeof itemCol === 'string'">{{ itemCol }}</div>
                    <div v-if="typeof itemCol === 'object'" class="w-full" :class="itemCol.class">{{ itemCol.value }}</div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
</template>

<script setup>
defineOptions({
    name: 'NeracaBkdTable'
})

const props = defineProps({
    'header': Object,
    'dataLabel' : String,
    'data': Array
});
</script>

<style scoped>
tr:has(td > div.total) {
    background-color: #f2f2f2; /* Contoh styling */
}
.total{
    font-weight: bolder;
}

</style>