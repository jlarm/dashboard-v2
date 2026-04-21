<script setup lang="ts">
import { Head, router } from "@inertiajs/vue3";
import AppLayout from "@/layouts/AppLayout.vue";
import { BreadcrumbItem, PaginatedResponse } from "@/types";
import violationStatements from "@/routes/violation-statements";
import { ref, watch } from "vue";
import { useDebounceFn } from "@vueuse/core";
import { Input } from "@/components/ui/input";
import { NativeSelect, NativeSelectOption } from "@/components/ui/native-select";
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { Button } from "@/components/ui/button";
import { ButtonGroup } from "@/components/ui/button-group";
import AppPagination from "@/components/AppPagination.vue";
import CreateViolationStatementDialog from "@/pages/central/violation-statements/components/CreateViolationStatementDialog.vue";
import EditViolationStatementDialog from "@/pages/central/violation-statements/components/EditViolationStatementDialog.vue";
import DeleteViolationStatementDialog from "@/pages/central/violation-statements/components/DeleteViolationStatementDialog.vue";
import { Pencil, Trash2 } from "lucide-vue-next";

type Statement = {
    id: number;
    statement: string;
    weight: number;
    categories: string[];
    category_labels: string[];
    keywords: string[];
    reference_image_url: string | null;
};

type CategoryOption = { value: string; label: string };

const props = defineProps<{
    statements: PaginatedResponse<Statement>;
    filters: { search: string | null; category: string | null };
    categories: CategoryOption[];
    can: { create: boolean; update: boolean; delete: boolean };
}>();

const search = ref(props.filters.search ?? "");
const category = ref(props.filters.category ?? "");

const performSearch = useDebounceFn(() => {
    router.get(
        violationStatements.index.url(),
        {
            search: search.value || undefined,
            category: category.value || undefined,
        },
        { preserveState: true, replace: true },
    );
}, 300);

watch([search, category], performSearch);

const breadcrumbItems: BreadcrumbItem[] = [
    { title: "Violation Statements", href: violationStatements.index.url() },
];
</script>

<template>
    <Head title="Violation Statements" />
    <AppLayout :breadcrumbs="breadcrumbItems">
        <template v-if="can.create" #actions>
            <CreateViolationStatementDialog :categories="categories" />
        </template>
        <div>
            <div class="mb-5 flex items-center gap-3">
                <Input v-model="search" placeholder="Search statements..." class="w-1/3" />
                <NativeSelect v-model="category" class="w-56 bg-none">
                    <NativeSelectOption value="">All categories</NativeSelectOption>
                    <NativeSelectOption
                        v-for="option in categories"
                        :key="option.value"
                        :value="option.value"
                    >
                        {{ option.label }}
                    </NativeSelectOption>
                </NativeSelect>
            </div>
            <div class="rounded-md border">
                <Table>
                    <TableHeader class="[&_tr]:border-b bg-muted sticky top-0 z-10">
                        <TableRow>
                            <TableHead>Statement</TableHead>
                            <TableHead class="w-48">Categories</TableHead>
                            <TableHead class="w-24">Weight</TableHead>
                            <TableHead class="w-32"></TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="statement in statements.data" :key="statement.id">
                            <TableCell class="max-w-0 truncate" :title="statement.statement">
                                {{ statement.statement }}
                            </TableCell>
                            <TableCell class="text-sm text-muted-foreground">
                                {{ statement.category_labels.join(", ") }}
                            </TableCell>
                            <TableCell>{{ statement.weight }}</TableCell>
                            <TableCell class="flex justify-end">
                                <ButtonGroup>
                                    <EditViolationStatementDialog
                                        v-if="can.update"
                                        :statement="statement"
                                        :categories="categories"
                                    >
                                        <Button variant="outline" size="sm">
                                            <Pencil />
                                        </Button>
                                    </EditViolationStatementDialog>
                                    <DeleteViolationStatementDialog
                                        v-if="can.delete"
                                        :statement="statement"
                                    >
                                        <Button variant="outline" size="sm" class="hover:bg-red-50 hover:text-red-500">
                                            <Trash2 />
                                        </Button>
                                    </DeleteViolationStatementDialog>
                                </ButtonGroup>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>
            <div class="mt-5">
                <AppPagination :pagination="statements" />
            </div>
        </div>
    </AppLayout>
</template>
