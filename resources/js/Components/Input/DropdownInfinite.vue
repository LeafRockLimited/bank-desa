<script setup>
import { ref, onMounted, watch } from 'vue';
import axios from 'axios';
import Select from '../ui/select/Select.vue';
import SelectTrigger from '../ui/select/SelectTrigger.vue';
import SelectValue from '../ui/select/SelectValue.vue';
import SelectContent from '../ui/select/SelectContent.vue';
import SelectGroup from '../ui/select/SelectGroup.vue';
import SelectLabel from '../ui/select/SelectLabel.vue';
import SelectItem from '../ui/select/SelectItem.vue';

/**
 * Props received by the component.
 * @property {string} url - API URL to fetch dropdown data.
 * @property {string | number} modelValue - The selected value in the dropdown.
 * @property {string} labelKey - Key name for displaying text labels in the dropdown.
 * @property {string} valueKey - Key name for storing unique values (ID) in the dropdown.
 */
const props = defineProps({
  url: String,
  modelValue: [String, Number],
  labelKey: { type: String, required: true },
  valueKey: { type: String, required: true },
  placeholder : {type:String, required: false}
});

/**
 * Events emitted to the parent component.
 * @event update:modelValue - Emits the selected value from the dropdown.
 * @event onSelect - Emits the full data object of the selected item.
 */
const emit = defineEmits(["update:modelValue", "onSelect"]);

/** 
 * @type {Ref<Array<Object>>} 
 * Stores the list of dropdown options retrieved from the API.
 */
const items = ref([]);

/** 
 * @type {Ref<string | null>} 
 * Stores the next page URL for infinite scrolling.
 */
const nextPageUrl = ref(null);

/** 
 * @type {Ref<boolean>} 
 * Loading state when fetching data from the API.
 */
const loading = ref(false);

/** 
 * @type {Ref<Object | null>} 
 * Stores the currently selected item.
 */
const selectedItem = ref(null);

/**
 * Fetches data from the API and adds it to the dropdown list.
 * @async
 * @param {string} [url=props.url] - API URL to fetch data.
 * @returns {Promise<void>}
 */
const fetchData = async (url = props.url) => {
  if (!url || loading.value) return;
  loading.value = true;

  try {
    const response = await axios.get(url);
    
    // Append new data without removing existing items
    items.value = [...items.value, ...response.data.data];

    // Store next page URL for pagination
    nextPageUrl.value = response.data.next_page_url;
  } catch (error) {
    console.error("Failed to fetch data:", error);
  } finally {
    loading.value = false;
  }
};

/**
 * Handles the selection of an item in the dropdown.
 * @param {string | number} value - ID of the selected item.
 */
const handleSelect = (value) => {
  // Find the selected item based on valueKey
  selectedItem.value = items.value.find(item => item[props.valueKey] === value) || null;
  // Emit the selected value to the parent
  emit("update:modelValue", value);

  // Emit the full selected item data to the parent
  emit("onSelect", selectedItem.value);
};

/**
 * Watches for changes in the modelValue prop and updates the selected item accordingly.
 */
watch(() => props.modelValue, (newValue) => {
  handleSelect(newValue);
});

/**
 * Fetches initial data when the component is mounted.
 */
onMounted(() => {
  fetchData();
});

/**
 * Watches for changes in the API URL and resets the data accordingly.
 */
watch(() => props.url, (newUrl) => {
  items.value = [];
  nextPageUrl.value = null;
  fetchData(newUrl);
});
</script>

<template>
  <Select :modelValue="modelValue" @update:modelValue="handleSelect">
    <SelectTrigger class="w-full border p-2 rounded">
      <SelectValue :placeholder="placeholder??'Select an option'" />
    </SelectTrigger>
    <SelectContent>
      <SelectGroup>
        <SelectLabel> {{placeholder??'Select an Option'}} </SelectLabel>
        <SelectItem
          v-for="item in items"
          :key="item[valueKey]"
          :value="item[valueKey]"
        >
          {{ item[labelKey] }}
        </SelectItem>
      </SelectGroup>

      <!-- Loading Indicator -->
      <div v-if="loading" class="text-center text-sm py-2">Loading...</div>
    </SelectContent>
  </Select>
</template>
