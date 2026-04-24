import { Badge } from '@/components/ui/badge';
import { Checkbox } from '@/components/ui/checkbox';
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover';
import type { ColumnDef } from '@tanstack/vue-table';
import { ArrowUpDown, ChevronRight } from 'lucide-vue-next';
import { h } from 'vue';

export type ComplianceStatus = 'compliant' | 'at_risk' | 'overdue' | 'unassigned';

export type TrainingSummary = {
    total_required: number;
    valid_completed: number;
    not_completed: number;
    expired: number;
    expiring_soon: number;
    status: ComplianceStatus;
    status_label: string;
};

export type Employee = {
    id: number;
    name: string;
    slug: string;
    email: string;
    department_name: string | null;
    roles: Array<{ id: number; name: string }>;
    stores: Array<{ id: number; name: string }>;
    training: TrainingSummary;
    has_qualified_individual_role: boolean;
    can_view: boolean;
};

type SortField = 'name' | 'department' | 'role';

export type ColumnsMeta = {
    sortField: SortField;
    sortDirection: 'asc' | 'desc';
    onSort: (field: SortField) => void;
    showStoreColumn: boolean;
};

const sortableHeader = (label: string, field: SortField) => ({ table }: { table: { options: { meta?: unknown } } }) => {
    const meta = table.options.meta as ColumnsMeta;

    return h(
        'button',
        {
            type: 'button',
            class: 'flex items-center gap-1 text-foreground font-medium hover:text-muted-foreground',
            onClick: () => meta.onSort(field),
        },
        [label, h(ArrowUpDown, { class: 'size-3.5 opacity-60' })],
    );
};

const roleBadgeClass = (roleName: string) => {
    switch (roleName) {
        case 'Manager':
            return 'bg-indigo-50 text-indigo-700 ring-indigo-700/10';
        case 'Employee':
            return 'bg-gray-50 text-gray-600 ring-gray-500/10';
        default:
            return 'bg-green-50 text-green-700 ring-green-600/20';
    }
};

const statusBadgeClass = (status: ComplianceStatus) => {
    switch (status) {
        case 'compliant':
            return 'bg-green-100 text-green-700';
        case 'overdue':
            return 'bg-red-100 text-red-700';
        case 'at_risk':
            return 'bg-amber-100 text-amber-700';
        default:
            return 'bg-gray-100 text-gray-700';
    }
};

export const employeeColumns: ColumnDef<Employee>[] = [
    {
        id: 'select',
        header: ({ table }) =>
            h(Checkbox, {
                'modelValue': table.getIsAllRowsSelected() || (table.getIsSomeRowsSelected() && 'indeterminate'),
                'onUpdate:modelValue': (value: boolean | 'indeterminate') =>
                    table.toggleAllRowsSelected(!!value),
                'aria-label': 'Select all',
            }),
        cell: ({ row }) =>
            h(Checkbox, {
                'modelValue': row.getIsSelected(),
                'onUpdate:modelValue': (value: boolean | 'indeterminate') =>
                    row.toggleSelected(!!value),
                'aria-label': `Select ${row.original.name}`,
            }),
        enableSorting: false,
        meta: { headerClass: 'w-12', cellClass: 'w-12' },
    },
    {
        accessorKey: 'name',
        header: sortableHeader('Name', 'name'),
        cell: ({ row }) => {
            const employee = row.original;
            return h('div', { class: 'flex items-center gap-2' }, [
                h(
                    'span',
                    { class: 'truncate', title: employee.name },
                    employee.name,
                ),
                employee.has_qualified_individual_role
                    ? h(
                        'span',
                        {
                            'class': 'shrink-0 rounded bg-emerald-50 px-1.5 py-0.5 text-[10px] font-semibold uppercase tracking-wide text-emerald-700 ring-1 ring-inset ring-emerald-600/20',
                            'title': 'Qualified Individual',
                            'aria-label': 'Qualified Individual',
                        },
                        'QI',
                    )
                    : null,
            ]);
        },
        meta: { cellClass: 'max-w-0' },
    },
    {
        accessorKey: 'roles',
        header: sortableHeader('Role', 'role'),
        enableSorting: false,
        cell: ({ row }) => {
            const roles = row.original.roles;

            if (roles.length === 0) {
                return h(
                    'span',
                    {
                        class: 'inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-800 ring-1 ring-red-600/20 ring-inset',
                    },
                    '!! No Role Assigned !!',
                );
            }

            return h(
                'span',
                { class: 'flex flex-wrap gap-1' },
                roles.map((role) =>
                    h(
                        'span',
                        {
                            key: role.id,
                            class: `inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset ${roleBadgeClass(role.name)}`,
                        },
                        role.name,
                    ),
                ),
            );
        },
    },
    {
        id: 'stores',
        header: 'Store(s)',
        enableSorting: false,
        cell: ({ row }) => {
            const stores = row.original.stores;

            if (stores.length === 0) {
                return h('span', { class: 'text-sm text-muted-foreground' }, '—');
            }

            return h('div', { class: 'flex items-center gap-2' }, [
                h(
                    'span',
                    {
                        class: 'truncate text-sm text-muted-foreground',
                        title: stores[0].name,
                    },
                    stores[0].name,
                ),
                stores.length > 1
                    ? h(Popover, {}, {
                        default: () => [
                            h(PopoverTrigger, { asChild: true }, {
                                default: () => h(
                                    'button',
                                    {
                                        type: 'button',
                                        class: 'inline-flex items-center rounded-md bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-600 ring-1 ring-gray-300 ring-inset',
                                    },
                                    `+${stores.length - 1}`,
                                ),
                            }),
                            h(PopoverContent, { class: 'w-64 space-y-1' }, {
                                default: () => [
                                    h(
                                        'p',
                                        {
                                            class: 'text-xs font-semibold tracking-wide text-gray-500 uppercase',
                                        },
                                        'All Stores',
                                    ),
                                    ...stores.map((store) =>
                                        h(
                                            'p',
                                            {
                                                key: store.id,
                                                class: 'text-sm text-gray-600',
                                            },
                                            store.name,
                                        ),
                                    ),
                                ],
                            }),
                        ],
                    })
                    : null,
            ]);
        },
        meta: { cellClass: 'max-w-0' },
    },
    {
        accessorKey: 'department_name',
        header: sortableHeader('Department', 'department'),
        cell: ({ row }) => {
            const value = row.original.department_name ?? '—';
            return h('span', { class: 'truncate', title: value }, value);
        },
        meta: { cellClass: 'max-w-0' },
    },
    {
        id: 'training',
        header: 'Training',
        enableSorting: false,
        cell: ({ row }) =>
            h(
                Badge,
                {
                    variant: 'secondary',
                    class: `w-fit border-0 px-2 py-1 text-xs font-medium ${statusBadgeClass(row.original.training.status)}`,
                },
                { default: () => row.original.training.status_label },
            ),
    },
    {
        id: 'chevron',
        header: '',
        enableSorting: false,
        cell: ({ row }) =>
            row.original.can_view
                ? h(ChevronRight, { class: 'size-4 text-muted-foreground', 'aria-hidden': 'true' })
                : null,
        meta: { headerClass: 'w-10', cellClass: 'w-10 text-right' },
    },
];

export const buildColumns = (meta: ColumnsMeta): ColumnDef<Employee>[] => {
    if (meta.showStoreColumn) {
        return employeeColumns;
    }

    return employeeColumns.filter((column) => column.id !== 'stores');
};
