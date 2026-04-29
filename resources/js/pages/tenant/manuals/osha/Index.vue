<script setup lang="ts">
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { Download, FileSignature, HardHat, Loader2, Trash2 } from 'lucide-vue-next';
import AppLayout from '@/layouts/tenant/AppLayout.vue';
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import osha from '@/routes/dealer/manual/osha';
import type { BreadcrumbItem } from '@/types';

type Manual = {
    id: number;
    signed_at: string;
    signed_at_iso: string;
    signed_by_name: string;
    store_name: string;
    download_url: string | null;
};

defineProps<{
    store: { id: number; name: string } | null;
    manuals: Manual[];
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'OSHA Manuals', href: osha.index.url() },
];

const deletingId = ref<number | null>(null);
const openDialogId = ref<number | null>(null);

const remove = (manual: Manual): void => {
    deletingId.value = manual.id;
    router.delete(osha.destroy.url({ manual: manual.id }), {
        preserveScroll: true,
        onFinish: () => {
            deletingId.value = null;
        },
        onSuccess: () => {
            openDialogId.value = null;
        },
    });
};
</script>

<template>
    <Head title="OSHA Manuals" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-5">
            <header class="flex flex-wrap items-start justify-between gap-3">
                <Heading
                    title="OSHA Manuals"
                    :description="
                        store
                            ? `Signed OSHA safety manuals for ${store.name}.`
                            : 'Signed OSHA safety manuals across your stores.'
                    "
                />
                <Button v-if="store" as-child size="sm">
                    <Link :href="osha.create.url()">
                        <FileSignature class="size-3.5" />
                        Sign Manual
                    </Link>
                </Button>
            </header>

            <div class="rounded-md border">
                <Table>
                    <TableHeader class="bg-muted/50 [&_tr]:border-b">
                        <TableRow>
                            <TableHead>Date Signed</TableHead>
                            <TableHead>Signed By</TableHead>
                            <TableHead>Store</TableHead>
                            <TableHead class="w-0" />
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <template v-if="manuals.length > 0">
                            <TableRow v-for="manual in manuals" :key="manual.id">
                                <TableCell class="font-medium text-foreground">
                                    {{ manual.signed_at }}
                                </TableCell>
                                <TableCell class="text-muted-foreground">
                                    {{ manual.signed_by_name || '—' }}
                                </TableCell>
                                <TableCell class="text-muted-foreground">
                                    {{ manual.store_name || '—' }}
                                </TableCell>
                                <TableCell class="w-0 whitespace-nowrap pr-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <Button
                                            v-if="manual.download_url"
                                            as-child
                                            variant="outline"
                                            size="sm"
                                        >
                                            <a
                                                :href="manual.download_url"
                                                target="_blank"
                                                rel="noopener"
                                            >
                                                <Download class="size-3.5" />
                                                Download
                                            </a>
                                        </Button>
                                        <span
                                            v-else
                                            class="text-xs italic text-muted-foreground"
                                        >
                                            Generating…
                                        </span>
                                        <Dialog
                                            :open="openDialogId === manual.id"
                                            @update:open="(value) => (openDialogId = value ? manual.id : null)"
                                        >
                                            <DialogTrigger as-child>
                                                <Button variant="ghost" size="icon" aria-label="Delete manual">
                                                    <Trash2 class="size-3.5 text-destructive" />
                                                </Button>
                                            </DialogTrigger>
                                            <DialogContent>
                                                <DialogHeader>
                                                    <DialogTitle>Delete OSHA Manual</DialogTitle>
                                                </DialogHeader>
                                                <p class="text-sm text-muted-foreground">
                                                    Delete the OSHA manual signed on
                                                    <strong>{{ manual.signed_at }}</strong>?
                                                    This permanently removes the PDF and signature.
                                                </p>
                                                <DialogFooter>
                                                    <DialogClose as-child>
                                                        <Button type="button" variant="outline">Cancel</Button>
                                                    </DialogClose>
                                                    <Button
                                                        variant="destructive"
                                                        :disabled="deletingId === manual.id"
                                                        @click="remove(manual)"
                                                    >
                                                        <Loader2 v-if="deletingId === manual.id" class="animate-spin" />
                                                        Delete
                                                    </Button>
                                                </DialogFooter>
                                            </DialogContent>
                                        </Dialog>
                                    </div>
                                </TableCell>
                            </TableRow>
                        </template>
                        <TableRow v-else>
                            <TableCell colspan="4" class="py-12 text-center">
                                <HardHat class="mx-auto size-10 text-muted-foreground" />
                                <p class="mt-3 text-sm text-foreground">No signed manuals yet.</p>
                                <p v-if="!store" class="mt-1 text-xs text-muted-foreground">
                                    Select a store to sign a manual.
                                </p>
                                <div v-if="store" class="mt-4">
                                    <Button as-child size="sm">
                                        <Link :href="osha.create.url()">
                                            <FileSignature class="size-3.5" />
                                            Sign Manual
                                        </Link>
                                    </Button>
                                </div>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>
        </div>
    </AppLayout>
</template>
