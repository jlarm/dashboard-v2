<script setup lang="ts">
import AppLayout from '@/layouts/tenant/app/AppSidebarLayout.vue';
import type { BreadcrumbItem } from '@/types';

type Props = {
    breadcrumbs?: BreadcrumbItem[];
};

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <template v-if="$slots.actions" #actions>
            <slot name="actions" />
        </template>
        <slot />
    </AppLayout>
</template>
