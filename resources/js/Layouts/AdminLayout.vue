<script setup>
import AppSidebar from '@/components/AppSidebar.vue';
import SidebarProvider from '@/components/ui/sidebar/SidebarProvider.vue';
import NavigationMenu from '@/components/Navigation/NavigationMenu.vue';
import { ref } from 'vue';
import Toaster from '@/components/ui/toast/Toaster.vue';

// Sidebar toggle
const showingSidebar = ref(true);
const showingNavigationDropdown = ref(false);
</script>

<template>
<Toaster />
<SidebarProvider>
    <AppSidebar />
    <main class="min-h-screen w-full">
        <!-- <SidebarTrigger /> -->
         <NavigationMenu></NavigationMenu>
        <div class="mt-16"><slot /></div>
    </main>
</SidebarProvider>

</template>

