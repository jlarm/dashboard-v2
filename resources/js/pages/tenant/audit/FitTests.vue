<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { ArrowDownIcon, Trash2 } from 'lucide-vue-next';
import AppLayout from '@/layouts/tenant/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { ButtonGroup } from '@/components/ui/button-group';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import { Tooltip, TooltipContent, TooltipProvider, TooltipTrigger } from '@/components/ui/tooltip';
import UploadFitTestDialog from '@/pages/tenant/audit/components/UploadFitTestDialog.vue';
import DeleteFitTestDialog from '@/pages/tenant/audit/components/DeleteFitTestDialog.vue';
import fitTests from '@/routes/dealer/fit-tests';
import type { BreadcrumbItem } from '@/types';

type FitTestItem = {
    id: number;
    employee_name: string;
    date: string;
    download_url: string;
};

type Employee = {
    id: number;
    name: string;
};

defineProps<{
    fitTests: FitTestItem[];
    employees: Employee[];
    formUrl: string;
    can: { manage: boolean };
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Fit Tests', href: fitTests.index.url() },
];
</script>

<template>
    <Head title="Fit Tests" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-5">
            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                <h1 class="text-lg font-semibold">Fit Tests</h1>
                <div class="flex flex-wrap items-center gap-2">
                    <Button variant="outline" size="sm" as-child>
                        <a :href="formUrl" target="_blank" rel="noopener noreferrer">Download Form</a>
                    </Button>
                    <UploadFitTestDialog v-if="can.manage" :employees="employees" />
                </div>
            </div>

            <div class="rounded-md border">
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>Employee Name</TableHead>
                            <TableHead>Test Date</TableHead>
                            <TableHead class="text-right">Actions</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <template v-if="fitTests.length > 0">
                            <TableRow v-for="item in fitTests" :key="item.id" class="hover:bg-transparent">
                                <TableCell class="font-medium text-foreground">
                                    {{ item.employee_name }}
                                </TableCell>
                                <TableCell class="text-muted-foreground">
                                    {{ item.date }}
                                </TableCell>
                                <TableCell class="flex justify-end">
                                    <TooltipProvider>
                                        <ButtonGroup>
                                            <Tooltip>
                                                <TooltipTrigger as-child>
                                                    <Button variant="outline" size="sm" as-child>
                                                        <a :href="item.download_url" target="_blank" rel="noopener">
                                                            <ArrowDownIcon />
                                                        </a>
                                                    </Button>
                                                </TooltipTrigger>
                                                <TooltipContent>Download</TooltipContent>
                                            </Tooltip>
                                            <Tooltip v-if="can.manage">
                                                <TooltipTrigger as-child>
                                                    <DeleteFitTestDialog :fit-test="{ id: item.id, employeeName: item.employee_name }">
                                                        <Button variant="outline" size="sm" class="hover:bg-red-50 hover:text-red-500">
                                                            <Trash2 />
                                                        </Button>
                                                    </DeleteFitTestDialog>
                                                </TooltipTrigger>
                                                <TooltipContent>Delete</TooltipContent>
                                            </Tooltip>
                                        </ButtonGroup>
                                    </TooltipProvider>
                                </TableCell>
                            </TableRow>
                        </template>
                        <TableRow v-else>
                            <TableCell colspan="3" class="py-10 text-center text-sm text-muted-foreground">
                                No fit tests have been uploaded.
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>
        </div>
    </AppLayout>
</template>
