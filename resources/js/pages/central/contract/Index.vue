<script setup lang="ts">
import AppLayout from "@/layouts/AppLayout.vue";
import type { BreadcrumbItem } from "@/types";
import contractRoutes from "@/routes/contracts";
import { Head, Link } from "@inertiajs/vue3";
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { Button } from "@/components/ui/button";
import { Badge } from "@/components/ui/badge";
import type { PaginatedResponse } from "@/types/paginator";
import AppPagination from "@/components/AppPagination.vue";
import DeleteContractDialog from "@/pages/central/contract/components/DeleteContractDialog.vue";

type ContractUser = { id: number; name: string; email: string };

type Contract = {
    id: number;
    uuid: string;
    dealer_name: string;
    dealer_signature: string | null;
    latest_step: number | null;
    user?: ContractUser;
};

defineProps<{
    contracts: PaginatedResponse<Contract>;
    can: { create: boolean };
}>();

const breadcrumbItems: BreadcrumbItem[] = [
    { title: "Contracts", href: contractRoutes.index().url },
];

const titleCase = (value: string): string =>
    value.toLowerCase().replace(/\b\w/g, (char) => char.toUpperCase());

const progressLabel = (step: number | null): { text: string; variant: "secondary" | "default" | "outline" | "destructive" } => {
    switch (step) {
        case 1: return { text: "Contract Created", variant: "secondary" };
        case 2: return { text: "Sent for Review", variant: "outline" };
        case 3: return { text: "Signed by Dealer", variant: "default" };
        case 4: return { text: "Signed by ARMP", variant: "default" };
        case 5: return { text: "Completed", variant: "default" };
        default: return { text: "—", variant: "secondary" };
    }
};
</script>

<template>
    <Head title="Contracts" />
    <AppLayout :breadcrumbs="breadcrumbItems">
        <template #actions>
            <Button v-if="can.create" size="sm" as-child>
                <Link :href="contractRoutes.create().url">Create Contract</Link>
            </Button>
        </template>
        <div class="rounded-md border">
            <Table>
                <TableHeader>
                    <TableRow>
                        <TableHead>Consultant</TableHead>
                        <TableHead>Dealership</TableHead>
                        <TableHead>Status</TableHead>
                        <TableHead class="text-right"></TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <TableRow v-if="contracts.data.length === 0">
                        <TableCell colspan="4" class="py-12 text-center">
                            <h3 class="text-sm font-semibold">No contracts</h3>
                            <p class="mt-1 text-sm text-muted-foreground">Get started by creating a new contract.</p>
                        </TableCell>
                    </TableRow>
                    <TableRow v-for="contract in contracts.data" :key="contract.id">
                        <TableCell>{{ contract.user?.name ?? '—' }}</TableCell>
                        <TableCell>
                            {{ titleCase(contract.dealer_name) }}
                        </TableCell>
                        <TableCell>
                            <Badge :variant="progressLabel(contract.latest_step).variant">
                                {{ progressLabel(contract.latest_step).text }}
                            </Badge>
                        </TableCell>
                        <TableCell class="text-right">
                            <div class="flex justify-end gap-2">
                                <Button size="sm" variant="outline" as-child>
                                    <Link :href="contractRoutes.edit(contract.uuid).url">View</Link>
                                </Button>
                                <DeleteContractDialog
                                    v-if="!contract.dealer_signature"
                                    :contract="contract"
                                />
                            </div>
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>
        <div class="mt-5">
            <AppPagination :pagination="contracts" />
        </div>
    </AppLayout>
</template>
