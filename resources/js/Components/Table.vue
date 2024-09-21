<template>
    <div class="p-4">
      <!-- Input untuk pencarian -->
        <div class=" grid grid-cols-1 gap-2 lg:flex lg:flex-row justify-between mb-4">

           <div class=" grid grid-flow-row grid-cols-1 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 justify-start gap-2">

            <select v-model="lengthData" class="md:w-20 bg-gray-50 border border-gray-300 text-gray-900 
            text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 
            block p-2.5">
                <option v-show="item == 10 || item % 25 == 0" v-for="(item, index) in 100" :key="index">
                    <div>{{ item }}</div>
                </option>
            </select>
            <slot name="filter"></slot>
            
        </div>

                <input type="text" 
                v-model="searchQuery" 
                placeholder="Cari..." 
                class="border rounded-lg" />
        </div>
  
      <!-- Tabel -->
      <div class="relative overflow-x-auto w-full">

          <table class="divide-y w-full divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <!-- Tampilkan header tabel -->
                <td v-show="startRow"
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</td>
                <td v-for="(item, index) in headers" :key="index" 
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    {{ item }}
                </td>
                <td v-show="deleteData == true || detailData == true"></td>
               
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <!-- Tampilkan baris data tabel -->
              <tr v-for="(item, index) in bodyData" :key="index" class="transition duration-300 ease-in-out hover:bg-gray-100">
                <td v-show="startRow">
                 {{ startRow + index }}
                </td>
                <td v-for="(itemRow, indexRow) in item" :key="index"
                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    {{ itemRow }}
                </td>
                <td v-show="deleteData == true || editData == true">
                    <div class="flex flex-row space-x-2">
                        <SecondaryButton @click="editDataHandler(index)" v-show="editData">
                            Edit
                        </SecondaryButton>
                        <DangerButton @click="deleteDataHandler(index)" v-show="deleteData">
                            Hapus
                        </DangerButton>
                    </div>
                </td>
              </tr>
            </tbody>
          </table>
      </div>




    <div class="grid grid-cols-1 lg:flex lg:flex-row lg:justify-between">
        <span>Menampilkan data {{ startRow }} - {{ endRow }} dari {{ totalData }}</span>
        <nav aria-label="Page navigation example">
            <ul class="inline-flex -space-x-px text-base h-10">
                <li v-for="(item, index) in links" :key="index">
                    <div @click="clickPage(item.page)" class="flex items-center justify-center 
                    px-4 h-10 ms-0 leading-tight text-gray-500 bg-white 
                    border border-gray-300 
                    hover:bg-gray-100 
                    hover:text-gray-700 cursor-pointer" 
                    :class="{
                        'rounded-s-lg' : index == 0,
                        'rounded-r-lg' : index == links.length - 1,
                    }"
                    >
                        <span v-html="item.label"></span>
                    </div>
                </li>
            </ul>
        </nav>
    </div>

  
    </div>
  </template>
  
<script>

import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Toast from '@/Toast';
  export default {
    components:{
        DangerButton,SecondaryButton
    },
    props:{
        headers:Array,
        data:Array,
        links:Array,
        lengthProps:Number,
        deleteData:{
            type: Boolean,
            default: false
        },
        deleteRoute:String,  
        editData:{
            type: Boolean,
            default: false
        },
        editRoute:String,  
        startRow:{
            type:Number,
            default: 1
        },
        endRow:Number,
        totalData:Number,
        actionUsingId:{
            type:Boolean,
            default:false
        }
    },
    computed: {
        bodyData() {
            return this.data.map((item) => {
                let mappingData = [];
                this.headers.forEach(element => {
                    let value = item;
                    element.split('.').forEach(key => {
                        value = value ? value[key] : null;
                    });
                    mappingData.push(value);
                });
                return mappingData;
            });
        },
        links(){
            let links = this.links.map((item) => {
                let page = this.getParams(item.url);
                item.page = page;
                return item
            })
            return links
        }
    },
    data() {
        return {
            lengthData : this.lengthProps??10,
            searchQuery: null
        }
    },
    watch: {
        lengthData(newVal){
            this.$emit('change-length',newVal);
        },
        searchQuery(newVal){
            this.$emit('on-search',newVal);
        }
    },
    methods: {
        clickPage(page){
            return this.$emit('click-page',page);
        },
        getParams(url){
           try {
                const params = new URL(url);
                const page = params.searchParams.get('page')
                return page;
           } catch (error) {
                return 1;
           }
        },
        editDataHandler(index){
            const data = this.data[index];
            this.$inertia.visit(route(this.editRoute,this.actionUsingId == true ? {id: data.id} : data));
        },
        async deleteDataHandler(index){
            const data = this.data[index];
            try {
                await axios.delete(route(this.deleteRoute, this.actionUsingId == true ? {id: data.id} : data));
                Toast.fire({
                    icon: 'success',
                    title: 'Data berhasil di hapus',
                })

                this.refreshData()
            } catch (error) {
                Toast.fire({
                    icon: 'error',
                    title: 'Data gagal di hapus',
                })
                console.log(error)
            }
        },
        refreshData(){
            this.$emit('refreshed-data');
        }
    },
  };
  </script>
  