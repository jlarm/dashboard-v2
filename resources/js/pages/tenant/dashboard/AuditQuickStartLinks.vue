<script setup lang="ts">
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import bodyShop from '@/routes/dealer/audit/body-shop';
import { start as startDealJacket } from '@/routes/dealer/audit/deal-jackets';
import finance from '@/routes/dealer/audit/finance';
import osha from '@/routes/dealer/audit/osha';
import { router } from '@inertiajs/vue3';
import { Car, FileText, HardHat, Landmark } from 'lucide-vue-next';
import { computed, ref, type Component } from 'vue';

const props = defineProps<{
    storeId: number;
}>();

type Tile = {
    label: string;
    hint: string;
    icon: Component;
    start: () => void;
};

// OSHA, Body Shop and GLBA create-and-redirect via a GET route scoped to the
// current store; Deal Jackets start a new quarterly group via a POST.
const tiles = computed<Tile[]>(() => [
    {
        label: 'OSHA',
        hint: 'Safety audit',
        icon: HardHat,
        start: () => router.visit(osha.create.url(props.storeId)),
    },
    {
        label: 'Body Shop',
        hint: 'Body shop audit',
        icon: Car,
        start: () => router.visit(bodyShop.create.url(props.storeId)),
    },
    {
        label: 'GLBA',
        hint: 'Privacy audit',
        icon: Landmark,
        start: () => router.visit(finance.create.url(props.storeId)),
    },
    {
        label: 'Deal Jackets',
        hint: 'Quarterly review',
        icon: FileText,
        start: () => router.post(startDealJacket.url(), {}, { preserveScroll: true }),
    },
]);

const open = ref(false);
const pendingTile = ref<Tile | null>(null);

const requestAudit = (tile: Tile): void => {
    pendingTile.value = tile;
    open.value = true;
};

const confirmAudit = (): void => {
    pendingTile.value?.start();
    open.value = false;
};
</script>

<template>
    <article class="overflow-hidden rounded-2xl border bg-card">
        <header class="bg-muted/40 px-5 py-3">
            <h3 class="text-sm font-medium text-foreground">Start an Audit</h3>
        </header>
        <div class="grid grid-cols-2 gap-3 p-4 sm:grid-cols-4">
            <button
                v-for="tile in tiles"
                :key="tile.label"
                type="button"
                class="group flex items-center gap-3 rounded-xl border bg-muted/40 px-3.5 py-3 text-left transition hover:border-foreground/15 hover:bg-muted/70 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
                @click="requestAudit(tile)"
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
            </button>
        </div>
    </article>

    <Dialog v-model:open="open">
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Start a {{ pendingTile?.label }} audit?</DialogTitle>
                <DialogDescription>
                    This will create a new {{ pendingTile?.label }} audit and open it for you to complete.
                </DialogDescription>
            </DialogHeader>
            <DialogFooter>
                <DialogClose as-child>
                    <Button type="button" variant="outline">Cancel</Button>
                </DialogClose>
                <Button type="button" @click="confirmAudit">Start audit</Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
