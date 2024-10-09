import{_ as x}from"./AdminLayout-9WE8as7q.js";import{Z as v,k,T as w,r as p,o as i,c as l,a as g,w as _,F as P,b as o,t as r,d as m,e as u,f,v as d,p as B,g as C}from"./app-xshmINiS.js";import{T as V}from"./Table-DNiH6u3p.js";import{C as N}from"./CardBody-DDyTtAB0.js";import{P as S}from"./PrimaryButton-1w3nVphY.js";import{H as T}from"./Helper-CD4WHvGO.js";import{N as U}from"./NasabahSelect-DcPDUkEu.js";import{_ as F}from"./_plugin-vue_export-helper-DlAUqK2U.js";import"./ApplicationLogo-BH_bNMNy.js";import"./ResponsiveNavLink-CYClNS9r.js";import"./SecondaryButton-B-awMcv5.js";import"./Toast-DO6WADHa.js";const H={components:{AuthenticatedLayout:x,Head:v,Link:k,Table:V,CardBody:N,PrimaryButton:S,NasabahSelect:U},data(){return{form:w({nasabah_id:null,jenis_pinjaman:"",jumlah_pinjaman:0,bunga:0,tanggal_pengajuan:null,tanggal_disetujui:null,tanggal_jatuh_tempo:null,status_pinjaman:""}),errors:{}}},beforeMount(){},computed:{nominalBayar(){return this.form.jumlah_pinjaman+this.form.jumlah_pinjaman*(this.form.bunga/100)},nominalBayarFormatted(){return this.formattedRupiah(this.nominalBayar)}},watch:{},methods:{formattedRupiah(a){return T.rupiah(a)},async prosesPinjam(){this.form.nominal_diterima=this.form.jumlah_pinjaman,this.form.transform(a=>({...a,nominal_diterima:a.jumlah_pinjaman})).post(route("pinjaman.store"),{onError:a=>{this.errors=a}})}}},n=a=>(B("data-v-7f35641f"),a=a(),C(),a),M=n(()=>o("h2",{class:"font-semibold text-xl text-gray-800 leading-tight"},"Formulir Peminjaman",-1)),A={class:"space-y-3"},I=n(()=>o("p",null,"Pilih Nasabah",-1)),L={key:0,class:"text-red-600 text-sm"},R=n(()=>o("label",{class:"block text-sm font-medium text-gray-700"},"Jenis Pinjaman",-1)),D=n(()=>o("option",{value:"mingguan"},"Mingguan",-1)),J=n(()=>o("option",{value:"bulanan"},"Bulanan",-1)),E=n(()=>o("option",{value:"musiman"},"Musiman",-1)),O=n(()=>o("option",{value:"tahunan"},"Tahunan",-1)),Z=[D,J,E,O],q={key:0,class:"text-red-600 text-sm"},z=n(()=>o("label",{class:"block text-sm font-medium text-gray-700"},"Jumlah Pinjaman",-1)),G={class:"block text-sm font-medium text-gray-700 text-end"},K={key:0,class:"text-red-600 text-sm"},Q=n(()=>o("label",{class:"block text-sm font-medium text-gray-700"},"Bunga (%)",-1)),W={key:0,class:"text-red-600 text-sm"},X={class:"py-6 flex flex-row justify-between"},Y=n(()=>o("span",{class:"text-lg font-medium text-gray-700"},"Nominal yang harus dibayar:",-1)),$={class:"text-lg font-medium text-gray-700"},oo=n(()=>o("hr",null,null,-1)),to=n(()=>o("label",{class:"block text-sm font-medium text-gray-700"},"Tanggal Pengajuan",-1)),no={key:0,class:"text-red-600 text-sm"},eo=n(()=>o("label",{class:"block text-sm font-medium text-gray-700"},"Tanggal Disetujui",-1)),so={key:0,class:"text-red-600 text-sm"},ao=n(()=>o("label",{class:"block text-sm font-medium text-gray-700"},"Tanggal Jatuh Tempo",-1)),ro={key:0,class:"text-red-600 text-sm"},io=n(()=>o("label",{class:"block text-sm font-medium text-gray-700"},"Status Pinjaman",-1)),lo=n(()=>o("option",{value:"pending"},"Pending",-1)),mo=n(()=>o("option",{value:"approved"},"Approved",-1)),uo=n(()=>o("option",{value:"rejected"},"Rejected",-1)),co=n(()=>o("option",{value:"paid"},"Paid",-1)),po=[lo,mo,uo,co],go={key:0,class:"text-red-600 text-sm"},_o={class:"mt-6 flex justify-end"};function fo(a,e,ho,jo,t,c){const h=p("Head"),j=p("NasabahSelect"),b=p("CardBody"),y=p("AuthenticatedLayout");return i(),l(P,null,[g(h,{title:"Proses pinjaman"}),g(y,null,{header:_(()=>[M]),default:_(()=>[g(b,null,{content:_(()=>[o("div",A,[o("div",null,[I,g(j,{onOnChange:e[0]||(e[0]=s=>{t.form.nasabah_id=s})}),t.errors.nasabah_id?(i(),l("span",L,r(t.errors.nasabah_id),1)):m("",!0)]),o("div",null,[R,u(o("select",{"onUpdate:modelValue":e[1]||(e[1]=s=>t.form.jenis_pinjaman=s),class:"mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"},Z,512),[[f,t.form.jenis_pinjaman]]),t.errors.jenis_pinjaman?(i(),l("span",q,r(t.errors.jenis_pinjaman),1)):m("",!0)]),o("div",null,[z,u(o("input",{type:"number","onUpdate:modelValue":e[2]||(e[2]=s=>t.form.jumlah_pinjaman=s),class:"mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"},null,512),[[d,t.form.jumlah_pinjaman]]),o("label",G,r(c.formattedRupiah(t.form.jumlah_pinjaman)),1),t.errors.jumlah_pinjaman?(i(),l("span",K,r(t.errors.jumlah_pinjaman),1)):m("",!0)]),o("div",null,[Q,u(o("input",{type:"number",step:"0.01","onUpdate:modelValue":e[3]||(e[3]=s=>t.form.bunga=s),class:"mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"},null,512),[[d,t.form.bunga]]),t.errors.bunga?(i(),l("span",W,r(t.errors.bunga),1)):m("",!0)]),o("div",X,[Y,o("span",$,r(c.nominalBayarFormatted),1)]),oo,o("div",null,[to,u(o("input",{type:"date","onUpdate:modelValue":e[4]||(e[4]=s=>t.form.tanggal_pengajuan=s),class:"mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"},null,512),[[d,t.form.tanggal_pengajuan]]),t.errors.tanggal_pengajuan?(i(),l("span",no,r(t.errors.tanggal_pengajuan),1)):m("",!0)]),o("div",null,[eo,u(o("input",{type:"date","onUpdate:modelValue":e[5]||(e[5]=s=>t.form.tanggal_disetujui=s),class:"mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"},null,512),[[d,t.form.tanggal_disetujui]]),t.errors.tanggal_disetujui?(i(),l("span",so,r(t.errors.tanggal_disetujui),1)):m("",!0)]),o("div",null,[ao,u(o("input",{type:"date","onUpdate:modelValue":e[6]||(e[6]=s=>t.form.tanggal_jatuh_tempo=s),class:"mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"},null,512),[[d,t.form.tanggal_jatuh_tempo]]),t.errors.tanggal_jatuh_tempo?(i(),l("span",ro,r(t.errors.tanggal_jatuh_tempo),1)):m("",!0)]),o("div",null,[io,u(o("select",{"onUpdate:modelValue":e[7]||(e[7]=s=>t.form.status_pinjaman=s),class:"mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"},po,512),[[f,t.form.status_pinjaman]]),t.errors.status_pinjaman?(i(),l("span",go,r(t.errors.status_pinjaman),1)):m("",!0)])]),o("div",_o,[o("button",{onClick:e[8]||(e[8]=(...s)=>c.prosesPinjam&&c.prosesPinjam(...s)),class:"inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"}," Buat Pinjaman ")])]),_:1})]),_:1})],64)}const To=F(H,[["render",fo],["__scopeId","data-v-7f35641f"]]);export{To as default};
