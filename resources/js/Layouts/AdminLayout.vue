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
                <span class="uppercase px-1 block text-sm font-medium text-gray-400">
                    Data
                </span>
                <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="currentColor" d="m21.444 9.473l-1.67 10a3 3 0 0 1-1 1.79a3.2 3.2 0 0 1-2 .7h-9.61a3 3 0 0 1-2.93-2.49l-1.67-10a3 3 0 0 1 .23-1.7a3 3 0 0 1 1.12-1.29l6.48-4a3 3 0 0 1 3.15 0l6.47 4c.507.3.911.747 1.16 1.28a3 3 0 0 1 .27 1.71"/></svg>
                    Dashboard
                </NavLink>
                <NavLink :href="route('kode_rekening.index')" :active="route().current('jenis_rekening.*') || route().current('kode_rekening.*')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="currentColor" d="M17 11h3a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2h-3a2 2 0 0 0-2 2v1H9.01V5a2 2 0 0 0-2-2H4c-1.1 0-2 .9-2 2v4a2 2 0 0 0 2 2h3a2 2 0 0 0 2-2V8h2v7.01c0 1.65 1.34 2.99 2.99 2.99H15v1a2 2 0 0 0 2 2h3a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2h-3a2 2 0 0 0-2 2v1h-1.01c-.54 0-.99-.45-.99-.99V8h2v1c0 1.1.9 2 2 2"/></svg>
                    COA ( Rekening )
                </NavLink>
                <span class="uppercase px-1 block text-sm font-medium text-gray-400">
                    Pinjaman
                </span>
                <NavLink :href="route('pinjaman.index')" :active="route().current('pinjaman.*')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 512 512"><path fill="currentColor" d="M470.7 9.4c3 3.1 5.3 6.6 6.9 10.3s2.4 7.8 2.4 12.2V128c0 17.7-14.3 32-32 32s-32-14.3-32-32v-18.7L310.6 214.6c-11.8 11.8-30.8 12.6-43.5 1.7L176 138.1l-91.2 78.2c-13.4 11.5-33.6 9.9-45.1-3.5s-9.9-33.6 3.5-45.1l112-96c12-10.3 29.7-10.3 41.7 0l89.5 76.7L370.7 64H352c-17.7 0-32-14.3-32-32s14.3-32 32-32h96c8.8 0 16.8 3.6 22.6 9.3zM0 304c0-26.5 21.5-48 48-48h416c26.5 0 48 21.5 48 48v160c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48zm48 112v48h48c0-26.5-21.5-48-48-48m48-112H48v48c26.5 0 48-21.5 48-48m368 112c-26.5 0-48 21.5-48 48h48zm-48-112c0 26.5 21.5 48 48 48v-48zm-96 80a64 64 0 1 0-128 0a64 64 0 1 0 128 0"/></svg>
                    Pinjaman
                </NavLink>
                <NavLink :href="route('angsuran.index')" :active="route().current('angsuran.*')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="20" viewBox="0 0 640 512"><path fill="currentColor" d="M535 41c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l64 64c4.5 4.5 7 10.6 7 17s-2.5 12.5-7 17l-64 64c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l23-23l-174-.2c-13.3 0-24-10.7-24-24s10.7-24 24-24h174.1zM105 377l-23 23h174c13.3 0 24 10.7 24 24s-10.7 24-24 24H81.9l23 23c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0L7 441c-4.5-4.5-7-10.6-7-17s2.5-12.5 7-17l64-64c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9zM96 64h241.9c-3.7 7.2-5.9 15.3-5.9 24c0 28.7 23.3 52 52 52h117.4c-4 17 .6 35.5 13.8 48.8c20.3 20.3 53.2 20.3 73.5 0l19.3-19.3V384c0 35.3-28.7 64-64 64H302.1c3.7-7.2 5.9-15.3 5.9-24c0-28.7-23.3-52-52-52H138.6c4-17-.6-35.5-13.8-48.8c-20.3-20.3-53.2-20.3-73.5 0L32 342.5V128c0-35.3 28.7-64 64-64m64 64H96v64c35.3 0 64-28.7 64-64m384 192c-35.3 0-64 28.7-64 64h64zm-224 32a96 96 0 1 0 0-192a96 96 0 1 0 0 192"/></svg>
                    Angsuran
                </NavLink>
                <NavLink :href="route('jurnal.index')" :active="route().current('jurnal.*')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 512 512">
                        <path fill="currentColor" d="M290 32H144a64.07 64.07 0 0 0-64 64v320a64.07 64.07 0 0 0 64 64h146Zm78 0h-18v448h18a64.07 64.07 0 0 0 64-64V96a64.07 64.07 0 0 0-64-64"/>
                    </svg>
                    Jurnal
                </NavLink>
                <NavLink :href="route('neraca.bkd')" :active="route().current('neraca.bkd')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="20" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M12 2.25a.75.75 0 0 1 .75.75v.756a49 49 0 0 1 9.152 1a.75.75 0 0 1-.152 1.485h-1.918l2.474 10.124a.75.75 0 0 1-.375.84A6.7 6.7 0 0 1 18.75 18a6.7 6.7 0 0 1-3.181-.795a.75.75 0 0 1-.375-.84l2.474-10.124H12.75v13.28c1.293.076 2.534.343 3.697.776a.75.75 0 0 1-.262 1.453h-8.37a.75.75 0 0 1-.262-1.453c1.162-.433 2.404-.7 3.697-.775V6.24H6.332l2.474 10.124a.75.75 0 0 1-.375.84A6.7 6.7 0 0 1 5.25 18a6.7 6.7 0 0 1-3.181-.795a.75.75 0 0 1-.375-.84L4.168 6.241H2.25a.75.75 0 0 1-.152-1.485a49 49 0 0 1 9.152-1V3a.75.75 0 0 1 .75-.75m4.878 13.543l1.872-7.662l1.872 7.662zm-9.756 0L5.25 8.131l-1.872 7.662z" clip-rule="evenodd"/></svg>
                    Neraca
                </NavLink>
<!--                <span class="uppercase px-1 block text-sm font-medium text-gray-400">-->
<!--                    Keuangan-->
<!--                </span>-->
<!--                <NavLink :href="route('buku_besar.index')" :active="route().current('buku_besar.*')">-->
<!--                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M6.271 2.112c-.81.106-1.238.301-1.544.6c-.305.3-.504.72-.613 1.513C4.002 5.042 4 6.124 4 7.675v8.57a4.2 4.2 0 0 1 1.299-.593c.528-.139 1.144-.139 2.047-.138H20V7.676c0-1.552-.002-2.634-.114-3.451c-.109-.793-.308-1.213-.613-1.513c-.306-.299-.734-.494-1.544-.6c-.834-.11-1.938-.112-3.522-.112H9.793c-1.584 0-2.688.002-3.522.112m.488 4.483c0-.448.37-.811.827-.811h8.828a.82.82 0 0 1 .827.81a.82.82 0 0 1-.827.811H7.586a.82.82 0 0 1-.827-.81m.827 2.973a.82.82 0 0 0-.827.81c0 .448.37.811.827.811h5.517a.82.82 0 0 0 .828-.81a.82.82 0 0 0-.828-.811z" clip-rule="evenodd"/><path fill="currentColor" d="M7.473 17.135H20c-.003 1.13-.021 1.974-.113 2.64c-.109.793-.308 1.213-.613 1.513c-.306.299-.734.494-1.544.6c-.834.11-1.938.112-3.522.112H9.793c-1.584 0-2.688-.002-3.522-.111c-.81-.107-1.238-.302-1.544-.601c-.305-.3-.504-.72-.613-1.513c-.041-.3-.068-.637-.084-1.02a2.46 2.46 0 0 1 1.697-1.537c.29-.076.667-.083 1.746-.083"/></svg>-->
<!--                    Buku Besar-->
<!--                </NavLink>-->
<!--                <NavLink :href="route('laba_rugi.index')" :active="route().current('laba_rugi.*')">-->
<!--                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"><path d="M3.5 4v13.5a3 3 0 0 0 3 3H20"/><path d="m6.5 15l4.5-4.5l3.5 3.5L20 8.5"/></g></svg>-->
<!--                    Laba Rugi-->
<!--                </NavLink>-->
<!--                <NavLink :href="route('neraca.index')" :active="route().current('neraca.*')">-->
<!--                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="20" viewBox="0 0 640 512"><path fill="currentColor" d="M384 32h128c17.7 0 32 14.3 32 32s-14.3 32-32 32H398.4c-5.2 25.8-22.9 47.1-46.4 57.3V448h160c17.7 0 32 14.3 32 32s-14.3 32-32 32H128c-17.7 0-32-14.3-32-32s14.3-32 32-32h160V153.3c-23.5-10.3-41.2-31.6-46.4-57.3H128c-17.7 0-32-14.3-32-32s14.3-32 32-32h128c14.6-19.4 37.8-32 64-32s49.4 12.6 64 32m55.6 288h144.9L512 195.8zm72.4 96c-62.9 0-115.2-34-126-78.9c-2.6-11 1-22.3 6.7-32.1l95.2-163.2c5-8.6 14.2-13.8 24.1-13.8s19.1 5.3 24.1 13.8L631.3 305c5.7 9.8 9.3 21.1 6.7 32.1C627.2 382 574.9 416 512 416M126.8 195.8L54.4 320h144.9zM.9 337.1c-2.6-11 1-22.3 6.7-32.1l95.2-163.2c5-8.6 14.2-13.8 24.1-13.8s19.1 5.3 24.1 13.8L246.2 305c5.7 9.8 9.3 21.1 6.7 32.1C242 382 189.7 416 126.8 416S11.7 382 .9 337.1"/></svg>-->
<!--                    Neraca-->
<!--                </NavLink>-->
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
