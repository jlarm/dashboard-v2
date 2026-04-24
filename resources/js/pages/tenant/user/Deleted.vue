<script setup lang="ts">
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
import { Tooltip, TooltipContent, TooltipTrigger } from '@/components/ui/tooltip';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import AppLayout from '@/layouts/tenant/AppLayout.vue';
import ImportEmployeesDialog from '@/pages/tenant/user/components/ImportEmployeesDialog.vue';
import SubNavigation from '@/pages/tenant/user/components/SubNavigation.vue';
import employeeRoutes from '@/routes/dealer/employees';
import type { BreadcrumbItem } from '@/types';
import type { PaginatedResponse } from '@/types/paginator';
import { Head, router } from '@inertiajs/vue3';
import { useDebounceFn } from '@vueuse/core';
import { RotateCcw, Undo2 } from 'lucide-vue-next';
import { computed, ref, watch } from 'vue';

type DeletedEmployee = {
    id: number;
    name: string;
    email: string;
    department_name: string | null;
    deleted_at: string | null;
    deleted_at_formatted: string | null;
};

type Filters = { search: string };

const props = defineProps<{
    employees: PaginatedResponse<DeletedEmployee>;
    filters: Filters;
}>();

const breadcrumbs = computed<BreadcrumbItem[]>(() => [
    { title: 'Employees', href: employeeRoutes.index.url() },
    { title: 'Deleted', href: employeeRoutes.deleted.url() },
]);

const search = ref(props.filters.search);
const importDialogOpen = ref(false);
const toRestore = ref<DeletedEmployee | null>(null);
const restoring = ref(false);

const buildQuery = (): Record<string, string> => {
    const query: Record<string, string> = {};
    if (search.value !== '') {
        query.search = search.value;
    }
    return query;
};

const reload = () => {
    router.get(employeeRoutes.deleted.url(), buildQuery(), {
        preserveState: true,
        preserveScroll: true,
        replace: true,
        only: ['employees', 'filters'],
    });
};

const debouncedSearch = useDebounceFn(reload, 300);
watch(search, debouncedSearch);

const hasActiveFilters = computed(() => search.value !== '');

const resetFilters = () => {
    search.value = '';
    reload();
};

const confirmRestore = (employee: DeletedEmployee) => {
    toRestore.value = employee;
};

const cancelRestore = () => {
    toRestore.value = null;
};

const performRestore = () => {
    if (!toRestore.value) {
        return;
    }

    restoring.value = true;
    router.post(
        employeeRoutes.deleted.restore.url({ user: toRestore.value.id }),
        {},
        {
            preserveScroll: true,
            onFinish: () => {
                restoring.value = false;
                toRestore.value = null;
            },
        },
    );
};
</script>

<template>
    <Head title="Deleted Employees" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <template #actions>
            <SubNavigation @import="importDialogOpen = true" />
        </template>

        <ImportEmployeesDialog v-model:open="importDialogOpen" />

        <div class="space-y-5">
            <div class="flex flex-wrap items-center gap-2">
                <div class="w-64">
                    <Input v-model="search" type="search" placeholder="Search by name or email" />
                </div>

                <Button v-if="hasActiveFilters" variant="ghost" size="sm" @click="resetFilters">
                    <RotateCcw class="size-3.5" />
                    Reset
                </Button>
            </div>

            <div class="overflow-x-auto rounded-md border">
                <Table>
                    <TableHeader class="bg-muted">
                        <TableRow>
                            <TableHead>Name</TableHead>
                            <TableHead>Email</TableHead>
                            <TableHead>Department</TableHead>
                            <TableHead>Deleted</TableHead>
                            <TableHead class="text-right" />
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-if="employees.data.length === 0">
                            <TableCell colspan="5" class="py-10 text-center text-muted-foreground">
                                No deleted employees.
                            </TableCell>
                        </TableRow>
                        <TableRow v-for="employee in employees.data" :key="employee.id">
                            <TableCell class="font-medium">{{ employee.name }}</TableCell>
                            <TableCell class="lowercase">{{ employee.email }}</TableCell>
                            <TableCell>{{ employee.department_name ?? '—' }}</TableCell>
                            <TableCell>{{ employee.deleted_at_formatted ?? '—' }}</TableCell>
                            <TableCell>
                                <div class="flex justify-end">
                                    <Tooltip>
                                        <TooltipTrigger as-child>
                                            <Button
                                                variant="outline"
                                                size="icon"
                                                :aria-label="`Restore ${employee.name}`"
                                                @click="confirmRestore(employee)"
                                            >
                                                <Undo2 class="size-4" />
                                            </Button>
                                        </TooltipTrigger>
                                        <TooltipContent>Restore employee</TooltipContent>
                                    </Tooltip>
                                </div>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>

            <AppPagination :pagination="employees" />
        </div>

        <Dialog :open="toRestore !== null" @update:open="(value) => !value && cancelRestore()">
            <DialogContent class="sm:max-w-md">
                <DialogHeader>
                    <DialogTitle>Restore employee?</DialogTitle>
                    <DialogDescription v-if="toRestore">
                        This will reactivate
                        <span class="font-medium">{{ toRestore.name }}</span>
                        ({{ toRestore.email }}) and restore their prior role and store assignments.
                    </DialogDescription>
                </DialogHeader>
                <DialogFooter>
                    <Button variant="outline" :disabled="restoring" @click="cancelRestore">Cancel</Button>
                    <Button :disabled="restoring" @click="performRestore">
                        {{ restoring ? 'Restoring...' : 'Restore employee' }}
                    </Button>
                </DialogFooter>
            </DialogContent>
        </Dialog>
    </AppLayout>
</template>
