<script setup lang="ts">
import bodyShop from '@/routes/dealer/audit/body-shop';
import { start as startDealJacket } from '@/routes/dealer/audit/deal-jackets';
import finance from '@/routes/dealer/audit/finance';
import osha from '@/routes/dealer/audit/osha';
import { Link, router } from '@inertiajs/vue3';
import { Car, FileText, HardHat, Landmark } from 'lucide-vue-next';
import { computed, type Component } from 'vue';

const props = defineProps<{
    storeId: number;
}>();

type Tile = {
    label: string;
    hint: string;
    icon: Component;
    is: typeof Link | 'button';
    bind: Record<string, unknown>;
};

const startDealJacketGroup = (): void => {
    router.post(startDealJacket.url(), {}, { preserveScroll: true });
};

// OSHA, Body Shop and GLBA create-and-redirect via a GET route scoped to the
// current store; Deal Jackets start a new quarterly group via a POST.
const tiles = computed<Tile[]>(() => [
    {
        label: 'OSHA',
        hint: 'Safety audit',
        icon: HardHat,
        is: Link,
        bind: { href: osha.create.url(props.storeId) },
    },
    {
        label: 'Body Shop',
        hint: 'Body shop audit',
        icon: Car,
        is: Link,
        bind: { href: bodyShop.create.url(props.storeId) },
    },
    {
        label: 'GLBA',
        hint: 'Privacy audit',
        icon: Landmark,
        is: Link,
        bind: { href: finance.create.url(props.storeId) },
    },
    {
        label: 'Deal Jackets',
        hint: 'Quarterly review',
        icon: FileText,
        is: 'button',
        bind: { type: 'button', onClick: startDealJacketGroup },
    },
]);
</script>

<template>
    <article class="overflow-hidden rounded-2xl border bg-card">
        <header class="bg-muted/40 px-5 py-3">
            <h3 class="text-sm font-medium text-foreground">Start an Audit</h3>
        </header>
        <div class="grid grid-cols-2 gap-3 p-4 sm:grid-cols-4">
            <component
                :is="tile.is"
                v-for="tile in tiles"
                :key="tile.label"
                v-bind="tile.bind"
                class="group flex items-center gap-3 rounded-xl border bg-muted/40 px-3.5 py-3 text-left transition hover:border-foreground/15 hover:bg-muted/70 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
            >
                <span
                    class="grid size-9 shrink-0 place-items-center rounded-lg border bg-card text-muted-foreground transition group-hover:text-foreground"
                >
                    <component :is="tile.icon" class="size-4" aria-hidden="true" />
                </span>
                <span class="min-w-0">
                    <span class="block text-sm font-medium text-foreground">{{ tile.label }}</span>
                    <span class="block text-xs text-muted-foreground">{{ tile.hint }}</span>
                </span>
            </component>
        </div>
    </article>
</template>
