<script setup lang="ts">
import EmployeeShowLayout from '@/pages/tenant/user/components/EmployeeShowLayout.vue';
import type { EmployeeShowProps } from '@/pages/tenant/user/components/types';
import { setLayoutProps } from '@inertiajs/vue3';

defineOptions({ layout: EmployeeShowLayout });

defineProps<EmployeeShowProps>();

setLayoutProps<{ activeTab: 'dot-certificates' }>({ activeTab: 'dot-certificates' });
</script>

<template>
    <section class="rounded-md border bg-card p-6 text-sm text-muted-foreground">
        DOT certificates for this employee will appear here.
    </section>
</template>
