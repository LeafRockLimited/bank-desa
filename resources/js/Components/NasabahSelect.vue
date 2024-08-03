<template>
    <v-select v-model="selectedNasabah" :options="dataNasabah" :filterable="false" @search="onSearch">
        <template #list-footer>
        <li class="flex flex-row space-x-2 justify-center">
            <button :class="{ 'bg-gray-100 !text-black': hasPrevPage == true }" @click="page -= 1" class="w-full h-8 text-gray-200" :disabled="!hasPrevPage">Prev</button>
            <button :class="{ 'bg-gray-100 !text-black': hasNextPage == true }" @click="page += 1" class="w-full h-8 text-gray-200" :disabled="!hasNextPage">Next</button>
        </li>
        </template>
    </v-select>
</template>

<script>
export default {
    beforeMount() {
        this.getNasabah()
    },
    data() {
        return {
            nasabahs: {},
            selectedNasabah:null,
            page: 1,
            searchQuery: null,
        }
    },
    computed: {
        dataNasabah() {
            return this.nasabahs.data?.map((item) => {
                return {
                    code: item.id,
                    label: item.nama_lengkap
                }
            })
        },
        hasNextPage() {
            return this.nasabahs.next_page_url != null ?? false
        },
        hasPrevPage() {
            return this.page > 1
        },
    },
    watch: {
        selectedNasabah(newVal){
            this.$emit('on-change',newVal.code)
        },
        page() {
            this.getNasabah()
        },
        searchQuery() {
            this.getNasabah()
        }
    },
    methods: {
        async getNasabah() {
            const request = await axios.get(route('nasabah.show', {
                page: this.page,
                searchQuery: this.searchQuery
            }));
            if (request.status == 200) {
                const response = request.data;
                this.nasabahs = response
            }
        },
        onSearch(value) {
            this.searchQuery = value
        },
    },
}
</script>