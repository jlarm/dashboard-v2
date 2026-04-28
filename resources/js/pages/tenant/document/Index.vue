<script setup lang="ts">
import { ref, toRef, watch } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import { useDebounceFn } from '@vueuse/core';
import { ArrowDownIcon, ArrowUpRight, Search, Trash2 } from 'lucide-vue-next';
import AppLayout from '@/layouts/tenant/AppLayout.vue';
import AppPagination from '@/components/AppPagination.vue';
import { Button } from '@/components/ui/button';
import { ButtonGroup } from '@/components/ui/button-group';
import { Input } from '@/components/ui/input';
import {
    Table,
    TableBody,
    TableCell,
    TableRow,
} from '@/components/ui/table';
import { Tooltip, TooltipContent, TooltipProvider, TooltipTrigger } from '@/components/ui/tooltip';
import UploadDealerDocDialog from '@/pages/tenant/document/components/UploadDealerDocDialog.vue';
import DeleteDealerDocDialog from '@/pages/tenant/document/components/DeleteDealerDocDialog.vue';
import doc from '@/routes/dealer/doc';
import type { BreadcrumbItem } from '@/types';
import type { PaginatedResponse } from '@/types/paginator';

type DealerDocItem = {
    key: string;
    id: number;
    title: string;
    url: string | null;
    download_url: string | null;
    is_shared: boolean;
};

type Filters = {
    search: string | null;
};

const props = defineProps<{
    docs: PaginatedResponse<DealerDocItem>;
    filters: Filters;
    can: { create: boolean };
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Documents', href: doc.index.url() },
];

const search = ref(props.filters.search ?? '');

watch(
    () => props.filters.search,
    (next) => {
        search.value = next ?? '';
    },
);

const cachedDocs = ref(props.docs);
watch(toRef(props, 'docs'), (next) => {
    if (next) {
        cachedDocs.value = next;
    }
});

const reload = (): void => {
    const query: Record<string, string> = {};
    const trimmed = search.value.trim();
    if (trimmed !== '') {
        query.search = trimmed;
    }

    router.get(doc.index.url(), query, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
        only: ['docs', 'filters'],
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
</script>

<template>
    <Head title="Documents" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-5">
            <div class="flex flex-wrap items-center gap-2">
                <div class="relative w-full max-w-md">
                    <Search class="pointer-events-none absolute left-3 top-1/2 size-4 -translate-y-1/2 text-muted-foreground" />
                    <Input
                        v-model="search"
                        type="search"
                        placeholder="Search documents..."
                        class="pl-9"
                    />
                </div>
                <Button v-if="(filters.search ?? '') !== ''" variant="ghost" size="sm" @click="clearSearch">
                    Clear search
                </Button>
                <div class="ml-auto">
                    <UploadDealerDocDialog v-if="can.create" />
                </div>
            </div>

            <div class="rounded-md border">
                <Table>
                    <TableBody>
                        <template v-if="cachedDocs.data.length > 0">
                            <TableRow v-for="item in cachedDocs.data" :key="item.key" class="hover:bg-transparent">
                                <TableCell class="font-medium text-foreground">
                                    {{ item.title }}
                                </TableCell>
                                <TableCell class="flex justify-end">
                                    <TooltipProvider>
                                        <ButtonGroup>
                                            <Tooltip v-if="item.url">
                                                <TooltipTrigger as-child>
                                                    <Button variant="outline" size="sm" as-child>
                                                        <a :href="item.url" target="_blank" rel="noopener noreferrer">
                                                            <ArrowUpRight />
                                                        </a>
                                                    </Button>
                                                </TooltipTrigger>
                                                <TooltipContent>Open link</TooltipContent>
                                            </Tooltip>
                                            <Tooltip v-if="item.download_url">
                                                <TooltipTrigger as-child>
                                                    <Button variant="outline" size="sm" as-child>
                                                        <a :href="item.download_url" target="_blank" rel="noopener">
                                                            <ArrowDownIcon />
                                                        </a>
                                                    </Button>
                                                </TooltipTrigger>
                                                <TooltipContent>Download</TooltipContent>
                                            </Tooltip>
                                            <Tooltip v-if="can.create && !item.is_shared">
                                                <TooltipTrigger as-child>
                                                    <DeleteDealerDocDialog :doc="{ id: item.id, title: item.title }">
                                                        <Button variant="outline" size="sm" class="hover:bg-red-50 hover:text-red-500">
                                                            <Trash2 />
                                                        </Button>
                                                    </DeleteDealerDocDialog>
                                                </TooltipTrigger>
                                                <TooltipContent>Delete</TooltipContent>
                                            </Tooltip>
                                        </ButtonGroup>
                                    </TooltipProvider>
                                </TableCell>
                            </TableRow>
                        </template>
                        <TableRow v-else>
                            <TableCell colspan="2" class="py-10 text-center text-sm text-muted-foreground">
                                <template v-if="(filters.search ?? '') !== ''">
                                    No documents match your search.
                                </template>
                                <template v-else>
                                    No documents have been uploaded.
                                </template>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>

            <AppPagination :pagination="cachedDocs" :only="['docs', 'filters']" />
        </div>
    </AppLayout>
</template>
