<script setup lang="ts">
import { computed, ref, watch } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { useDebounceFn } from '@vueuse/core';
import { Plus, RotateCcw, Search } from 'lucide-vue-next';
import AppLayout from '@/layouts/tenant/AppLayout.vue';
import AppPagination from '@/components/AppPagination.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import AddVendorDialog from '@/pages/tenant/vendor/components/AddVendorDialog.vue';
import vendor from '@/routes/dealer/vendor';
import type { BreadcrumbItem } from '@/types';
import type { PaginatedResponse } from '@/types/paginator';

type StoreRef = { id: number; name: string } | null;

type VendorRow = {
    id: number;
    name: string;
    contact_name: string;
    contact_email: string;
    store: StoreRef;
    is_completed: boolean;
};

type StoreOption = { id: number; name: string };

type Filters = { search: string };

const props = defineProps<{
    vendors: PaginatedResponse<VendorRow>;
    filters: Filters;
    stores: StoreOption[];
    multipleStoresExist: boolean;
    hasQualifiedIndividual: boolean;
    can: { create: boolean };
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Vendors', href: vendor.index.url() },
];

const createOpen = ref(false);
const search = ref(props.filters.search);

const reload = (): void => {
    const query: Record<string, string> = {};
    if (search.value.trim() !== '') {
        query.search = search.value.trim();
    }
    router.get(vendor.index.url(), query, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
        only: ['vendors', 'filters'],
    });
};

const debouncedReload = useDebounceFn(reload, 300);
watch(search, debouncedReload);

watch(
    () => props.filters.search,
    (next) => {
        if (next !== search.value) {
            search.value = next;
        }
    },
);

const resetSearch = (): void => {
    search.value = '';
    reload();
};

const hasActiveFilters = computed<boolean>(() => search.value.trim() !== '');
const hasResults = computed<boolean>(() => props.vendors.data.length > 0);
</script>

<template>
    <Head title="Vendors" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-5">
            <div class="flex flex-col gap-2 sm:flex-row sm:flex-wrap sm:items-center">
                <div class="relative w-full sm:max-w-sm">
                    <Search class="pointer-events-none absolute left-3 top-1/2 size-4 -translate-y-1/2 text-muted-foreground" />
                    <Input
                        v-model="search"
                        type="search"
                        placeholder="Search by name, contact, or email"
                        class="pl-9"
                    />
                </div>
                <Button
                    v-if="hasActiveFilters"
                    variant="ghost"
                    size="sm"
                    @click="resetSearch"
                >
                    Clear search
                </Button>
                <div class="sm:ml-auto">
                    <Button
                        v-if="props.can.create"
                        size="sm"
                        class="w-full sm:w-auto"
                        @click="createOpen = true"
                    >
                        Add Vendor
                    </Button>
                </div>
            </div>

            <div v-if="hasResults" class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                <Link
                    v-for="row in props.vendors.data"
                    :key="row.id"
                    :href="vendor.show.url({ vendor: row.id })"
                    class="group flex flex-col rounded-lg border bg-card p-4 transition hover:border-primary/40 hover:shadow-sm"
                >
                    <div class="flex items-start justify-between gap-2">
                        <h3 class="line-clamp-2 text-sm font-semibold capitalize text-foreground">
                            {{ row.name.toLowerCase() }}
                        </h3>
                        <span
                            :class="[
                                'inline-flex items-center rounded-full px-2 py-0.5 text-[10px] font-semibold uppercase',
                                row.is_completed
                                    ? 'bg-emerald-100 text-emerald-700'
                                    : 'bg-amber-100 text-amber-700',
                            ]"
                        >
                            {{ row.is_completed ? 'Current' : 'Incomplete' }}
                        </span>
                    </div>

                    <p class="mt-2 truncate text-xs text-muted-foreground">{{ row.contact_name }}</p>
                    <p class="truncate text-xs text-muted-foreground">{{ row.contact_email.toLowerCase() }}</p>

                    <div
                        v-if="props.multipleStoresExist"
                        class="mt-3 flex items-center justify-between border-t pt-2 text-xs text-muted-foreground"
                    >
                        <span>Location</span>
                        <span class="font-medium text-foreground">
                            {{ row.store ? row.store.name : 'All Locations' }}
                        </span>
                    </div>
                </Link>
            </div>

            <div
                v-else-if="hasActiveFilters"
                class="flex flex-col items-center justify-center rounded-lg border border-dashed bg-muted/20 px-6 py-12 text-center"
            >
                <p class="text-sm font-semibold text-foreground">No matches</p>
                <p class="mt-1 max-w-sm text-xs text-muted-foreground">
                    No vendors match your search.
                </p>
                <Button class="mt-4" variant="outline" size="sm" @click="resetSearch">
                    <RotateCcw class="size-3.5" />
                    Reset search
                </Button>
            </div>

            <div
                v-else
                class="flex flex-col items-center justify-center rounded-lg border border-dashed bg-muted/20 px-6 py-16 text-center"
            >
                <p class="text-sm font-semibold text-foreground">No vendors yet</p>
                <p class="mt-1 max-w-sm text-xs text-muted-foreground">
                    Vendors you add will receive a Risk Assessment form by email and appear here once they respond.
                </p>
                <Button
                    v-if="props.can.create"
                    class="mt-4"
                    size="sm"
                    @click="createOpen = true"
                >
                    <Plus class="size-3.5" />
                    Add your first vendor
                </Button>
            </div>

            <AppPagination v-if="hasResults" :pagination="props.vendors" :only="['vendors', 'filters']" />
        </div>

        <AddVendorDialog
            v-if="props.can.create"
            v-model:open="createOpen"
            :stores="props.stores"
            :multiple-stores-exist="props.multipleStoresExist"
            :has-qualified-individual="props.hasQualifiedIndividual"
        />
    </AppLayout>
</template>
