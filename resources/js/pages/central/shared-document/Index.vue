<script setup lang="ts">
import AppLayout from "@/layouts/AppLayout.vue";
import { BreadcrumbItem } from "@/types";
import sharedDocumentRoutes from "@/routes/shared-documents";
import CreateSharedDocumentDialog from "@/pages/central/shared-document/components/CreateSharedDocumentDialog.vue";
import DeleteSharedDocumentDialog from "@/pages/central/shared-document/components/DeleteSharedDocumentDialog.vue";
import { Table, TableBody, TableCell, TableRow } from "@/components/ui/table";
import { PaginatedResponse } from "@/types/paginator";
import AppPagination from "@/components/AppPagination.vue";
import { Button } from "@/components/ui/button";
import { ArrowDownIcon, Trash2, ArrowUpRight } from "lucide-vue-next";
import { ButtonGroup } from "@/components/ui/button-group";
import { Tooltip, TooltipContent, TooltipTrigger, TooltipProvider } from "@/components/ui/tooltip";
import { Input } from "@/components/ui/input";
import { useDebounceFn } from "@vueuse/core";
import { ref, watch } from "vue";
import { router } from "@inertiajs/vue3";

type Document = {
    id: number;
    title: string;
    url?: string | null;
    file_name?: string | null;
    download_url?: string | null;
}

const props = defineProps<{
    documents: PaginatedResponse<Document>;
    filters: { search?: string };
    can: { create: boolean, delete: boolean };
}>();

const search = ref(props.filters.search ?? '');

const performSearch = useDebounceFn(() => {
    router.get(
        sharedDocumentRoutes.index.url(),
        { search: search.value || undefined },
        { preserveState: true, replace: true }
    );
}, 300);

watch(search, performSearch);

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: "Shared Documents",
        href: sharedDocumentRoutes.index.url(),
    }
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <template #actions>
            <CreateSharedDocumentDialog v-if="props.can.create" />
        </template>
        <div class="w-full max-w-3xl mx-auto">
            <div class="flex items-center justify-between mb-5">
                <Input v-model="search" placeholder="Search documents..." class="w-1/3" />
                <p class="text-sm italic">These documents will be accessible to all dealerships.</p>
            </div>
            <Table>
                <TableBody>
                    <TableRow
                        v-for="document in documents.data"
                        :key="document.id"
                        class="hover:bg-transparent"
                    >
                        <TableCell>
                            {{ document.title }}
                            <span class="block text-xs font-mono text-slate-400 truncate">{{ document.file_name }}</span>
                        </TableCell>
                        <TableCell class="flex justify-end">
                            <TooltipProvider>
                                <ButtonGroup>
                                    <Tooltip>
                                        <TooltipTrigger as-child>
                                            <Button variant="outline" size="sm" class="cursor-pointer" as-child>
                                                <a :href="document.download_url ?? document.url ?? '#'" target="_blank" rel="noreferrer">
                                                    <ArrowDownIcon v-if="document.file_name" />
                                                    <ArrowUpRight v-else />
                                                </a>
                                            </Button>
                                        </TooltipTrigger>
                                        <TooltipContent>
                                            <span v-if="document.file_name">Download</span>
                                            <span v-else>Open Link</span>
                                        </TooltipContent>
                                    </Tooltip>
                                    <Tooltip v-if="props.can.delete">
                                        <TooltipTrigger as-child>
                                            <DeleteSharedDocumentDialog :document="document">
                                                <Button variant="outline" size="sm" class="cursor-pointer hover:text-red-500 hover:bg-red-50">
                                                    <Trash2 />
                                                </Button>
                                            </DeleteSharedDocumentDialog>
                                        </TooltipTrigger>
                                        <TooltipContent>
                                            Delete
                                        </TooltipContent>
                                    </Tooltip>
                                </ButtonGroup>
                            </TooltipProvider>
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
            <div class="mt-5">
                <AppPagination :pagination="documents" />
            </div>
        </div>
    </AppLayout>
</template>
