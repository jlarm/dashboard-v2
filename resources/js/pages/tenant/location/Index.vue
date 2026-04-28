<script setup lang="ts">
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import { Pencil, Plus } from 'lucide-vue-next';
import AppLayout from '@/layouts/tenant/AppLayout.vue';
import AddLocationDialog from '@/components/tenant/AddLocationDialog.vue';
import { Button } from '@/components/ui/button';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import EditLocationDialog from '@/pages/tenant/location/components/EditLocationDialog.vue';
import locations from '@/routes/dealer/locations';
import type { BreadcrumbItem } from '@/types';

export type Location = {
    id: number;
    name: string;
    address: string | null;
    city: string | null;
    state: string | null;
    postal_code: string | null;
    phone: string | null;
    website: string | null;
};

const props = defineProps<{
    locations: { data: Location[] };
    can: { create: boolean; update: boolean };
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Locations', href: locations.index.url() },
];

const createOpen = ref(false);
const editing = ref<Location | null>(null);
const editOpen = ref(false);

const openEdit = (location: Location): void => {
    editing.value = location;
    editOpen.value = true;
};
</script>

<template>
    <Head title="Locations" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-5">
            <div v-if="can.create" class="flex justify-end">
                <Button size="sm" @click="createOpen = true">
                    <Plus class="size-3.5" />
                    Add Location
                </Button>
            </div>

            <div class="rounded-md border">
                <Table>
                    <TableHeader class="bg-muted/50 [&_tr]:border-b">
                        <TableRow>
                            <TableHead>Name</TableHead>
                            <TableHead>City</TableHead>
                            <TableHead>State</TableHead>
                            <TableHead class="w-0 text-right">Actions</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <template v-if="props.locations.data.length > 0">
                            <TableRow v-for="location in props.locations.data" :key="location.id" class="hover:bg-transparent">
                                <TableCell class="font-medium text-foreground">
                                    {{ location.name }}
                                </TableCell>
                                <TableCell>{{ location.city || 'N/A' }}</TableCell>
                                <TableCell>{{ location.state || 'N/A' }}</TableCell>
                                <TableCell class="w-0 pr-4 text-right">
                                    <Button v-if="can.update" variant="outline" size="sm" @click="openEdit(location)">
                                        <Pencil class="size-3.5" />
                                        Edit
                                    </Button>
                                </TableCell>
                            </TableRow>
                        </template>
                        <TableRow v-else>
                            <TableCell colspan="4" class="py-10 text-center text-sm text-muted-foreground">
                                No locations found.
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>
        </div>

        <AddLocationDialog v-if="can.create" v-model:open="createOpen" />
        <EditLocationDialog v-model:open="editOpen" :location="editing" />
    </AppLayout>
</template>
