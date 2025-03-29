<template>
<div class="w-[calc(100%-var(--sidebar-width))] border-b fixed z-10 top-0 max-w-screen-xl border-gray-100">
    <div class="mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 justify-between items-center">
            <!-- Kiri: Logo & Menu -->
            <div class="flex items-center space-x-6">
                <!-- Logo -->
                <div class="shrink-0">
                    <a :href="route('dashboard')">
                        <ApplicationLogo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Menu -->
                <NavigationMenu class="hidden sm:flex">
                    <NavigationMenuList>
                        <NavigationMenuItem v-for="item in menuItems" :key="item.title">
                            <NavigationMenuLink as-child>
                                <a :href="item.href" class="px-4 py-2 text-gray-700 hover:text-gray-900 transition">
                                    {{ item.title }}
                                </a>
                            </NavigationMenuLink>
                        </NavigationMenuItem>
                    </NavigationMenuList>
                </NavigationMenu>
            </div>

            <!-- Kanan: User Dropdown -->
            <UserDropdown></UserDropdown>
        </div>
    </div>

</div>
</template>


<script setup>
import {
    NavigationMenu,
    NavigationMenuContent,
    NavigationMenuItem,
    NavigationMenuLink,
    NavigationMenuList,
    NavigationMenuTrigger,
    navigationMenuTriggerStyle,
} from '@/components/ui/navigation-menu'
import ApplicationLogo from '../ApplicationLogo.vue';
import UserDropdown from './UserDropdown.vue';
import { ref } from 'vue';

const menuItems = [
    { title: 'Dashboard', href: route('dashboard') },
    { title: 'Nasabah', href: route('nasabah.index') },
    { title: 'Pinjaman', href: route('pinjaman.index') },
    { title: 'Angsuran', href: route('angsuran.index') },
    { title: 'Akun', href: route('user.index') },
]

const showingNavigationDropdown = ref(false)

</script>
