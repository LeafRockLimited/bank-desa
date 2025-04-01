<script setup lang="ts">
import { cn } from '@/lib/utils'
import { Button } from '@/components/ui/button/index'
import { Input } from '@/components/ui/input/index'
import { Calendar } from '@/components/ui/calendar'
import { RangeCalendar } from '@/components/ui/range-calendar'
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover'
import { DateFormatter, getLocalTimeZone, CalendarDate, today } from '@internationalized/date'
import { CalendarIcon } from 'lucide-vue-next'
import { ref, computed, type Ref, watch } from 'vue'

// Define DateRange type manually
interface DateRange {
  start: CalendarDate;
  end: CalendarDate;
}

// Define component props
interface Props {
  modelValue?: CalendarDate | DateRange | null // Selected date or date range
  mode?: 'single' | 'range' // Selection mode: single date or range
  minDate?: CalendarDate // Minimum selectable date
  maxDate?: CalendarDate // Maximum selectable date
}
const props = defineProps<Props>()
const emit = defineEmits(['update:modelValue'])

const df = new DateFormatter('en-US', { dateStyle: 'long' })

// Reactive reference to store the selected date or range
const value = ref<CalendarDate | DateRange | null>(props.modelValue || null) as Ref<CalendarDate | DateRange | null>
const inputValue = ref('')

// Initialize default date range if mode is 'range' and no value is set
if (props.mode === 'range' && !value.value) {
  const start = today(getLocalTimeZone())
  const end = start.add({ days: 7 })
  value.value = { start, end }
}

// Computed property to format the selected date(s) for display
const displayValue = computed(() => {
  if (!value.value) return ''
  if (props.mode === 'range' && 'start' in value.value && 'end' in value.value) {
    return `${df.format(value.value.start.toDate(getLocalTimeZone()))} - ${df.format(value.value.end.toDate(getLocalTimeZone()))}`
  }
  return df.format((value.value as CalendarDate).toDate(getLocalTimeZone()))
})

// Watch for changes in selected date(s) and update the input field
watch(displayValue, (newValue) => {
  inputValue.value = newValue
})

// Handle selection of date(s) and emit an update event
const handleSelect = (selected: CalendarDate | DateRange) => {
  value.value = selected
  emit('update:modelValue', selected)
}
</script>

<template>
  <div class="flex items-center gap-2">
    <!-- Input field displaying selected date -->
    <Input v-model="inputValue" placeholder="Pick a date" readonly class="w-full" />
    
    <!-- Date Picker Popover -->
    <Popover>
      <PopoverTrigger as-child>
        <Button variant="outline">
          <CalendarIcon class="h-4 w-4" />
        </Button>
      </PopoverTrigger>
      <PopoverContent class="w-auto p-0">
        <!-- Range Calendar for selecting a date range -->
        <RangeCalendar 
          v-if="mode === 'range'" 
          v-model="value" 
          :min="minDate" 
          :max="maxDate" 
          @update:modelValue="handleSelect" 
          class="rounded-md border"
        />
        
        <!-- Single Date Calendar for selecting one date -->
        <Calendar 
          v-else 
          v-model="value" 
          :min="minDate" 
          :max="maxDate" 
          @update:modelValue="handleSelect" 
          initial-focus 
        />
      </PopoverContent>
    </Popover>
  </div>
</template>
