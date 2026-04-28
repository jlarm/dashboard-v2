<script setup lang="ts">
import { computed, ref } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import { Plus } from 'lucide-vue-next';
import AppLayout from '@/layouts/tenant/AppLayout.vue';
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import AddVendorDialog from '@/pages/tenant/vendor/components/AddVendorDialog.vue';
import vendor from '@/routes/dealer/vendor';
import type { BreadcrumbItem } from '@/types';

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

const props = defineProps<{
    vendors: VendorRow[];
    stores: StoreOption[];
    multipleStoresExist: boolean;
    hasQualifiedIndividual: boolean;
    can: { create: boolean };
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Vendors', href: vendor.index.url() },
];

const createOpen = ref(false);

const vendorCount = computed<number>(() => props.vendors.length);
</script>

<template>
    <Head title="Vendors" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-6 px-4 py-6">
            <div class="flex items-start justify-between gap-4">
                <Heading
                    title="Vendors"
                    description="Manage third-party vendor risk assessments and form requests."
                />
                <Button v-if="props.can.create" size="sm" @click="createOpen = true">
                    <Plus class="size-3.5" />
                    Add Vendor
                </Button>
            </div>

            <div v-if="vendorCount > 0" class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                <Link
                    v-for="row in props.vendors"
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
