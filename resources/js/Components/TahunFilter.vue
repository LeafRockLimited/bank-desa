<template>
    <select v-model="selectedTahun" class="min-w-32 bg-gray-50 border border-gray-300 text-gray-900 
        text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 
        block p-2.5">
            <option selected :value="null"> Pilih tahun </option>
            <option v-for="(item, index) in tahunList" :key="index">
                {{ item }}
            </option>
        </select>
</template>

<script>
export default {
    data() {
        return {
            now: this.$moment.now(),
            year : this.$moment(this.now).year(),
            selectedTahun:  this.$moment().year(),
        }
    },
    computed: {
        tahunList(){
            let listYear = []
            for (let index = this.year; index >= 1970; index --) {
                listYear.push(index)
            }
            return listYear
        }
    },
    watch: {
        selectedTahun(newVal){
            this.$emit('on-change',newVal)
        }
    },
}
</script>