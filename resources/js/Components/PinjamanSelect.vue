<template>
     <v-select v-model="selectedPinjaman" :options="dataPinjaman" :filterable="false" @search="onSearch">
        <template #list-footer>
        <li class="flex flex-row space-x-2 justify-center">
            <button :class="{ 'bg-gray-100 !text-black': hasPrevPage == true }" @click="page -= 1" class="w-full h-8 text-gray-200" :disabled="!hasPrevPage">Prev</button>
            <button :class="{ 'bg-gray-100 !text-black': hasNextPage == true }" @click="page += 1" class="w-full h-8 text-gray-200" :disabled="!hasNextPage">Next</button>
        </li>
        </template>
    </v-select>
</template>

<script>
import Helper from '@/Helper.js'
export default {
    props:{
        nasabah_id:{
            type:Number,
            required:true
        },
        dataComplete:{
            type:Boolean,
            default:false
        }
    },
    data() {
        return {
            selectedPinjaman:null,
            pinjamans:{},
        }
    },
    beforeMount() {
        this.getPinjaman()
    },
    computed: {
        dataPinjaman(){
            return this.pinjamans?.data?.map((item) => {
                return {
                    code : item.id,
                    label: `Pengajuan ${item.tanggal_pengajuan}, Nominal ${Helper.rupiah(item.jumlah_pinjaman)} (${item.status_pinjaman})`
                }
            })
        },
        hasNextPage() {
            return this.pinjamans.next_page_url != null ?? false
        },
        hasPrevPage() {
            return this.page > 1
        },
    },
    watch: {
        nasabah_id: {
            handler(newVal) {
                this.getPinjaman();
            },
            immediate: true,
        },
        selectedPinjaman(newVal){
            if (this.dataComplete) {
                
                let pinjaman = this.pinjamans?.data.filter((item)=>{
                    return item.id == newVal.code
                })

                let firstFindPinjaman = pinjaman[0];
                this.$emit('on-change',firstFindPinjaman)
            }else{
                this.$emit('on-change',newVal.code)
            }
        },
        page() {
            this.getPinjaman()
        },
        searchQuery() {
            this.getPinjaman()
        }
    },
    methods: {
        onSearch(){

        },
        async getPinjaman() {

            if (this.nasabah_id != null) {
                
                const request = await axios.get(route('pinjaman.show', {
                    page: this.page,
                    searchQuery: this.searchQuery,
                    nasabah_id : this.nasabah_id
                }));
                if (request.status == 200) {
                    const response = request.data;
                    this.pinjamans = response
                }
            }
        },
    },
}
</script>