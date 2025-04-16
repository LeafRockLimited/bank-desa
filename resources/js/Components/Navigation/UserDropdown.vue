<script setup lang="ts">
import { DropdownMenuPortal } from 'reka-ui';
import Button from '../ui/button/Button.vue';
import DropdownMenu from '../ui/dropdown-menu/DropdownMenu.vue';
import DropdownMenuContent from '../ui/dropdown-menu/DropdownMenuContent.vue';
import DropdownMenuGroup from '../ui/dropdown-menu/DropdownMenuGroup.vue';
import DropdownMenuItem from '../ui/dropdown-menu/DropdownMenuItem.vue';
import DropdownMenuLabel from '../ui/dropdown-menu/DropdownMenuLabel.vue';
import DropdownMenuSeparator from '../ui/dropdown-menu/DropdownMenuSeparator.vue';
import DropdownMenuShortcut from '../ui/dropdown-menu/DropdownMenuShortcut.vue';
import DropdownMenuSub from '../ui/dropdown-menu/DropdownMenuSub.vue';
import DropdownMenuSubTrigger from '../ui/dropdown-menu/DropdownMenuSubTrigger.vue';
import DropdownMenuTrigger from '../ui/dropdown-menu/DropdownMenuTrigger.vue';
import DropdownMenuSubContent from '../ui/dropdown-menu/DropdownMenuSubContent.vue';
import axios from 'axios';


// Fungsi untuk menangani klik Profile (mengarahkan ke /profile)
const goToProfile = () => {
  window.location.href = '/profile'; // Menggunakan route profile.edit
};

// Fungsi untuk menangani Log out (POST ke /logout)
const handleLogout = async () => {
  try {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    await axios.post('/logout', {}, {
      headers: {
        'X-CSRF-TOKEN': csrfToken,
      },
    });
    // Redirect ke halaman login setelah logout berhasil
    window.location.href = '/login';
  } catch (error) {
    console.error('Logout failed:', error);
    alert('Gagal logout. Silakan coba lagi.');
  }
};
</script>

<template>
   <DropdownMenu>
    <DropdownMenuTrigger as-child>
      <Button variant="outline">
        Open
      </Button>
    </DropdownMenuTrigger>
    <DropdownMenuContent align="end" class="w-56" >
      <DropdownMenuLabel>My Account</DropdownMenuLabel>
      <DropdownMenuSeparator />
      <DropdownMenuGroup>
        <DropdownMenuItem @click="goToProfile">
          <span>Profile</span>
          <DropdownMenuShortcut>⇧⌘P</DropdownMenuShortcut>
        </DropdownMenuItem>
        <DropdownMenuItem @click="handleLogout">
        <span>Log out</span>
        <DropdownMenuShortcut>⇧⌘Q</DropdownMenuShortcut>
      </DropdownMenuItem>
      </DropdownMenuGroup>
      
    </DropdownMenuContent>
  </DropdownMenu>
</template>
