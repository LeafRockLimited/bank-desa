<template>
<Head title="Simpanan" />

<AuthenticatedLayout>
    <Tabs default-value="tabungan_baru" class="p-6">
        <TabsList>
            <TabsTrigger value="tabungan_baru">
                Buka tabungan baru
            </TabsTrigger>
            <TabsTrigger value="setor">
                Setor tabungan
            </TabsTrigger>
            <TabsTrigger value="tabungan_list">
                Tabungan nasabah
            </TabsTrigger>
        </TabsList>
        <div class="grid grid-flow-row grid-cols-3 gap-4">
            <NasabahList @update-nasabah="updateNasabahHandler"></NasabahList>
            <div id="tab-content" class="col-span-2">
                <TabsContent value="tabungan_baru">
                    <BukaTabunganBaru :selectedNasabahData="selectedNasabahData"></BukaTabunganBaru>
                </TabsContent>
                <TabsContent value="setor">
                    <DepositTabungan />
                </TabsContent>
                <TabsContent value="tabungan_list">
                    <TabunganList :selectedNasabahData="selectedNasabahData"></TabunganList>
                </TabsContent>

            </div>
        </div>
    </Tabs>

</AuthenticatedLayout>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import axios from 'axios';
import Button from '@/components/ui/button/Button.vue';
import Card from '@/components/ui/card/Card.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import AuthenticatedLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
import NewSaving from './Components/NewSaving.vue';
import DepositTabungan from './Components/DepositTabungan.vue';
import Input from '@/components/ui/input/Input.vue';
import BukaTabunganBaru from './Components/BukaTabunganBaru.vue';
import NasabahList from './Components/NasabahList.vue';
import { watch } from 'vue';
import TabunganList from './Components/TabunganList.vue';


const selectedNasabahData = ref<any|null>(null);

function updateNasabahHandler(data) {
    selectedNasabahData.value = data;
}

</script>
