<script setup lang="ts">
import SwitchStoreController from '@/actions/App/Http/Controllers/Tenant/Store/SwitchStoreController';
import { router } from '@inertiajs/vue3';
import { ChevronRight } from 'lucide-vue-next';
import { useNullablePageProp } from './props';
import type { LocationGradeRow } from './types';

const locations = useNullablePageProp<LocationGradeRow[]>('location_grades');

const gradePill = (grade: string | null): string => {
    switch (grade) {
        case 'A':
            return 'bg-emerald-50 text-emerald-700 ring-emerald-600/20 dark:bg-emerald-500/15 dark:text-emerald-300 dark:ring-emerald-400/25';
        case 'B':
            return 'bg-sky-50 text-sky-700 ring-sky-600/20 dark:bg-sky-500/15 dark:text-sky-300 dark:ring-sky-400/25';
        case 'C':
            return 'bg-amber-50 text-amber-700 ring-amber-600/25 dark:bg-amber-500/15 dark:text-amber-300 dark:ring-amber-400/25';
        case 'D':
        case 'F':
            return 'bg-rose-50 text-rose-700 ring-rose-600/25 dark:bg-rose-500/15 dark:text-rose-300 dark:ring-rose-400/25';
        default:
            return 'bg-muted text-muted-foreground ring-border';
    }
};

function viewStore(storeId: number): void {
    router.post(
        SwitchStoreController.url(),
        { store_id: storeId },
        { preserveScroll: true },
    );
}
</script>

<template>
    <article v-if="locations !== null" class="overflow-hidden rounded-2xl border bg-card">
        <header class="bg-muted/40 px-5 py-3">
            <h3 class="text-sm font-medium text-foreground">Locations</h3>
        </header>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[640px] text-sm">
                <thead>
                    <tr class="border-b text-left text-xs font-medium text-muted-foreground">
                        <th class="py-3 pl-5 font-medium">Name</th>
                        <th class="py-3 text-center font-medium">Overall</th>
                        <th class="py-3 text-center font-medium">Deal Jackets</th>
                        <th class="py-3 text-center font-medium">OSHA</th>
                        <th class="py-3 text-center font-medium">GLBA</th>
                        <th class="py-3 text-center font-medium">Body Shop</th>
                        <th class="py-3 pr-5 text-right font-medium" />
                    </tr>
                </thead>
                <tbody class="divide-y">
                    <tr
                        v-for="row in locations"
                        :key="row.store_id"
                        tabindex="0"
                        role="button"
                        :aria-label="`Switch to ${row.store_name}`"
                        class="cursor-pointer hover:bg-muted/20 focus:bg-muted/20 focus:outline-none"
                        @click="viewStore(row.store_id)"
                        @keydown.enter.prevent="viewStore(row.store_id)"
                        @keydown.space.prevent="viewStore(row.store_id)"
                    >
                        <td class="max-w-[16rem] truncate py-4 pl-5 font-medium text-foreground" :title="row.store_name">
                            {{ row.store_name }}
                        </td>
                        <td v-for="key in (['overall', 'deal_jacket', 'osha', 'glba', 'body_shop'] as const)" :key="key" class="py-4 text-center">
                            <span
                                v-if="row[key]"
                                class="inline-flex size-6 items-center justify-center rounded-full text-xs font-bold leading-none ring-1 ring-inset"
                                :class="gradePill(row[key])"
                            >
                                {{ row[key] }}
                            </span>
                            <span v-else class="inline-flex size-6 items-center justify-center text-xs text-muted-foreground/50" aria-label="No grade">–</span>
                        </td>
                        <td class="py-4 pr-5 text-right">
                            <ChevronRight class="ml-auto size-4 text-muted-foreground" aria-hidden="true" />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </article>
</template>
