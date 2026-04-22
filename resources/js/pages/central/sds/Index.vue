<script setup lang="ts">
import { ref, toRef, watch } from "vue";
import { Head, router } from "@inertiajs/vue3";
import AppLayout from "@/layouts/AppLayout.vue";
import type { BreadcrumbItem } from "@/types";
import type { PaginatedResponse } from "@/types/paginator";
import sdsRoutes from "@/routes/sds";
import { useDebounceFn } from "@vueuse/core";
import { ArrowDownIcon, Pencil, Trash2 } from "lucide-vue-next";
import { Input } from "@/components/ui/input";
import { Button } from "@/components/ui/button";
import { ButtonGroup } from "@/components/ui/button-group";
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import AppPagination from "@/components/AppPagination.vue";
import CreateSdsDialog from "@/pages/central/sds/components/CreateSdsDialog.vue";
import EditSdsDialog from "@/pages/central/sds/components/EditSdsDialog.vue";
import DeleteSdsDialog from "@/pages/central/sds/components/DeleteSdsDialog.vue";

type Sheet = {
    id: number;
    uuid: string;
    name: string;
    manufacturer: string | null;
    keywords: string[];
    file_name: string | null;
    download_url: string | null;
};

const props = defineProps<{
    sheets: PaginatedResponse<Sheet>;
    filters: { search?: string };
    can: { create: boolean; update: boolean; delete: boolean };
}>();

const SKELETON_ROWS = 5;

const search = ref(props.filters.search ?? "");
const cachedSheets = ref(props.sheets);

watch(toRef(props, "sheets"), (next) => {
    if (next) {
        cachedSheets.value = next;
    }
});

const performSearch = useDebounceFn(() => {
    router.get(
        sdsRoutes.index.url(),
        { search: search.value || undefined },
        { preserveState: true, replace: true, preserveScroll: true },
    );
}, 300);

watch(search, performSearch);

const breadcrumbItems: BreadcrumbItem[] = [
    { title: "SDS Sheets", href: sdsRoutes.index.url() },
];
</script>

<template>
    <Head title="SDS Sheets" />
    <AppLayout :breadcrumbs="breadcrumbItems">
        <template v-if="can.create" #actions>
            <CreateSdsDialog />
        </template>
        <div>
            <Input v-model="search" placeholder="Search sheets..." class="w-1/3 mb-5" />
            <div class="rounded-md border">
                <Table>
                    <TableHeader class="[&_tr]:border-b bg-muted sticky top-0 z-10">
                        <TableRow>
                            <TableHead class="w-1/2">Name</TableHead>
                            <TableHead class="w-1/2">Manufacturer</TableHead>
                            <TableHead class="w-0"></TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <template v-if="!cachedSheets">
                            <TableRow v-for="i in SKELETON_ROWS" :key="i">
                                <TableCell><div class="bg-muted h-4 w-48 animate-pulse rounded" /></TableCell>
                                <TableCell><div class="bg-muted h-4 w-40 animate-pulse rounded" /></TableCell>
                                <TableCell />
                            </TableRow>
                        </template>
                        <template v-else>
                            <TableRow v-if="cachedSheets.data.length === 0">
                                <TableCell colspan="3" class="py-8 text-center text-sm text-muted-foreground">
                                    No SDS sheets found{{ search ? ` for "${search}"` : "" }}.
                                </TableCell>
                            </TableRow>
                            <TableRow
                                v-for="sheet in cachedSheets.data"
                                :key="sheet.uuid"
                            >
                                <TableCell class="max-w-0 truncate" :title="sheet.name">
                                    {{ sheet.name }}
                                </TableCell>
                                <TableCell class="max-w-0 truncate text-muted-foreground" :title="sheet.manufacturer ?? ''">
                                    {{ sheet.manufacturer || "—" }}
                                </TableCell>
                                <TableCell class="w-0 pr-4">
                                    <ButtonGroup class="flex justify-end">
                                        <Button
                                            v-if="sheet.download_url"
                                            variant="outline"
                                            size="sm"
                                            as-child
                                        >
                                            <a :href="sheet.download_url">
                                                <ArrowDownIcon />
                                            </a>
                                        </Button>
                                        <EditSdsDialog v-if="can.update" :sheet="sheet">
                                            <Button variant="outline" size="sm">
                                                <Pencil />
                                            </Button>
                                        </EditSdsDialog>
                                        <DeleteSdsDialog v-if="can.delete" :sds="sheet">
                                            <Button variant="outline" size="sm" class="hover:bg-red-50 hover:text-red-500">
                                                <Trash2 />
                                            </Button>
                                        </DeleteSdsDialog>
                                    </ButtonGroup>
                                </TableCell>
                            </TableRow>
                        </template>
                    </TableBody>
                </Table>
            </div>
            <div class="mt-5">
                <AppPagination v-if="cachedSheets" :pagination="cachedSheets" />
            </div>
        </div>
    </AppLayout>
</template>
