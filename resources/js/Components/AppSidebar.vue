<script setup lang="ts">
import { defineComponent } from "vue";
import { Home, Inbox, Calendar, Search, Settings, Banknote } from "lucide-vue-next";
import {
  Sidebar,
  SidebarContent,
  SidebarGroup,
  SidebarGroupContent,
  SidebarGroupLabel,
  SidebarMenu,
  SidebarMenuButton,
  SidebarMenuItem,
} from "@/components/ui/sidebar";
import { Link } from "@inertiajs/vue3";

// Menu items
const items = [
  {
    title: "Dashboard",
    url: route("dashboard"),
    icon: Home,
    active: route().current("dashboard"),
  },
  {
    title: "COA (Rekening)",
    url: route("kode_rekening.index"),
    icon: Inbox,
    active:
      route().current("jenis_rekening.*") || route().current("kode_rekening.*"),
  },
  {
    title: "Tabungan",
    url: route("simpanan.index"),
    icon: Banknote,
    active: route().current("neraca.bkd"),
  },
  {
    title: "Pinjaman",
    url: route("pinjaman.index"),
    icon: Calendar,
    active: route().current("pinjaman.*"),
  },
  {
    title: "Angsuran",
    url: route("angsuran.index"),
    icon: Search,
    active: route().current("angsuran.*"),
  },
  {
    title: "Jurnal",
    url: route("jurnal.index"),
    icon: Settings,
    active: route().current("jurnal.*"),
  },
  {
    title: "Neraca",
    url: route("neraca.bkd"),
    icon: Settings,
    active: route().current("neraca.bkd"),
  },
  
];
</script>

<template>
  <Sidebar class="bg-white">
    <SidebarContent>
      <SidebarGroup>
        <SidebarGroupLabel>Data</SidebarGroupLabel>
        <SidebarGroupContent>
          <SidebarMenu>
            <SidebarMenuItem v-for="item in items" :key="item.title">
              <SidebarMenuButton asChild>
                <Link :href="item.url" :active="item.active">
                  <component :is="item.icon" class="w-5 h-5" />
                  <span>{{ item.title }}</span>
                </Link>
              </SidebarMenuButton>
            </SidebarMenuItem>
          </SidebarMenu>
        </SidebarGroupContent>
      </SidebarGroup>
    </SidebarContent>
  </Sidebar>
</template>
