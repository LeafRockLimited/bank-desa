import{_ as y}from"./AdminLayout-9WE8as7q.js";import{Z as x,r,o as s,c as o,a as d,w as m,F as u,b as e,h as v,i as k,d as b,t as c,p as w,g as I}from"./app-xshmINiS.js";import{C}from"./CardBody-DDyTtAB0.js";import{_ as M}from"./_plugin-vue_export-helper-DlAUqK2U.js";import"./ApplicationLogo-BH_bNMNy.js";import"./ResponsiveNavLink-CYClNS9r.js";const j={components:{AuthenticatedLayout:y,Head:x,CardBody:C},props:{pinjamanId:{type:Number,required:!0},agunans:{type:Array,required:!0}},data(){return{isModalOpen:!1,modalImage:null}},methods:{formattedRupiah(a){return new Intl.NumberFormat("id-ID",{style:"currency",currency:"IDR",minimumFractionDigits:0}).format(a)},showImage(a){this.modalImage=a,this.isModalOpen=!0},closeImage(){this.isModalOpen=!1,this.modalImage=null,document.removeEventListener("keydown",this.handleEscapeKey)},handleEscapeKey(a){a.key==="Escape"&&this.closeImage()}}},i=a=>(w("data-v-ef36f217"),a=a(),I(),a),H=i(()=>e("h2",{class:"font-semibold text-xl text-gray-800 leading-tight"},"Daftar Agunan untuk Pinjaman",-1)),A={key:0,class:"text-gray-600"},B=i(()=>e("p",null,"Tidak ada agunan yang terkait dengan pinjaman ini.",-1)),D=[B],N={key:1},E={class:"space-y-4"},L={class:"flex items-center mb-4"},S={class:"text-lg font-semibold text-gray-800"},z={class:""},F={class:"text-xl font-bold"},O={class:"text-sm text-gray-500 flex flex-row space-x-1"},V=i(()=>e("svg",{xmlns:"http://www.w3.org/2000/svg",width:"24",height:"24",viewBox:"0 0 72 72"},[e("path",{fill:"#fff",d:"m12 28.122l-.003 31.97l31.66-.006l16.09-12.048c-.008-.049.253-3.946.253-3.946l-.003-16z"}),e("path",{fill:"#ea5a47",d:"m12.194 28.292l47.803-.2l.003-16.47h-9.54l.052 5.273c1.727.456 2.15 3.087 2.15 3.087c-.022 2.192-2.678 2.53-2.69 2.527c-1.848-.378-2.489-1.282-2.468-2.802c.014-1.068.046-1.33.808-2.078c.513-.502.634-.608 1.311-.78l-.028-5.226H22.344l.07 5.226c1.728.456 2.293.853 2.276 2.719c-.02 2.193-2.706 3.28-2.719 3.28c-2.205-.02-2.992-1.037-2.971-3.242c.01-1.068.877-1.864 1.64-2.612c.511-.502.698-.822 1.375-.994l-.24-4.377H12z"}),e("path",{fill:"#d0cfce",d:"M59.997 48.038H43.138s-.898 6.104-.97 5.623v5.425l1.488 1z"}),e("g",{fill:"none",stroke:"#000","stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2"},[e("circle",{cx:"22.002",cy:"19.849",r:"3"}),e("path",{d:"M26.006 12.122h20.05m7.96 0H60v16H12v-16h6.032m3.983-3.434v10.31"}),e("circle",{cx:"50.003",cy:"19.847",r:"3"}),e("path",{d:"M50.016 8.688v10.31m-15.68 19.094a5.63 5.63 0 0 1 5.513-4.494h0c1.554 0 2.96.63 3.98 1.649c1.584 1.584 1.437 4.217-.05 5.893l-9.558 10.78h4.76M23.276 37.398l5.073-3.8v18.321"}),e("path",{d:"M11.997 28.092v32l31.659-.006l16.341-12.048V28.092"}),e("path",{d:"M59.746 48.038H43.138v5.479"})])],-1)),R={class:"text-sm text-gray-500 font-semibold uppercase"},q=["src","onClick"],G={key:1,class:"h-32 bg-gray-200 flex items-center justify-center mr-4"},K=i(()=>e("span",{class:"text-gray-500"},"No Image",-1)),P=[K],T={class:"bg-white p-4 w-3/4 rounded-lg shadow-lg"},Z=["src"];function J(a,l,h,Q,g,n){const _=r("Head"),p=r("CardBody"),f=r("AuthenticatedLayout");return s(),o(u,null,[d(_,{title:"Daftar Agunan Berdasarkan Pinjaman"}),d(f,null,{header:m(()=>[H]),default:m(()=>[d(p,null,{content:m(()=>[h.agunans.length===0?(s(),o("div",A,D)):(s(),o("div",N,[e("div",E,[(s(!0),o(u,null,v(h.agunans,t=>(s(),o("div",{key:t.id,class:"bg-white p-4 rounded-lg flex flex-col"},[e("div",L,[e("div",null,[e("h3",S,c(t.jenis_agunan),1),e("p",z,[e("span",F,c(n.formattedRupiah(t.nilai_agunan)),1)]),e("div",O,[V,e("span",null,c(t.tanggal_diserahkan),1)]),e("p",R,c(t.status_agunan),1)])]),t.gambar_agunan?(s(),o("img",{key:0,src:`/storage/${t.gambar_agunan}`,alt:"Gambar Agunan",class:"h-32 object-cover cursor-pointer mr-4",onClick:U=>n.showImage(t.gambar_agunan)},null,8,q)):(s(),o("div",G,P))]))),128))])]))]),_:1}),g.isModalOpen?(s(),o("div",{key:0,class:"fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50",onClick:l[1]||(l[1]=k((...t)=>n.closeImage&&n.closeImage(...t),["self"]))},[e("div",T,[e("img",{src:`/storage/${g.modalImage}`,alt:"Gambar Agunan",class:"max-h-screen max-w-screen rounded-lg"},null,8,Z),e("button",{onClick:l[0]||(l[0]=(...t)=>n.closeImage&&n.closeImage(...t)),class:"mt-4 bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700"},"Tutup")])])):b("",!0)]),_:1})],64)}const ae=M(j,[["render",J],["__scopeId","data-v-ef36f217"]]);export{ae as default};
