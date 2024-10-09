import{_ as k}from"./AdminLayout-9WE8as7q.js";import{Z as w,k as P,T as N,l as h,r as g,o as i,c as l,a as p,w as c,F as B,b as a,n as _,t as r,d as u,e as m,f,v as d}from"./app-xshmINiS.js";import{T as V}from"./Table-DNiH6u3p.js";import{C}from"./CardBody-DDyTtAB0.js";import{P as T}from"./PrimaryButton-1w3nVphY.js";import{H}from"./Helper-CD4WHvGO.js";import{_ as S}from"./_plugin-vue_export-helper-DlAUqK2U.js";import"./ApplicationLogo-BH_bNMNy.js";import"./ResponsiveNavLink-CYClNS9r.js";import"./SecondaryButton-B-awMcv5.js";import"./Toast-DO6WADHa.js";const U={components:{AuthenticatedLayout:k,Head:w,Link:P,Table:V,CardBody:C,PrimaryButton:T},props:{pinjaman:Object},data(){return{nasabahs:{},page:1,searchQuery:null,form:N({nasabah_id:this.pinjaman.mapped_nasabah,jenis_pinjaman:this.pinjaman.jenis_pinjaman,jumlah_pinjaman:parseInt(this.pinjaman.nominal_diterima),bunga:parseFloat(this.pinjaman.bunga),tanggal_pengajuan:this.pinjaman.tanggal_pengajuan,tanggal_disetujui:this.pinjaman.tanggal_disetujui,tanggal_jatuh_tempo:this.pinjaman.tanggal_jatuh_tempo,status_pinjaman:this.pinjaman.status_pinjaman}),errors:{}}},beforeMount(){this.getNasabah()},watch:{page(){this.getNasabah()},searchQuery(){this.getNasabah()}},computed:{dataNasabah(){var n;return(n=this.nasabahs.data)==null?void 0:n.map(e=>({code:e.id,label:e.nama_lengkap}))},hasNextPage(){return this.nasabahs.next_page_url!=null},hasPrevPage(){return this.page>1},nominalBayar(){return this.form.jumlah_pinjaman+this.form.jumlah_pinjaman*(this.form.bunga/100)},nominalBayarFormatted(){return this.formattedRupiah(this.nominalBayar)}},methods:{async getNasabah(){const n=await h.get(route("nasabah.show",{page:this.page,searchQuery:this.searchQuery}));if(n.status==200){const e=n.data;this.nasabahs=e}},onSearch(n){this.searchQuery=n},formattedRupiah(n){return H.rupiah(n)},async prosesPinjam(){var n;try{this.form.nasabah_id=((n=this.form.nasabah_id)==null?void 0:n.code)??null,this.form.nominal_diterima=this.form.jumlah_pinjaman;const b=(await h.post(route("pinjaman.store"),this.form)).data;this.$inertia.visit(route("pinjaman.index"))}catch(e){this.errors=e.response.data.errors}},async updateDataHandler(){var n;try{this.form.nasabah_id=((n=this.form.nasabah_id)==null?void 0:n.code)??null,this.form.nominal_diterima=this.form.jumlah_pinjaman,console.log(this.form);const e=await h.put(route("pinjaman.update",this.pinjaman.id),this.form);this.$inertia.visit(route("pinjaman.index"))}catch(e){this.errors=e.response.data.errors}}}},D=a("h2",{class:"font-semibold text-xl text-gray-800 leading-tight"},"Edit Formulir Peminjaman",-1),F={class:"space-y-3"},M=a("p",{class:"text-xl font-semibold"},"Perbarui data peminjaman",-1),Q={class:"flex flex-row space-x-2 justify-center"},q=["disabled"],A=["disabled"],E={key:0,class:"text-red-600 text-sm"},L=a("label",{class:"block text-sm font-medium text-gray-700"},"Jenis Pinjaman",-1),R=a("option",{value:"mingguan"},"Mingguan",-1),J=a("option",{value:"bulanan"},"Bulanan",-1),z=a("option",{value:"musiman"},"Musiman",-1),I=a("option",{value:"tahunan"},"Tahunan",-1),O=[R,J,z,I],Z={key:0,class:"text-red-600 text-sm"},G=a("label",{class:"block text-sm font-medium text-gray-700"},"Jumlah Pinjaman",-1),K={class:"block text-sm font-medium text-gray-700 text-end"},W={key:0,class:"text-red-600 text-sm"},X=a("label",{class:"block text-sm font-medium text-gray-700"},"Bunga (%)",-1),Y={key:0,class:"text-red-600 text-sm"},$={class:"py-6 grid grid-cols-1 lg:flex lg:flex-row lg:justify-between"},aa=a("span",{class:"lg:text-lg lg:font-medium text-gray-700"},"Nominal yang harus dibayar:",-1),ta={class:"lg:text-lg font-bold text-gray-700"},ea=a("hr",null,null,-1),sa=a("label",{class:"block text-sm font-medium text-gray-700"},"Tanggal Pengajuan",-1),na={key:0,class:"text-red-600 text-sm"},oa=a("label",{class:"block text-sm font-medium text-gray-700"},"Tanggal Disetujui",-1),ra={key:0,class:"text-red-600 text-sm"},ia=a("label",{class:"block text-sm font-medium text-gray-700"},"Tanggal Jatuh Tempo",-1),la={key:0,class:"text-red-600 text-sm"},ua=a("label",{class:"block text-sm font-medium text-gray-700"},"Status Pinjaman",-1),ma=a("option",{value:"pending"},"Pending",-1),da=a("option",{value:"approved"},"Approved",-1),ga=a("option",{value:"rejected"},"Rejected",-1),pa=a("option",{value:"paid"},"Paid",-1),ca=[ma,da,ga,pa],ha={key:0,class:"text-red-600 text-sm"},_a={class:"mt-6 flex justify-end"};function fa(n,e,b,ba,t,o){const j=g("Head"),y=g("v-select"),x=g("CardBody"),v=g("AuthenticatedLayout");return i(),l(B,null,[p(j,{title:"Edit Pinjaman"}),p(v,null,{header:c(()=>[D]),default:c(()=>[p(x,null,{content:c(()=>[a("div",F,[M,p(y,{modelValue:t.form.nasabah_id,"onUpdate:modelValue":e[2]||(e[2]=s=>t.form.nasabah_id=s),options:o.dataNasabah,filterable:!1,onSearch:o.onSearch},{"list-footer":c(()=>[a("li",Q,[a("button",{class:_([{"bg-gray-100 !text-black":o.hasPrevPage==!0},"w-full h-8 text-gray-200"]),onClick:e[0]||(e[0]=s=>t.page-=1),disabled:!o.hasPrevPage},"Prev",10,q),a("button",{class:_([{"bg-gray-100 !text-black":o.hasNextPage==!0},"w-full h-8 text-gray-200"]),onClick:e[1]||(e[1]=s=>t.page+=1),disabled:!o.hasNextPage},"Next",10,A)])]),_:1},8,["modelValue","options","onSearch"]),t.errors.nasabah_id?(i(),l("span",E,r(t.errors.nasabah_id),1)):u("",!0),a("div",null,[L,m(a("select",{"onUpdate:modelValue":e[3]||(e[3]=s=>t.form.jenis_pinjaman=s),class:"mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"},O,512),[[f,t.form.jenis_pinjaman]]),t.errors.jenis_pinjaman?(i(),l("span",Z,r(t.errors.jenis_pinjaman),1)):u("",!0)]),a("div",null,[G,m(a("input",{type:"number","onUpdate:modelValue":e[4]||(e[4]=s=>t.form.jumlah_pinjaman=s),class:"mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"},null,512),[[d,t.form.jumlah_pinjaman]]),a("label",K,r(o.formattedRupiah(t.form.jumlah_pinjaman)),1),t.errors.jumlah_pinjaman?(i(),l("span",W,r(t.errors.jumlah_pinjaman),1)):u("",!0)]),a("div",null,[X,m(a("input",{type:"number",step:"0.01","onUpdate:modelValue":e[5]||(e[5]=s=>t.form.bunga=s),class:"mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"},null,512),[[d,t.form.bunga]]),t.errors.bunga?(i(),l("span",Y,r(t.errors.bunga),1)):u("",!0)]),a("div",$,[aa,a("span",ta,r(o.nominalBayarFormatted),1)]),ea,a("div",null,[sa,m(a("input",{type:"date","onUpdate:modelValue":e[6]||(e[6]=s=>t.form.tanggal_pengajuan=s),class:"mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"},null,512),[[d,t.form.tanggal_pengajuan]]),t.errors.tanggal_pengajuan?(i(),l("span",na,r(t.errors.tanggal_pengajuan),1)):u("",!0)]),a("div",null,[oa,m(a("input",{type:"date","onUpdate:modelValue":e[7]||(e[7]=s=>t.form.tanggal_disetujui=s),class:"mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"},null,512),[[d,t.form.tanggal_disetujui]]),t.errors.tanggal_disetujui?(i(),l("span",ra,r(t.errors.tanggal_disetujui),1)):u("",!0)]),a("div",null,[ia,m(a("input",{type:"date","onUpdate:modelValue":e[8]||(e[8]=s=>t.form.tanggal_jatuh_tempo=s),class:"mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"},null,512),[[d,t.form.tanggal_jatuh_tempo]]),t.errors.tanggal_jatuh_tempo?(i(),l("span",la,r(t.errors.tanggal_jatuh_tempo),1)):u("",!0)]),a("div",null,[ua,m(a("select",{"onUpdate:modelValue":e[9]||(e[9]=s=>t.form.status_pinjaman=s),class:"mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"},ca,512),[[f,t.form.status_pinjaman]]),t.errors.status_pinjaman?(i(),l("span",ha,r(t.errors.status_pinjaman),1)):u("",!0)])]),a("div",_a,[a("button",{onClick:e[10]||(e[10]=(...s)=>o.updateDataHandler&&o.updateDataHandler(...s)),class:"inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"}," Simpan Perubahan ")])]),_:1})]),_:1})],64)}const Ta=S(U,[["render",fa]]);export{Ta as default};
