import{_ as h}from"./_plugin-vue_export-helper-DlAUqK2U.js";import{r as c,o as u,c as i,w as b,a as l,n}from"./app-DUCcJKkA.js";const d={beforeMount(){this.getNasabah()},data(){return{nasabahs:{},selectedNasabah:null,page:1,searchQuery:null}},computed:{dataNasabah(){var a;return(a=this.nasabahs.data)==null?void 0:a.map(e=>({code:e.id,label:e.nama_lengkap}))},hasNextPage(){return this.nasabahs.next_page_url!=null},hasPrevPage(){return this.page>1}},watch:{selectedNasabah(a){this.$emit("on-change",a.code)},page(){this.getNasabah()},searchQuery(){this.getNasabah()}},methods:{async getNasabah(){const a=await axios.get(route("nasabah.show",{page:this.page,searchQuery:this.searchQuery}));if(a.status==200){const e=a.data;this.nasabahs=e}},onSearch(a){this.searchQuery=a}}},g={class:"flex flex-row space-x-2 justify-center"},p=["disabled"],f=["disabled"];function x(a,e,N,_,t,s){const o=c("v-select");return u(),i(o,{modelValue:t.selectedNasabah,"onUpdate:modelValue":e[2]||(e[2]=r=>t.selectedNasabah=r),options:s.dataNasabah,filterable:!1,onSearch:s.onSearch},{"list-footer":b(()=>[l("li",g,[l("button",{class:n([{"bg-gray-100 !text-black":s.hasPrevPage==!0},"w-full h-8 text-gray-200"]),onClick:e[0]||(e[0]=r=>t.page-=1),disabled:!s.hasPrevPage},"Prev",10,p),l("button",{class:n([{"bg-gray-100 !text-black":s.hasNextPage==!0},"w-full h-8 text-gray-200"]),onClick:e[1]||(e[1]=r=>t.page+=1),disabled:!s.hasNextPage},"Next",10,f)])]),_:1},8,["modelValue","options","onSearch"])}const P=h(d,[["render",x]]);export{P as N};
