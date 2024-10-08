<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';

// Sidebar toggle
const showingSidebar = ref(true);
const showingNavigationDropdown = ref(false);
</script>

<template>
    <div class="relative">
        <!-- Sidebar -->
        <div v-if="showingSidebar" class="fixed top-0 h-screen bg-white
        w-64">
            <div class="flex items-center justify-between p-4 border-b">
                <Link :href="route('dashboard')">
                    <h1 class="text-lg font-bold text-gray-800">Dashboard</h1>
                </Link>
                <button @click="showingSidebar = false" class="text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <nav class="flex flex-col mt-4 px-4 space-y-4">
                <NavLink :href="route('dashboard')" :active="route().current('dashboard')">Dashboard</NavLink>
                <NavLink :href="route('pinjaman.index')" :active="route().current('pinjaman.*')">Pinjaman</NavLink>
                <NavLink :href="route('angsuran.index')" :active="route().current('angsuran.*')">Angsuran</NavLink>
                <NavLink :href="route('jenis_rekening.index')" :active="route().current('jenis_rekening.*') || route().current('kode_rekening.*')">COA ( Chart of Accounts )</NavLink>
                <NavLink :href="route('buku_besar.index')" :active="route().current('buku_besar.*')">Buku Besar</NavLink>
                <NavLink :href="route('neraca.index')" :active="route().current('neraca.*')">Neraca</NavLink>
            </nav>
        </div>

        <!-- Main content area -->
        <div class="relative min-h-screen bg-gray-100"
        :class="{ 
            'ml-0': !showingSidebar ,
            'ml-64' : showingSidebar
        }">
            <!-- Navbar -->
            <div class="bg-white border-b fixed z-10 top-0 w-full border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="w-full border-b mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('dashboard')">
                                    <ApplicationLogo class="block h-9 w-auto fill-current text-gray-800" />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                <NavLink :href="route('dashboard')" :active="route().current('dashboard')">Dashboard</NavLink>
                                <NavLink :href="route('nasabah.index')" :active="route().current('nasabah.*')">Nasabah</NavLink>
                                <NavLink :href="route('user.index')" :active="route().current('user.*')">Akun</NavLink>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <!-- Settings Dropdown -->
                            <div class="ml-3 relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                                            >
                                                {{ $page.props?.auth?.user?.name??'' }}

                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink :href="route('profile.edit')">Profile</DropdownLink>
                                        <DropdownLink :href="route('logout')" method="post" as="button">Log Out</DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button
                                @click="showingNavigationDropdown = !showingNavigationDropdown"
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                            >
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path
                                        :class="{ hidden: showingNavigationDropdown, 'inline-flex': !showingNavigationDropdown }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{ hidden: !showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }" class="sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">Dashboard</ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('nasabah.index')" :active="route().current('nasabah.*')">Nasabah</ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('pinjaman.index')" :active="route().current('pinjaman.*')">Pinjaman</ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('angsuran.index')" :active="route().current('angsuran.*')">Angsuran</ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('user.index')" :active="route().current('user.*')">Akun</ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="px-4">
                            <div class="font-medium text-base text-gray-800">{{ $page?.props?.auth?.user?.name??'' }}</div>
                            <div class="font-medium text-sm text-gray-500">{{ $page.props?.auth?.user?.email??'' }}</div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.edit')">Profile</ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('logout')" method="post" as="button">Log Out</ResponsiveNavLink>
                        </div>
                    </div>
                </div>
                <!-- Page Heading -->
                <header class="bg-white border-b" v-if="$slots.header">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <slot name="header" />
                    </div>
                </header>
            </div>


            <!-- Page Content -->
            <main class="mt-32">
                <slot />
            </main>
        </div>
    </div>
</template>
