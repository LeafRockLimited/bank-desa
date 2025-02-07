<template>
    <VueDatePicker 
        :model-value="value" 
        @update:model-value="updateValue"
        v-bind="$attrs"
    />
</template>

<script setup>
defineProps({
    value: String
});

const emit = defineEmits(["update:modelValue"]);

const updateValue = (newValue) => {
    emit("update:modelValue", newValue);
};
</script>
