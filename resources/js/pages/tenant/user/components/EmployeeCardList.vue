<script setup lang="ts">
import { Checkbox } from '@/components/ui/checkbox';
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover';
import type { RowSelectionState } from '@tanstack/vue-table';
import { ChevronRight } from 'lucide-vue-next';
import { computed } from 'vue';
import { roleBadgeClass, statusBadgeClass, type Employee } from './columns';

const props = defineProps<{
    data: Employee[];
    showStoreColumn: boolean;
    onRowClick?: (employee: Employee) => void;
    isRowClickable?: (employee: Employee) => boolean;
    emptyMessage?: string;
}>();

const rowSelection = defineModel<RowSelectionState>('rowSelection', { default: () => ({}) });

const isSelected = (employee: Employee): boolean => Boolean(rowSelection.value[String(employee.id)]);

const toggleSelection = (employee: Employee, value: boolean | 'indeterminate'): void => {
    const next: RowSelectionState = { ...rowSelection.value };
    const id = String(employee.id);

    if (value) {
        next[id] = true;
    } else {
        delete next[id];
    }

    rowSelection.value = next;
};

const allSelected = computed<boolean>(() =>
    props.data.length > 0 && props.data.every((employee) => isSelected(employee)),
);

const headerState = computed<boolean | 'indeterminate'>(() => {
    if (allSelected.value) {
        return true;
    }

    return props.data.some((employee) => isSelected(employee)) ? 'indeterminate' : false;
});

const toggleAll = (value: boolean | 'indeterminate'): void => {
    const next: RowSelectionState = { ...rowSelection.value };

    for (const employee of props.data) {
        const id = String(employee.id);
        if (value) {
            next[id] = true;
        } else {
            delete next[id];
        }
    }

    rowSelection.value = next;
};

const isClickable = (employee: Employee): boolean =>
    Boolean(props.onRowClick) && (!props.isRowClickable || props.isRowClickable(employee));

const handleCardClick = (event: MouseEvent, employee: Employee): void => {
    if (!props.onRowClick || !isClickable(employee)) {
        return;
    }

    const target = event.target as HTMLElement | null;
    if (target?.closest('a, button, input, label, [role="checkbox"], [data-no-row-click]')) {
        return;
    }

    props.onRowClick(employee);
};
</script>

<template>
    <div class="overflow-hidden rounded-md border">
        <label
            v-if="data.length > 0"
            class="flex items-center gap-3 border-b bg-muted px-3 py-2.5 text-sm font-medium text-muted-foreground"
        >
            <Checkbox
                :model-value="headerState"
                aria-label="Select all"
                @update:model-value="toggleAll"
            />
            Select all on this page
        </label>

        <ul v-if="data.length > 0" class="divide-y">
            <li
                v-for="employee in data"
                :key="employee.id"
                :data-state="isSelected(employee) ? 'selected' : undefined"
                :class="[
                    'flex gap-3 p-3 transition-colors data-[state=selected]:bg-muted/50',
                    isClickable(employee) ? 'cursor-pointer hover:bg-muted/50' : undefined,
                ]"
                @click="(event: MouseEvent) => handleCardClick(event, employee)"
            >
                <Checkbox
                    class="mt-0.5 shrink-0"
                    :model-value="isSelected(employee)"
                    :aria-label="`Select ${employee.name}`"
                    @update:model-value="(value) => toggleSelection(employee, value)"
                />

                <div class="min-w-0 flex-1 space-y-2">
                    <div class="flex items-start gap-2">
                        <div class="flex min-w-0 flex-1 items-center gap-1.5">
                            <span class="truncate font-medium" :title="employee.name">
                                {{ employee.name }}
                            </span>
                            <span
                                v-if="employee.has_qualified_individual_role"
                                class="shrink-0 rounded bg-emerald-50 px-1.5 py-0.5 text-[10px] font-semibold tracking-wide text-emerald-700 uppercase ring-1 ring-emerald-600/20 ring-inset"
                                title="Qualified Individual"
                                aria-label="Qualified Individual"
                            >
                                QI
                            </span>
                        </div>

                        <span
                            :class="[
                                'shrink-0 rounded-md px-2 py-0.5 text-xs font-medium',
                                statusBadgeClass(employee.training.status),
                            ]"
                        >
                            {{ employee.training.status_label }}
                        </span>

                        <ChevronRight
                            v-if="isClickable(employee)"
                            class="mt-0.5 size-4 shrink-0 text-muted-foreground"
                            aria-hidden="true"
                        />
                    </div>

                    <div v-if="employee.roles.length > 0" class="flex flex-wrap gap-1">
                        <span
                            v-for="role in employee.roles"
                            :key="role.id"
                            :class="[
                                'inline-flex items-center rounded-md px-2 py-0.5 text-xs font-medium ring-1 ring-inset',
                                roleBadgeClass(role.name),
                            ]"
                        >
                            {{ role.name }}
                        </span>
                    </div>
                    <span
                        v-else
                        class="inline-flex items-center rounded-md bg-red-50 px-2 py-0.5 text-xs font-medium text-red-800 ring-1 ring-red-600/20 ring-inset"
                    >
                        !! No Role Assigned !!
                    </span>

                    <div class="flex flex-wrap items-center gap-x-1.5 gap-y-1 text-sm text-muted-foreground">
                        <template v-if="showStoreColumn && employee.stores.length > 0">
                            <span class="truncate">{{ employee.stores[0].name }}</span>
                            <Popover v-if="employee.stores.length > 1">
                                <PopoverTrigger as-child>
                                    <button
                                        type="button"
                                        data-no-row-click
                                        class="inline-flex items-center rounded-md bg-gray-100 px-1.5 py-0.5 text-xs font-medium text-gray-600 ring-1 ring-gray-300 ring-inset"
                                    >
                                        +{{ employee.stores.length - 1 }}
                                    </button>
                                </PopoverTrigger>
                                <PopoverContent class="w-64 space-y-1">
                                    <p class="text-xs font-semibold tracking-wide text-gray-500 uppercase">
                                        All Stores
                                    </p>
                                    <p
                                        v-for="store in employee.stores"
                                        :key="store.id"
                                        class="text-sm text-gray-600"
                                    >
                                        {{ store.name }}
                                    </p>
                                </PopoverContent>
                            </Popover>
                            <span aria-hidden="true">·</span>
                        </template>
                        <span class="truncate">{{ employee.department_name ?? '—' }}</span>
                    </div>
                </div>
            </li>
        </ul>

        <p v-else class="py-10 text-center text-sm text-muted-foreground">
            {{ emptyMessage ?? 'No results.' }}
        </p>
    </div>
</template>
