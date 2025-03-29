<script setup>
import AppSidebar from '@/components/AppSidebar.vue';
import SidebarProvider from '@/components/ui/sidebar/SidebarProvider.vue';
import NavigationMenu from '@/components/Navigation/NavigationMenu.vue';
import { ref } from 'vue';

// Sidebar toggle
const showingSidebar = ref(true);
const showingNavigationDropdown = ref(false);
</script>

<template>
<SidebarProvider>
    <AppSidebar />
    <main class="min-h-screen w-full">
        <!-- <SidebarTrigger /> -->
         <NavigationMenu></NavigationMenu>
        <div class="mt-16"><slot /></div>
    </main>
</SidebarProvider>

</template>import NavigationMenu from '@/components/ui/navigation-menu/NavigationMenu.vue';

