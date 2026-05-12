<script setup lang="ts">
import AppContent from '@/components/AppContent.vue';
import AppShell from '@/components/AppShell.vue';
import AppSidebar from '@/components/tenant/AppSidebar.vue';
import AppSidebarHeader from '@/components/AppSidebarHeader.vue';
import NotificationBell from '@/components/tenant/NotificationBell.vue';
import CourseCompletionModal from '@/components/courses/CourseCompletionModal.vue';
import ImpersonationBanner from '@/components/ImpersonationBanner.vue';
import { Toaster } from '@/components/ui/sonner';
import { useFlashToasts } from '@/composables/useFlashToasts';
import type { BreadcrumbItem } from '@/types';

type Props = {
    breadcrumbs?: BreadcrumbItem[];
};

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});

useFlashToasts();
</script>

<template>
    <AppShell variant="sidebar">
        <AppSidebar />
        <AppContent variant="sidebar" class="overflow-x-hidden">
            <ImpersonationBanner />
            <AppSidebarHeader :breadcrumbs="breadcrumbs">
                <template #actions>
                    <slot v-if="$slots.actions" name="actions" />
                    <NotificationBell />
                </template>
            </AppSidebarHeader>
            <div class="p-4" :key="$page.component">
                <slot />
            </div>
        </AppContent>
        <Toaster position="top-right" />
        <CourseCompletionModal />
    </AppShell>
</template>
