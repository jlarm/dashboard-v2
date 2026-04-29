<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Separator } from '@/components/ui/separator';
import AppLayout from '@/layouts/tenant/AppLayout.vue';
import CyrismaController from '@/actions/App/Http/Controllers/Tenant/CyrismaController';
import scan from '@/routes/dealer/scan';
import type { BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { CheckCircle2, Loader2, ShieldCheck } from 'lucide-vue-next';

type ScanSettings = {
    store_id: number;
    store_name: string;
    instance_id: string | null;
    is_connected: boolean;
};

const props = defineProps<{
    settings: ScanSettings;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Scans', href: scan.index.url() },
    { title: 'Settings', href: scan.settings.url() },
];

const form = useForm({
    instance_id: props.settings.instance_id ?? '',
});

const submit = (): void => {
    form.put(CyrismaController.update.url(), {
        preserveScroll: true,
    });
};
</script>

<template>
    <Head title="Scan Instance Settings" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="mx-auto max-w-3xl space-y-6 px-4 py-6">
            <Heading
                title="Scan Instance Settings"
                :description="`Connect ${settings.store_name} to a Cyrisma instance to enable vulnerability scans.`"
            />

            <section class="rounded-2xl border bg-card">
                <header class="flex items-center gap-3 px-6 pt-6">
                    <div class="grid size-10 place-items-center rounded-lg bg-indigo-100 text-indigo-700 dark:bg-indigo-500/15 dark:text-indigo-400">
                        <ShieldCheck class="size-5" />
                    </div>
                    <div class="min-w-0">
                        <h2 class="text-base font-semibold tracking-tight text-foreground">Cyrisma Instance</h2>
                        <p class="mt-0.5 text-sm text-muted-foreground">
                            Enter the instance ID assigned to this store. This is the subdomain portion of the Cyrisma URL.
                        </p>
                    </div>
                    <span
                        v-if="settings.is_connected"
                        class="ml-auto inline-flex items-center gap-1.5 rounded-md bg-emerald-50 px-2 py-0.5 text-xs font-medium text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400"
                    >
                        <CheckCircle2 class="size-3.5" />
                        Connected
                    </span>
                </header>

                <Separator class="my-5" />

                <form class="space-y-5 px-6 pb-6" @submit.prevent="submit">
                    <div class="grid gap-2">
                        <Label for="instance_id">Instance ID</Label>
                        <Input
                            id="instance_id"
                            v-model="form.instance_id"
                            type="text"
                            autocomplete="off"
                            placeholder="e.g. acme-dealer"
                        />
                        <p class="text-xs text-muted-foreground">
                            The instance URL is built as <span class="font-mono">{instance-id}.cyrisma.com</span>.
                        </p>
                        <InputError :message="form.errors.instance_id" />
                    </div>

                    <div class="flex items-center justify-end">
                        <Button type="submit" :disabled="form.processing">
                            <Loader2 v-if="form.processing" class="size-3.5 animate-spin" />
                            {{ settings.is_connected ? 'Update' : 'Connect' }}
                        </Button>
                    </div>
                </form>
            </section>
        </div>
    </AppLayout>
</template>
