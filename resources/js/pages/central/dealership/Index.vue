<script setup lang="ts">
import AppLayout from "@/layouts/AppLayout.vue";
import { BreadcrumbItem } from "@/types";
import dealershipRoutes from "@/routes/dealerships";
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from "@/components/ui/table";
import { Avatar, AvatarFallback } from "@/components/ui/avatar";
import {
    Tooltip,
    TooltipContent,
    TooltipProvider,
    TooltipTrigger,
} from "@/components/ui/tooltip";
import AppPagination from "@/components/AppPagination.vue";
// import CreateDealershipDialog from "@/pages/Central/Dealership/components/CreateDealershipDialog.vue";
import type { PaginatedResponse } from "@/types/paginator";
import {ref, watch, toRef} from "vue";
import {useDebounceFn} from "@vueuse/core";
import {Head, router} from "@inertiajs/vue3";
import DealershipController from "@/actions/App/Http/Controllers/Central/DealershipController";
import {Input} from "@/components/ui/input";
import {Button} from "@/components/ui/button";
import CopyButton from "@/components/CopyButton.vue";
import CreateDealershipDialog from "@/pages/central/dealership/components/CreateDealershipDialog.vue";

type DealershipUser = {
    id: number | string;
    name: string;
};

type Dealership = {
    id: string;
    name: string;
    users: DealershipUser[];
    domain: string | null;
};

type Consultant = {
    id: number;
    name: string;
};

const props = defineProps<{
    dealerships?: PaginatedResponse<Dealership>;
    filters: { search?: string };
    consultants?: Consultant[];
}>();

const SKELETON_ROWS = 5;

const search = ref(props.filters.search ?? '');

const cachedDealerships = ref(props.dealerships);

watch(toRef(props, 'dealerships'), (next) => {
    if (next) {
        cachedDealerships.value = next;
    }
});

const performSearch = useDebounceFn(() => {
    router.get(
        DealershipController.index.url(),
        { search: search.value || undefined },
        { preserveState: true, replace: true, preserveScroll: true }
    );
}, 300);

watch(search, performSearch);

const initials = (name: string): string => {
    const parts = name.trim().split(/\s+/);
    return parts.length >= 2
        ? (parts[0][0] + parts[parts.length - 1][0]).toUpperCase()
        : name.slice(0, 2).toUpperCase();
};

const dealershipUrl = (domain: string | null): string | null => {
    if (!domain) {
        return null;
    }

    return `https://${domain}/dashboard`;
};

const truncatedUuid = (id: string): string => {
    return `${id.substring(0, 8)}...${id.substring(id.length - 4)}`;
};

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: "Dealerships",
        href: dealershipRoutes.index(),
    },
];
</script>

<template>
    <Head title="Dealerships" />
    <AppLayout :breadcrumbs="breadcrumbItems">
        <template #actions>
            <CreateDealershipDialog :consultants="props.consultants ?? []" />
        </template>
        <div>
            <Input v-model="search" placeholder="Search dealerships..." class="w-1/3 mb-5" />
            <div class="rounded-md border">
                <Table>
                    <TableHeader class="[&_tr]:border-b bg-muted sticky top-0 z-10">
                        <TableRow>
                            <TableHead class="w-1/4">ID</TableHead>
                            <TableHead class="w-1/4 text-left">Name</TableHead>
                            <TableHead class="w-1/4">Users</TableHead>
                            <TableHead class="w-1/4"></TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <template v-if="!cachedDealerships">
                            <TableRow v-for="i in SKELETON_ROWS" :key="i">
                                <TableCell><div class="bg-muted h-4 w-32 animate-pulse rounded" /></TableCell>
                                <TableCell><div class="bg-muted h-4 w-40 animate-pulse rounded" /></TableCell>
                                <TableCell><div class="bg-muted h-8 w-16 animate-pulse rounded-full" /></TableCell>
                                <TableCell />
                            </TableRow>
                        </template>
                        <template v-else>
                            <TableRow v-if="cachedDealerships.data.length === 0">
                                <TableCell colspan="4" class="py-8 text-center text-sm text-muted-foreground">
                                    No dealerships found{{ search ? ` for "${search}"` : '' }}.
                                </TableCell>
                            </TableRow>
                            <TableRow
                                v-for="dealership in cachedDealerships.data"
                                :key="dealership.id"
                            >
                                <TableCell>
                                    <div class="inline-flex items-center gap-1.5">
                                        <span class="font-mono text-xs text-zinc-600 dark:text-zinc-200">{{ truncatedUuid(dealership.id) }}</span>
                                        <CopyButton :textToCopy="dealership.id" />
                                    </div>
                                </TableCell>
                                <TableCell class="text-left">{{ dealership.name }}</TableCell>
                                <TableCell>
                                    <div class="flex -space-x-2">
                                        <TooltipProvider
                                            v-for="user in dealership.users"
                                            :key="user.id"
                                        >
                                            <Tooltip>
                                                <TooltipTrigger>
                                                    <Avatar class="size-8 ring-2 ring-white dark:ring-zinc-900">
                                                        <AvatarFallback class="text-xs">{{ initials(user.name) }}</AvatarFallback>
                                                    </Avatar>
                                                </TooltipTrigger>
                                                <TooltipContent>{{ user.name }}</TooltipContent>
                                            </Tooltip>
                                        </TooltipProvider>
                                    </div>
                                </TableCell>
                                <TableCell class="text-right">
                                    <Button
                                        v-if="dealershipUrl(dealership.domain)"
                                        size="sm"
                                        variant="outline"
                                        as-child
                                    >
                                        <a
                                            :href="dealershipUrl(dealership.domain) ?? undefined"
                                            target="_blank"
                                            rel="noreferrer"
                                        >
                                            View
                                        </a>
                                    </Button>
                                </TableCell>
                            </TableRow>
                        </template>
                    </TableBody>
                </Table>
            </div>
            <div class="mt-5">
                <AppPagination v-if="cachedDealerships" :pagination="cachedDealerships" />
            </div>
        </div>
    </AppLayout>
</template>
