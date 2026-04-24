<script setup lang="ts">
import UserController from '@/actions/App/Http/Controllers/Tenant/UserController';
import AppPagination from '@/components/AppPagination.vue';
import MultiSelect from '@/components/MultiSelect.vue';
import StatCard from '@/components/StatCard.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import AppLayout from '@/layouts/tenant/AppLayout.vue';
import DataTable from '@/pages/tenant/user/components/DataTable.vue';
import { buildColumns, type Employee } from '@/pages/tenant/user/components/columns';
import employeesRoutes from '@/routes/dealer/employees';
import type { BreadcrumbItem } from '@/types';
import type { PaginatedResponse } from '@/types/paginator';
import { Head, router, useForm } from '@inertiajs/vue3';
import { useDebounceFn } from '@vueuse/core';
import type { RowSelectionState } from '@tanstack/vue-table';
import { Download, RotateCcw, Search, Send } from 'lucide-vue-next';
import { computed, reactive, ref, toRef, watch } from 'vue';

type Option = { id: number; name: string };

type Filters = {
    search: string;
    department_ids: number[];
    role_ids: number[];
    only_incomplete: boolean;
    only_expired: boolean;
    only_expiring_soon: boolean;
    sort_field: 'name' | 'department' | 'role';
    sort_direction: 'asc' | 'desc';
};

type TrainingCounts = {
    employees: number;
    compliant: number;
    at_risk: number;
    overdue: number;
    unassigned: number;
    incomplete_courses: number;
    expired_courses: number;
    expiring_soon_courses: number;
};

const props = defineProps<{
    employees: PaginatedResponse<Employee>;
    trainingCounts: TrainingCounts;
    filters: Filters;
    filterOptions: { departments: Option[]; roles: Option[] };
    permissions: { manage_filters: boolean; email_report: boolean; send_message: boolean };
    storeContext: { multiple_stores: boolean; current_store_name: string };
}>();

const breadcrumbs = computed<BreadcrumbItem[]>(() => [
    { title: 'Employees', href: employeesRoutes.index.url() },
]);

const search = ref(props.filters.search);
const localFilters = reactive<Omit<Filters, 'search'>>({
    department_ids: [...props.filters.department_ids],
    role_ids: [...props.filters.role_ids],
    only_incomplete: props.filters.only_incomplete,
    only_expired: props.filters.only_expired,
    only_expiring_soon: props.filters.only_expiring_soon,
    sort_field: props.filters.sort_field,
    sort_direction: props.filters.sort_direction,
});

const departmentOptions = computed(() =>
    props.filterOptions.departments.map((department) => ({ value: department.id, label: department.name })),
);

const roleOptions = computed(() =>
    props.filterOptions.roles.map((role) => ({ value: role.id, label: role.name })),
);

const rowSelection = ref<RowSelectionState>({});
const selectAllAcrossPages = ref(false);
const selectedUserIds = computed(() => Object.keys(rowSelection.value).map(Number));
const isPageFullySelected = computed(() =>
    props.employees.data.length > 0
    && props.employees.data.every((employee) => rowSelection.value[String(employee.id)]),
);
const hasMorePages = computed(() => props.employees.meta.total > props.employees.data.length);
const selectionCount = computed(() =>
    selectAllAcrossPages.value ? props.employees.meta.total : selectedUserIds.value.length,
);

const employeesRef = toRef(props, 'employees');
watch(employeesRef, () => {
    const visibleIds = new Set(props.employees.data.map((employee) => String(employee.id)));

    if (selectAllAcrossPages.value) {
        const next: RowSelectionState = {};
        for (const id of visibleIds) {
            next[id] = true;
        }
        rowSelection.value = next;
        return;
    }

    const next: RowSelectionState = {};
    for (const id of Object.keys(rowSelection.value)) {
        if (visibleIds.has(id)) {
            next[id] = true;
        }
    }
    rowSelection.value = next;
});

watch(rowSelection, (next) => {
    if (!selectAllAcrossPages.value) {
        return;
    }

    const fullyCovered = props.employees.data.every((employee) => next[String(employee.id)]);
    if (!fullyCovered) {
        selectAllAcrossPages.value = false;
    }
}, { deep: true });

const selectAllMatching = () => {
    selectAllAcrossPages.value = true;
};

const clearSelection = () => {
    selectAllAcrossPages.value = false;
    rowSelection.value = {};
};

type QueryValue = string | string[];

const buildQuery = (): Record<string, QueryValue> => {
    const query: Record<string, QueryValue> = {};

    if (search.value !== '') {
        query.search = search.value;
    }
    if (localFilters.department_ids.length > 0) {
        query.department_ids = localFilters.department_ids.map(String);
    }
    if (localFilters.role_ids.length > 0) {
        query.role_ids = localFilters.role_ids.map(String);
    }
    if (localFilters.only_incomplete) {
        query.only_incomplete = '1';
    }
    if (localFilters.only_expired) {
        query.only_expired = '1';
    }
    if (localFilters.only_expiring_soon) {
        query.only_expiring_soon = '1';
    }
    if (localFilters.sort_field !== 'name') {
        query.sort_field = localFilters.sort_field;
    }
    if (localFilters.sort_direction !== 'asc') {
        query.sort_direction = localFilters.sort_direction;
    }

    return query;
};

const reload = () => {
    router.get(employeesRoutes.index.url(), buildQuery(), {
        preserveState: true,
        preserveScroll: true,
        replace: true,
        only: ['employees', 'trainingCounts', 'filters'],
    });
};

const debouncedSearch = useDebounceFn(() => reload(), 300);
watch(search, debouncedSearch);

const applyFilters = () => {
    clearSelection();
    reload();
};

const toggleCompliance = (key: 'only_incomplete' | 'only_expired' | 'only_expiring_soon') => {
    localFilters[key] = !localFilters[key];
    applyFilters();
};

const debouncedApplyFilters = useDebounceFn(applyFilters, 250);
watch(() => [...localFilters.department_ids], debouncedApplyFilters);
watch(() => [...localFilters.role_ids], debouncedApplyFilters);

const navigateToEmployee = (employee: Employee) => {
    router.visit(employeesRoutes.show.url({ slug: employee.slug }));
};

const onSort = (field: 'name' | 'department' | 'role') => {
    if (localFilters.sort_field === field) {
        localFilters.sort_direction = localFilters.sort_direction === 'asc' ? 'desc' : 'asc';
    } else {
        localFilters.sort_field = field;
        localFilters.sort_direction = 'asc';
    }
    reload();
};

const columns = computed(() =>
    buildColumns({
        sortField: localFilters.sort_field,
        sortDirection: localFilters.sort_direction,
        onSort,
        showStoreColumn: props.storeContext.multiple_stores,
    }),
);

const tableMeta = computed(() => ({
    sortField: localFilters.sort_field,
    sortDirection: localFilters.sort_direction,
    onSort,
    showStoreColumn: props.storeContext.multiple_stores,
}));

const hasActiveFilters = computed(() =>
    search.value !== ''
    || localFilters.only_incomplete
    || localFilters.only_expired
    || localFilters.only_expiring_soon
    || localFilters.department_ids.length > 0
    || localFilters.role_ids.length > 0,
);

const hasComplianceFilter = computed(() =>
    localFilters.only_incomplete || localFilters.only_expired || localFilters.only_expiring_soon,
);

type CompliancePill = {
    key: 'only_incomplete' | 'only_expired' | 'only_expiring_soon';
    label: string;
    toneActive: string;
    toneInactive: string;
};

const compliancePills: CompliancePill[] = [
    {
        key: 'only_incomplete',
        label: 'Incomplete',
        toneActive: 'bg-blue-600 text-white border-blue-600 hover:bg-blue-600',
        toneInactive: 'text-blue-700 border-blue-200 hover:bg-blue-50',
    },
    {
        key: 'only_expired',
        label: 'Expired',
        toneActive: 'bg-red-600 text-white border-red-600 hover:bg-red-600',
        toneInactive: 'text-red-700 border-red-200 hover:bg-red-50',
    },
    {
        key: 'only_expiring_soon',
        label: 'Expiring Soon',
        toneActive: 'bg-amber-500 text-white border-amber-500 hover:bg-amber-500',
        toneInactive: 'text-amber-700 border-amber-200 hover:bg-amber-50',
    },
];

const resetFilters = () => {
    search.value = '';
    localFilters.department_ids = [];
    localFilters.role_ids = [];
    localFilters.only_incomplete = false;
    localFilters.only_expired = false;
    localFilters.only_expiring_soon = false;
    clearSelection();
    reload();
};

const exportCsv = () => {
    if (!selectAllAcrossPages.value && selectedUserIds.value.length === 0) {
        return;
    }

    const form = document.createElement('form');
    form.method = 'POST';
    form.action = UserController.exportMethod.url();
    form.style.display = 'none';

    const csrfToken = document.querySelector<HTMLMetaElement>('meta[name="csrf-token"]')?.content ?? '';
    const csrfInput = document.createElement('input');
    csrfInput.name = '_token';
    csrfInput.value = csrfToken;
    form.appendChild(csrfInput);

    const appendField = (name: string, value: string) => {
        const input = document.createElement('input');
        input.name = name;
        input.value = value;
        form.appendChild(input);
    };

    if (selectAllAcrossPages.value) {
        appendField('select_all', '1');
        for (const [key, value] of Object.entries(buildQuery())) {
            if (Array.isArray(value)) {
                for (const item of value) {
                    appendField(`${key}[]`, item);
                }
            } else {
                appendField(key, value);
            }
        }
    } else {
        for (const id of selectedUserIds.value) {
            appendField('user_ids[]', String(id));
        }
    }

    document.body.appendChild(form);
    form.submit();
    form.remove();
};

const emailForm = useForm({
    email: '',
    search: '',
    department_ids: [] as number[],
    role_ids: [] as number[],
    only_incomplete: false,
    only_expired: false,
    only_expiring_soon: false,
    sort_field: 'name' as Filters['sort_field'],
    sort_direction: 'asc' as Filters['sort_direction'],
});

const submitEmailReport = () => {
    emailForm.search = search.value;
    emailForm.department_ids = [...localFilters.department_ids];
    emailForm.role_ids = [...localFilters.role_ids];
    emailForm.only_incomplete = localFilters.only_incomplete;
    emailForm.only_expired = localFilters.only_expired;
    emailForm.only_expiring_soon = localFilters.only_expiring_soon;
    emailForm.sort_field = localFilters.sort_field;
    emailForm.sort_direction = localFilters.sort_direction;

    emailForm.post(UserController.emailReport.url(), {
        preserveScroll: true,
        onSuccess: () => emailForm.reset('email'),
    });
};
</script>

<template>
    <Head title="Employees" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-5">
            <section class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-5">
                <StatCard
                    label="Overdue"
                    :value="trainingCounts.overdue"
                    caption="Has expired courses"
                />
                <StatCard
                    label="At Risk"
                    :value="trainingCounts.at_risk"
                    caption="Missing or expiring in 30 days"
                />
                <StatCard
                    label="Compliant"
                    :value="trainingCounts.compliant"
                    caption="All courses complete"
                />
                <StatCard
                    label="Unassigned"
                    :value="trainingCounts.unassigned"
                    caption="No required courses"
                />
                <StatCard
                    label="Employees"
                    :value="trainingCounts.employees"
                    caption="Total in scope"
                />
            </section>

            <div class="flex flex-wrap items-center gap-2">
                <div class="relative flex-1 min-w-[16rem] max-w-md">
                    <Search class="pointer-events-none absolute left-3 top-1/2 size-4 -translate-y-1/2 text-muted-foreground" />
                    <Input
                        v-model="search"
                        type="search"
                        placeholder="Search by name or email"
                        class="pl-9"
                    />
                </div>

                <template v-if="permissions.manage_filters">
                    <div class="w-[12rem]">
                        <MultiSelect
                            v-model="localFilters.department_ids"
                            :options="departmentOptions"
                            placeholder="Departments"
                            search-placeholder="Search departments..."
                            :show-chips="false"
                        />
                    </div>

                    <div class="w-[10rem]">
                        <MultiSelect
                            v-model="localFilters.role_ids"
                            :options="roleOptions"
                            placeholder="Roles"
                            search-placeholder="Search roles..."
                            :show-chips="false"
                        />
                    </div>
                </template>

                <div
                    class="flex items-center gap-1 rounded-md border bg-background p-1"
                    role="group"
                    aria-label="Filter by compliance status"
                >
                    <button
                        v-for="pill in compliancePills"
                        :key="pill.key"
                        type="button"
                        class="rounded px-2.5 py-1 text-xs font-medium border border-transparent transition-colors"
                        :class="localFilters[pill.key] ? pill.toneActive : pill.toneInactive"
                        :aria-pressed="localFilters[pill.key]"
                        @click="toggleCompliance(pill.key)"
                    >
                        {{ pill.label }}
                    </button>
                </div>

                <Button
                    v-if="hasActiveFilters"
                    variant="ghost"
                    size="sm"
                    class="text-muted-foreground hover:text-foreground"
                    @click="resetFilters"
                >
                    <RotateCcw class="size-3.5" />
                    Reset
                </Button>

                <div class="ml-auto flex flex-wrap items-center gap-2">
                    <template v-if="selectionCount > 0">
                        <Button
                            v-if="permissions.send_message"
                            variant="outline"
                            size="sm"
                            disabled
                            title="Send message feature coming soon"
                        >
                            <Send class="size-4" />
                            Send Message
                        </Button>

                        <Button variant="default" size="sm" @click="exportCsv">
                            <Download class="size-4" />
                            Export CSV ({{ selectionCount }})
                        </Button>
                    </template>

                    <form
                        v-if="permissions.email_report && localFilters.only_incomplete && localFilters.department_ids.length > 0"
                        class="flex items-center gap-2"
                        @submit.prevent="submitEmailReport"
                    >
                        <Input
                            v-model="emailForm.email"
                            type="email"
                            placeholder="Manager email"
                            class="w-48"
                            required
                        />
                        <Button type="submit" size="sm" :disabled="emailForm.processing">
                            <Send class="size-4" />
                            Send
                        </Button>
                    </form>
                </div>
            </div>

            <div
                v-if="isPageFullySelected && hasMorePages"
                class="flex flex-wrap items-center justify-center gap-2 rounded-md border border-blue-200 bg-blue-50 px-4 py-2 text-sm text-blue-900"
            >
                <template v-if="selectAllAcrossPages">
                    <span>All {{ employees.meta.total }} employees matching the current filters are selected.</span>
                    <button
                        type="button"
                        class="font-medium text-blue-700 underline hover:text-blue-900"
                        @click="clearSelection"
                    >
                        Clear selection
                    </button>
                </template>
                <template v-else>
                    <span>All {{ employees.data.length }} on this page are selected.</span>
                    <button
                        type="button"
                        class="font-medium text-blue-700 underline hover:text-blue-900"
                        @click="selectAllMatching"
                    >
                        Select all {{ employees.meta.total }} employees matching the current filters
                    </button>
                </template>
            </div>

            <DataTable
                v-model:row-selection="rowSelection"
                :columns="columns"
                :data="employees.data"
                :get-row-id="(employee) => String(employee.id)"
                :meta="tableMeta"
                :on-row-click="navigateToEmployee"
                :is-row-clickable="(employee: Employee) => employee.can_view"
                empty-message="No employees match the current filters."
            />

            <AppPagination v-if="!hasComplianceFilter" :pagination="employees" />
        </div>
    </AppLayout>
</template>
