<script setup lang="ts">
import { computed, ref, toRef, watch } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import { useDebounceFn } from '@vueuse/core';
import { Eye, Search } from 'lucide-vue-next';
import AppLayout from '@/layouts/tenant/AppLayout.vue';
import AppPagination from '@/components/AppPagination.vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import LogDetailsDialog from '@/pages/tenant/log/components/LogDetailsDialog.vue';
import logs from '@/routes/dealer/logs';
import type { BreadcrumbItem } from '@/types';
import type { PaginatedResponse } from '@/types/paginator';

type ActivityLog = {
    id: number;
    event: string | null;
    description: string;
    subject_type: string | null;
    subject_id: number | string | null;
    causer_name: string | null;
    created_at: string | null;
    created_at_diff: string | null;
    created_at_human: string | null;
    properties: Record<string, unknown>;
};

type Filters = {
    search: string | null;
};

const props = defineProps<{
    logs: PaginatedResponse<ActivityLog>;
    filters: Filters;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Activity Logs', href: logs.index.url() },
];

const search = ref(props.filters.search ?? '');

watch(
    () => props.filters.search,
    (next) => {
        search.value = next ?? '';
    },
);

const cachedLogs = ref(props.logs);
watch(toRef(props, 'logs'), (next) => {
    if (next) {
        cachedLogs.value = next;
    }
});

const reload = (): void => {
    const query: Record<string, string> = {};
    const trimmed = search.value.trim();
    if (trimmed !== '') {
        query.search = trimmed;
    }

    router.get(logs.index.url(), query, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
        only: ['logs', 'filters'],
    });
};

const debouncedReload = useDebounceFn(reload, 300);
watch(search, debouncedReload);

const clearSearch = (): void => {
    if (search.value === '') {
        return;
    }
    search.value = '';
    reload();
};

const eventVariant = (event: string | null): 'default' | 'secondary' | 'destructive' | 'outline' => {
    switch (event) {
        case 'created':
            return 'default';
        case 'deleted':
            return 'destructive';
        case 'updated':
        case 'login':
            return 'secondary';
        default:
            return 'outline';
    }
};

const selectedLog = ref<ActivityLog | null>(null);
const dialogOpen = ref(false);

const openDetails = (log: ActivityLog): void => {
    selectedLog.value = log;
    dialogOpen.value = true;
};

const hasSearch = computed(() => (props.filters.search ?? '').trim() !== '');
</script>

<template>
    <Head title="Activity Logs" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-5">
            <div class="flex flex-wrap items-center gap-2">
                <div class="relative w-full max-w-md">
                    <Search class="pointer-events-none absolute left-3 top-1/2 size-4 -translate-y-1/2 text-muted-foreground" />
                    <Input
                        v-model="search"
                        type="search"
                        placeholder="Search by activity, model, or user..."
                        class="pl-9"
                    />
                </div>
                <Button v-if="hasSearch" variant="ghost" size="sm" @click="clearSearch">
                    Clear search
                </Button>
            </div>

            <div class="rounded-md border">
                <Table>
                    <TableHeader class="bg-muted/50 [&_tr]:border-b">
                        <TableRow>
                            <TableHead class="w-20">ID</TableHead>
                            <TableHead>Activity</TableHead>
                            <TableHead>Date</TableHead>
                            <TableHead>Model</TableHead>
                            <TableHead>User</TableHead>
                            <TableHead class="w-0" />
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <template v-if="cachedLogs.data.length > 0">
                            <TableRow v-for="log in cachedLogs.data" :key="log.id" class="hover:bg-transparent">
                                <TableCell class="font-mono text-xs text-muted-foreground">
                                    #{{ log.id }}
                                </TableCell>
                                <TableCell>
                                    <Badge :variant="eventVariant(log.event)">
                                        {{ log.description }}
                                    </Badge>
                                </TableCell>
                                <TableCell class="text-sm text-muted-foreground">
                                    <time v-if="log.created_at" :datetime="log.created_at" :title="log.created_at_human ?? ''">
                                        {{ log.created_at_diff }}
                                    </time>
                                </TableCell>
                                <TableCell>
                                    <code v-if="log.subject_type" class="rounded bg-muted px-2 py-1 text-xs">
                                        {{ log.subject_type }}
                                    </code>
                                    <span v-else class="text-xs text-muted-foreground">—</span>
                                </TableCell>
                                <TableCell class="text-sm">
                                    <span v-if="log.causer_name">{{ log.causer_name }}</span>
                                    <span v-else class="italic text-muted-foreground">System</span>
                                </TableCell>
                                <TableCell class="w-0 pr-4 text-right">
                                    <Button variant="outline" size="sm" @click="openDetails(log)">
                                        <Eye class="size-3.5" />
                                        View
                                    </Button>
                                </TableCell>
                            </TableRow>
                        </template>
                        <TableRow v-else>
                            <TableCell colspan="6" class="py-10 text-center text-sm text-muted-foreground">
                                <template v-if="hasSearch">
                                    No activity logs match your search.
                                </template>
                                <template v-else>
                                    No activity has been recorded yet.
                                </template>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>

            <AppPagination :pagination="cachedLogs" :only="['logs', 'filters']" />
        </div>

        <LogDetailsDialog v-model:open="dialogOpen" :log="selectedLog" :event-variant="eventVariant" />
    </AppLayout>
</template>
