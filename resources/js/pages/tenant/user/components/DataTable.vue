<script setup lang="ts" generic="TData, TValue">
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { valueUpdater } from '@/components/ui/table/utils';
import type { ColumnDef, RowSelectionState } from '@tanstack/vue-table';
import { FlexRender, getCoreRowModel, useVueTable } from '@tanstack/vue-table';
import { ref, watch } from 'vue';

const props = defineProps<{
    columns: ColumnDef<TData, TValue>[];
    data: TData[];
    getRowId: (row: TData) => string;
    emptyMessage?: string;
    meta?: Record<string, unknown>;
    onRowClick?: (row: TData) => void;
    isRowClickable?: (row: TData) => boolean;
}>();

const handleRowClick = (event: MouseEvent, row: TData) => {
    if (!props.onRowClick) {
        return;
    }

    if (props.isRowClickable && !props.isRowClickable(row)) {
        return;
    }

    const target = event.target as HTMLElement | null;
    if (target?.closest('a, button, input, label, [role="checkbox"], [data-no-row-click]')) {
        return;
    }

    props.onRowClick(row);
};

const rowSelection = defineModel<RowSelectionState>('rowSelection', { default: () => ({}) });

const internalRowSelection = ref<RowSelectionState>(rowSelection.value);

watch(
    rowSelection,
    (next) => {
        internalRowSelection.value = next;
    },
    { immediate: true },
);

watch(internalRowSelection, (next) => {
    rowSelection.value = next;
});

const table = useVueTable({
    get data() {
        return props.data;
    },
    get columns() {
        return props.columns;
    },
    state: {
        get rowSelection() {
            return internalRowSelection.value;
        },
    },
    getRowId: (row) => props.getRowId(row),
    enableRowSelection: true,
    onRowSelectionChange: (updater) => valueUpdater(updater, internalRowSelection),
    getCoreRowModel: getCoreRowModel(),
    meta: props.meta,
});
</script>

<template>
    <div class="rounded-md border">
        <Table class="table-fixed">
            <TableHeader class="bg-muted">
                <TableRow
                    v-for="headerGroup in table.getHeaderGroups()"
                    :key="headerGroup.id"
                >
                    <TableHead
                        v-for="header in headerGroup.headers"
                        :key="header.id"
                        :style="header.column.columnDef.meta && 'headerClass' in (header.column.columnDef.meta as object)
                            ? undefined
                            : undefined"
                        :class="(header.column.columnDef.meta as { headerClass?: string } | undefined)?.headerClass"
                    >
                        <FlexRender
                            v-if="!header.isPlaceholder"
                            :render="header.column.columnDef.header"
                            :props="header.getContext()"
                        />
                    </TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                <template v-if="table.getRowModel().rows.length > 0">
                    <TableRow
                        v-for="row in table.getRowModel().rows"
                        :key="row.id"
                        :data-state="row.getIsSelected() ? 'selected' : undefined"
                        :class="onRowClick && (!isRowClickable || isRowClickable(row.original))
                            ? 'cursor-pointer hover:bg-muted/50'
                            : undefined"
                        @click="(event: MouseEvent) => handleRowClick(event, row.original)"
                    >
                        <TableCell
                            v-for="cell in row.getVisibleCells()"
                            :key="cell.id"
                            :class="(cell.column.columnDef.meta as { cellClass?: string } | undefined)?.cellClass"
                        >
                            <FlexRender
                                :render="cell.column.columnDef.cell"
                                :props="cell.getContext()"
                            />
                        </TableCell>
                    </TableRow>
                </template>
                <TableRow v-else>
                    <TableCell
                        :colspan="table.getAllColumns().length"
                        class="py-10 text-center text-sm text-muted-foreground"
                    >
                        {{ emptyMessage ?? 'No results.' }}
                    </TableCell>
                </TableRow>
            </TableBody>
        </Table>
    </div>
</template>
