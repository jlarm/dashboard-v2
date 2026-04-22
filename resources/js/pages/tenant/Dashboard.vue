<script setup lang="ts">
import AppLayout from '@/layouts/tenant/AppLayout.vue';
import type { StoreOption } from '@/types/global';
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();

const currentStoreName = computed(() => {
    const stores = page.props.stores ?? [];
    const currentId = page.props.auth.current_store_id;

    if (currentId !== null) {
        const match = stores.find((store: StoreOption) => store.id === currentId);
        if (match) {
            return match.name;
        }
    }

    return stores.length === 1 ? stores[0].name : 'Overview';
});
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout>
        <h1 class="text-2xl font-semibold">{{ currentStoreName }}</h1>
    </AppLayout>
</template>
