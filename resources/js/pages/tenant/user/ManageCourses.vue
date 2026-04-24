<script setup lang="ts">
import EmployeeShowLayout from '@/pages/tenant/user/components/EmployeeShowLayout.vue';
import type { EmployeeShowProps } from '@/pages/tenant/user/components/types';
import { setLayoutProps } from '@inertiajs/vue3';

defineOptions({ layout: EmployeeShowLayout });

defineProps<EmployeeShowProps>();

setLayoutProps<{ activeTab: 'manage-courses' }>({ activeTab: 'manage-courses' });
</script>

<template>
    <section class="rounded-md border bg-card p-6 text-sm text-muted-foreground">
        Course overrides and required-course management will appear here.
    </section>
</template>
