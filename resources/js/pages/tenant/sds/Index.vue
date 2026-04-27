<script setup lang="ts">
import { computed, ref, toRef, watch } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import { useDebounceFn } from '@vueuse/core';
import { ArrowDown, ArrowUp, ArrowUpDown, ExternalLink, FileSearch, Search } from 'lucide-vue-next';
import AppLayout from '@/layouts/tenant/AppLayout.vue';
import AppPagination from '@/components/AppPagination.vue';
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
import RequestSdsDialog from '@/pages/tenant/sds/components/RequestSdsDialog.vue';
import sds from '@/routes/dealer/sds';
import type { BreadcrumbItem } from '@/types';
import type { PaginatedResponse } from '@/types/paginator';

type SortField = 'name' | 'manufacturer';
type SortDirection = 'asc' | 'desc';

type SdsRecord = {
    uuid: string;
    name: string;
    manufacturer: string | null;
};

type Filters = {
    search: string | null;
    sort: SortField;
    direction: SortDirection;
};

const props = defineProps<{
    records: PaginatedResponse<SdsRecord> | null;
    filters: Filters;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'SDS Sheets', href: sds.index.url() },
];

const search = ref(props.filters.search ?? '');
const sortField = ref<SortField>(props.filters.sort);
const sortDirection = ref<SortDirection>(props.filters.direction);

watch(
    () => [props.filters.search, props.filters.sort, props.filters.direction] as const,
    ([nextSearch, nextSort, nextDirection]) => {
        search.value = nextSearch ?? '';
        sortField.value = nextSort;
        sortDirection.value = nextDirection;
    },
);

const cachedRecords = ref(props.records);
watch(toRef(props, 'records'), (next) => {
    if (next) {
        cachedRecords.value = next;
    }
});

const buildQuery = (): Record<string, string> => {
    const query: Record<string, string> = {};

    if (search.value.trim() !== '') {
        query.search = search.value.trim();
    }
    if (sortField.value !== 'name') {
        query.sort = sortField.value;
    }
    if (sortDirection.value !== 'asc') {
        query.direction = sortDirection.value;
    }

    return query;
};

const reload = (): void => {
    router.get(sds.index.url(), buildQuery(), {
        preserveState: true,
        preserveScroll: true,
        replace: true,
        only: ['records', 'filters'],
    });
};

const debouncedReload = useDebounceFn(reload, 300);
watch(search, debouncedReload);

const toggleSort = (field: SortField): void => {
    if (sortField.value === field) {
        sortDirection.value = sortDirection.value === 'asc' ? 'desc' : 'asc';
    } else {
        sortField.value = field;
        sortDirection.value = 'asc';
    }
    reload();
};

const clearSearch = (): void => {
    search.value = '';
    sortField.value = 'name';
    sortDirection.value = 'asc';
    reload();
};

const sortIcon = (field: SortField) => {
    if (sortField.value !== field) {
        return ArrowUpDown;
    }
    return sortDirection.value === 'asc' ? ArrowUp : ArrowDown;
};

const titleCase = (value: string | null): string => {
    if (!value) {
        return '';
    }
    return value.replace(/\w\S*/g, (word) => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase());
};

const hasSearch = computed(() => (props.filters.search ?? '').trim() !== '');
</script>

<template>
    <Head title="SDS Sheets" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <template #actions>
            <RequestSdsDialog />
        </template>

        <div class="space-y-5">
            <div class="flex flex-wrap items-center gap-2">
                <div class="relative w-full max-w-md">
                    <Search class="pointer-events-none absolute left-3 top-1/2 size-4 -translate-y-1/2 text-muted-foreground" />
                    <Input
                        v-model="search"
                        type="search"
                        placeholder="Search by name, manufacturer, or keyword..."
                        class="pl-9"
                    />
                </div>
                <Button v-if="hasSearch" variant="ghost" size="sm" @click="clearSearch">
                    Clear search
                </Button>
            </div>

            <div v-if="!hasSearch" class="rounded-lg border bg-card py-16 text-center">
                <FileSearch class="mx-auto size-10 text-muted-foreground" />
                <p class="mt-3 text-sm text-foreground">
                    Enter a search term to find SDS records.
                </p>
                <p class="mt-1 text-xs text-muted-foreground">
                    Search by chemical name, manufacturer, or keyword.
                </p>
            </div>

            <template v-else>
                <div class="rounded-md border">
                    <Table>
                        <TableHeader class="bg-muted/50 [&_tr]:border-b">
                            <TableRow>
                                <TableHead>
                                    <button
                                        type="button"
                                        class="inline-flex items-center gap-1 hover:text-foreground"
                                        @click="toggleSort('name')"
                                    >
                                        Name
                                        <component :is="sortIcon('name')" class="size-3.5" />
                                    </button>
                                </TableHead>
                                <TableHead>
                                    <button
                                        type="button"
                                        class="inline-flex items-center gap-1 hover:text-foreground"
                                        @click="toggleSort('manufacturer')"
                                    >
                                        Manufacturer
                                        <component :is="sortIcon('manufacturer')" class="size-3.5" />
                                    </button>
                                </TableHead>
                                <TableHead class="w-0" />

                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <template v-if="cachedRecords && cachedRecords.data.length > 0">
                                <TableRow v-for="record in cachedRecords.data" :key="record.uuid">
                                    <TableCell class="font-medium text-foreground">
                                        {{ titleCase(record.name) }}
                                    </TableCell>
                                    <TableCell class="text-muted-foreground">
                                        {{ titleCase(record.manufacturer) || '—' }}
                                    </TableCell>
                                    <TableCell class="w-0 pr-4 text-right">
                                        <Button as-child variant="outline" size="sm">
                                            <a :href="sds.view.url({ uuid: record.uuid })" target="_blank" rel="noopener">
                                                <ExternalLink class="size-3.5" />
                                                View
                                            </a>
                                        </Button>
                                    </TableCell>
                                </TableRow>
                            </template>
                            <TableRow v-else>
                                <TableCell colspan="3" class="py-10 text-center">
                                    <p class="text-sm text-muted-foreground">
                                        No SDS records match your search criteria.
                                    </p>
                                    <div class="mt-3 flex items-center justify-center gap-2">
                                        <Button variant="ghost" size="sm" @click="clearSearch">
                                            Clear search
                                        </Button>
                                        <RequestSdsDialog />
                                    </div>
                                </TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>
                </div>

                <AppPagination v-if="cachedRecords" :pagination="cachedRecords" :only="['records', 'filters']" />
            </template>
        </div>
    </AppLayout>
</template>
