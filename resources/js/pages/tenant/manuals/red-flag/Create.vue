<script setup lang="ts">
import { computed } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import { Loader2 } from 'lucide-vue-next';
import AppLayout from '@/layouts/tenant/AppLayout.vue';
import { Button } from '@/components/ui/button';
import SignaturePad from '@/components/manuals/SignaturePad.vue';
import redFlag from '@/routes/dealer/manual/red-flag';
import dealer from '@/routes/dealer/dealer';
import type { BreadcrumbItem } from '@/types';

type Defaults = {
    store_id: number;
    store_name: string;
    qualified_individual_name: string;
    qualified_individual_phone: string;
    owner_name: string;
    owner_phone: string;
    general_manager_name: string;
    general_manager_phone: string;
    service_manager_name: string;
    service_manager_phone: string;
    parts_manager_name: string;
    parts_manager_phone: string;
    body_shop_manager_name: string;
    body_shop_manager_phone: string;
    police_emergency_phone: string;
    police_non_emergency_phone: string;
    fire_emergency_phone: string;
    fire_non_emergency_phone: string;
    fire_alarm_type: string;
    burglar_alarm_type: string;
};

const props = defineProps<{
    defaults: Defaults;
    policyHtml: string;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Red Flag Manuals', href: redFlag.index.url() },
    { title: 'Sign Manual', href: redFlag.create.url() },
];

const form = useForm({
    signature: null as string | null,
});

const canSubmit = computed(() => form.signature !== null && !form.processing);

const submit = (): void => {
    form.post(redFlag.store.url(), {
        preserveScroll: true,
        onError: () => {
            document.getElementById('form')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
        },
    });
};

const qi = computed(() => props.defaults.qualified_individual_name);
const qip = computed(() => props.defaults.qualified_individual_phone);
const owner = computed(() => props.defaults.owner_name);
const ownerp = computed(() => props.defaults.owner_phone);
const gm = computed(() => props.defaults.general_manager_name);
const gmp = computed(() => props.defaults.general_manager_phone);
const sm = computed(() => props.defaults.service_manager_name);
const smp = computed(() => props.defaults.service_manager_phone);
const pm = computed(() => props.defaults.parts_manager_name);
const pmp = computed(() => props.defaults.parts_manager_phone);
const bsm = computed(() => props.defaults.body_shop_manager_name);
const bsmp = computed(() => props.defaults.body_shop_manager_phone);
const pepn = computed(() => props.defaults.police_emergency_phone);
const pnepn = computed(() => props.defaults.police_non_emergency_phone);
const fepn = computed(() => props.defaults.fire_emergency_phone);
const fnepn = computed(() => props.defaults.fire_non_emergency_phone);
const storeName = computed(() => props.defaults.store_name);
</script>

<template>
    <Head title="Sign Red Flag Manual" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-5">
<div class="prose prose-sm dark:prose-invert max-w-none space-y-10">
                <!-- Contact summary -->
                <section class="not-prose grid gap-4 rounded-lg border bg-card p-5 sm:grid-cols-2 lg:grid-cols-3">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-muted-foreground">Qualified Individual</p>
                        <p class="text-sm font-medium text-foreground">{{ qi || '—' }}</p>
                        <p class="text-xs text-muted-foreground">{{ qip }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-muted-foreground">Owner</p>
                        <p class="text-sm font-medium text-foreground">{{ owner || '—' }}</p>
                        <p class="text-xs text-muted-foreground">{{ ownerp }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-muted-foreground">General Manager</p>
                        <p class="text-sm font-medium text-foreground">{{ gm || '—' }}</p>
                        <p class="text-xs text-muted-foreground">{{ gmp }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-muted-foreground">Service Manager</p>
                        <p class="text-sm font-medium text-foreground">{{ sm || '—' }}</p>
                        <p class="text-xs text-muted-foreground">{{ smp }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-muted-foreground">Parts Manager</p>
                        <p class="text-sm font-medium text-foreground">{{ pm || '—' }}</p>
                        <p class="text-xs text-muted-foreground">{{ pmp }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-muted-foreground">Body Shop Manager</p>
                        <p class="text-sm font-medium text-foreground">{{ bsm || '—' }}</p>
                        <p class="text-xs text-muted-foreground">{{ bsmp }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-muted-foreground">Police Emergency</p>
                        <p class="text-sm font-medium text-foreground">{{ pepn || '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-muted-foreground">Police Non-Emergency</p>
                        <p class="text-sm font-medium text-foreground">{{ pnepn || '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-muted-foreground">Fire Emergency</p>
                        <p class="text-sm font-medium text-foreground">{{ fepn || '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-muted-foreground">Fire Non-Emergency</p>
                        <p class="text-sm font-medium text-foreground">{{ fnepn || '—' }}</p>
                    </div>
                </section>

                <p class="text-sm text-muted-foreground">
                    If any of the information above is outdated, please make adjustments in
                    <a class="underline" :href="dealer.settings.url()">settings</a>
                    before signing.
                </p>

                <!-- Policy content rendered server-side -->
                <div class="red-flag-policy" v-html="policyHtml" />

                <!-- Signature -->
                <section id="form" class="not-prose">
                    <div class="rounded-lg border bg-card p-6">
                        <h2 class="text-base font-semibold text-foreground">Signature</h2>
                        <p class="mt-1 text-sm text-muted-foreground">
                            Sign below to acknowledge that you have reviewed and accepted the policies in this manual.
                        </p>
                        <form class="mt-5 space-y-4" @submit.prevent="submit">
                            <SignaturePad
                                v-model="form.signature"
                                :error="form.errors.signature ?? null"
                            />
                            <Button type="submit" :disabled="!canSubmit">
                                <Loader2 v-if="form.processing" class="animate-spin" />
                                Submit Manual
                            </Button>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
.red-flag-policy :deep(h1) {
    color: var(--primary);
    font-size: 1.5rem;
    font-weight: 700;
    margin-top: 2rem;
    margin-bottom: 1rem;
}
.red-flag-policy :deep(h2) {
    color: var(--primary);
    font-size: 1.125rem;
    font-weight: 600;
    margin-top: 1.25rem;
    margin-bottom: 0.5rem;
}
.red-flag-policy :deep(h4) {
    color: var(--primary);
    font-weight: 600;
}
.red-flag-policy :deep(p) {
    line-height: 1.6;
    margin-bottom: 0.75rem;
}
.red-flag-policy :deep(ul),
.red-flag-policy :deep(ol) {
    list-style-position: outside;
    padding-left: 1.5rem;
    margin-bottom: 0.75rem;
}
.red-flag-policy :deep(ul) {
    list-style-type: disc;
}
.red-flag-policy :deep(ol) {
    list-style-type: decimal;
}
.red-flag-policy :deep(li) {
    margin-bottom: 0.25rem;
}
.red-flag-policy :deep(a) {
    color: var(--primary);
    text-decoration: underline;
}
.red-flag-policy :deep(.text-arm-blue-600),
.red-flag-policy :deep(.text-arm-blue-500) {
    color: var(--primary);
}
</style>
