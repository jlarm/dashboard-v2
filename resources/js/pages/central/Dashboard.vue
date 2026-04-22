<script setup lang="ts">

import {Head} from "@inertiajs/vue3";
import AppLayout from "@/layouts/AppLayout.vue";
import { PaginatedResponse } from '@/types/paginator';
import {Table, TableBody, TableCell, TableRow} from "@/components/ui/table";
import { ChevronRight } from "lucide-vue-next";

type Dealership = {
    id: string;
    name: string;
    domain: string | null;
}

defineProps<{
    dealerships?: PaginatedResponse<Dealership>;
}>();

const SKELETON_ROWS = 5;

const dealershipUrl = (domain: string | null): string | null => {
    if (!domain) {
        return null;
    }
    return `https://${domain}/dashboard`;
};

const openDealership = (domain: string | null): void => {
    const url = dealershipUrl(domain);
    if (url) {
        window.open(url, '_blank', 'noopener,noreferrer');
    }
};
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout>
        <div class="rounded-md border w-full max-w-xl mx-auto">
            <Table>
                <TableBody>
                    <template v-if="!dealerships">
                        <TableRow v-for="i in SKELETON_ROWS" :key="i">
                            <TableCell>
                                <div class="bg-muted h-4 w-40 animate-pulse rounded" />
                            </TableCell>
                            <TableCell />
                        </TableRow>
                    </template>
                    <template v-else>
                        <TableRow v-if="dealerships.data.length === 0">
                            <TableCell colspan="2" class="py-8 text-center text-sm text-muted-foreground">
                                No dealerships found.
                            </TableCell>
                        </TableRow>
                        <TableRow
                            v-for="dealership in dealerships.data"
                            :key="dealership.id"
                            :class="dealership.domain ? 'cursor-pointer' : ''"
                            @click="openDealership(dealership.domain)"
                        >
                            <TableCell class="font-medium">{{ dealership.name }}</TableCell>
                            <TableCell class="text-right">
                                <ChevronRight v-if="dealership.domain" class="size-4 ml-auto" />
                            </TableCell>
                        </TableRow>
                    </template>
                </TableBody>
            </Table>
        </div>
    </AppLayout>
</template>
