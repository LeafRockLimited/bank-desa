<template>
<div class="bg-gray-100">
        <div :class="`grid grid-flow-row grid-cols-${colCount} gap-4`">
            <div v-for="(item, index) in Object.keys(overviewData).length" :key="index" 
            class="p-4 flex flex-row justify-between items-start">
                <div>
                    <p class="text-lg font-semibold">{{ overviewData[Object.keys(overviewData)[index]].label }}</p>
                    <label>{{ overviewData[Object.keys(overviewData)[index]]?.sub_label??'-' }}</label>
                </div>
                <div class=" text-lg font-semibold" :class="`${overviewData[Object.keys(overviewData)[index]].class??'text-blue-500'}`">
                    {{ overviewData[Object.keys(overviewData)[index]].value }}
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';

defineOptions({
    name: 'OverviewTotalNeracaBkd'
})

const props = defineProps({
    'overviewData': Object,
});


const colCount = computed(() => {
    return Object.keys(props.overviewData).length
})
</script>