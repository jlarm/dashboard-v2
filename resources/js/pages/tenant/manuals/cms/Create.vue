<script setup lang="ts">
import { computed } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import { AlertTriangle, Loader2 } from 'lucide-vue-next';
import AppLayout from '@/layouts/tenant/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import NamedSignatureBlock from '@/components/manuals/NamedSignatureBlock.vue';
import SignaturePad from '@/components/manuals/SignaturePad.vue';
import cms from '@/routes/dealer/manual/cms';
import dealer from '@/routes/dealer/dealer';
import employees from '@/routes/dealer/employees';
import type { BreadcrumbItem } from '@/types';

type Defaults = {
    store_id: number;
    store_name: string;
    tenant_name: string;
    qualified_individual_name: string | null;
    standard_dpp_rate: string | null;
    today: string;
    today_day: string;
    today_month: string;
    today_year: string;
};

const props = defineProps<{
    defaults: Defaults;
    introHtml: string;
    dppHtml: string;
    formExampleHtml: string;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'CMS Manuals', href: cms.index.url() },
    { title: 'Sign Manual', href: cms.create.url() },
];

const form = useForm({
    qi_name: props.defaults.qualified_individual_name ?? '',
    standard_dpp_rate: props.defaults.standard_dpp_rate ?? '',
    adoption_approval_name_one: '',
    adoption_approval_signature_one: null as string | null,
    adoption_approval_name_two: '',
    adoption_approval_signature_two: null as string | null,
    adoption_approval_name_three: '',
    adoption_approval_signature_three: null as string | null,
    dealer_participation_name: '',
    dealer_participation_signature: null as string | null,
    acknowledgement_name: '',
    acknowledgement_signature: null as string | null,
});

const missingQi = computed(() => !props.defaults.qualified_individual_name);
const missingDppRate = computed(() => !props.defaults.standard_dpp_rate);
const blocked = computed(() => missingQi.value || missingDppRate.value);

const canSubmit = computed(
    () =>
        !blocked.value
        && !form.processing
        && form.acknowledgement_name.trim() !== ''
        && form.acknowledgement_signature !== null,
);

const submit = (): void => {
    form.post(cms.store.url(), {
        preserveScroll: true,
        onError: () => {
            document.getElementById('acknowledgement')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
        },
    });
};
</script>

<template>
    <Head title="Sign CMS Manual" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-5">
<div v-if="blocked" class="rounded-lg border border-destructive/50 bg-destructive/5 p-4">
                <div class="flex gap-3">
                    <AlertTriangle class="mt-0.5 size-5 shrink-0 text-destructive" />
                    <div class="space-y-2">
                        <p class="text-sm font-semibold text-foreground">
                            This manual cannot be signed yet.
                        </p>
                        <ul class="list-disc space-y-1 pl-5 text-sm text-muted-foreground">
                            <li v-if="missingQi">
                                A
                                <strong>Qualified Individual</strong> must be assigned.
                                <a class="underline" :href="employees.index.url()">Manage employees</a>.
                            </li>
                            <li v-if="missingDppRate">
                                A
                                <strong>Standard DPP Rate</strong> must be set on the store.
                                <a class="underline" :href="dealer.settings.url()">Open settings</a>.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <form class="prose prose-sm dark:prose-invert max-w-none space-y-10" @submit.prevent="submit">
                <!-- Hidden source-of-truth fields auto-populated from store -->
                <input type="hidden" :value="form.qi_name">
                <input type="hidden" :value="form.standard_dpp_rate">

                <!-- Intro / Compliance Management System Program -->
                <div class="cms-policy" v-html="introHtml" />

                <!-- Adoption approval signatures -->
                <section class="not-prose grid gap-4 sm:grid-cols-3">
                    <NamedSignatureBlock
                        :name-value="form.adoption_approval_name_one"
                        :signature-value="form.adoption_approval_signature_one"
                        name-label="Board Member 1"
                        :name-error="form.errors.adoption_approval_name_one ?? null"
                        :signature-error="form.errors.adoption_approval_signature_one ?? null"
                        @update:name-value="form.adoption_approval_name_one = $event"
                        @update:signature-value="form.adoption_approval_signature_one = $event"
                    />
                    <NamedSignatureBlock
                        :name-value="form.adoption_approval_name_two"
                        :signature-value="form.adoption_approval_signature_two"
                        name-label="Board Member 2"
                        :name-error="form.errors.adoption_approval_name_two ?? null"
                        :signature-error="form.errors.adoption_approval_signature_two ?? null"
                        @update:name-value="form.adoption_approval_name_two = $event"
                        @update:signature-value="form.adoption_approval_signature_two = $event"
                    />
                    <NamedSignatureBlock
                        :name-value="form.adoption_approval_name_three"
                        :signature-value="form.adoption_approval_signature_three"
                        name-label="Board Member 3"
                        :name-error="form.errors.adoption_approval_name_three ?? null"
                        :signature-error="form.errors.adoption_approval_signature_three ?? null"
                        @update:name-value="form.adoption_approval_name_three = $event"
                        @update:signature-value="form.adoption_approval_signature_three = $event"
                    />
                </section>

                <!-- Dealer Participation Program intro -->
                <div class="cms-policy" v-html="dppHtml" />

                <!-- Dealer Participation signature -->
                <section class="not-prose">
                    <NamedSignatureBlock
                        :name-value="form.dealer_participation_name"
                        :signature-value="form.dealer_participation_signature"
                        name-label="Board Member"
                        :name-error="form.errors.dealer_participation_name ?? null"
                        :signature-error="form.errors.dealer_participation_signature ?? null"
                        class="max-w-md"
                        @update:name-value="form.dealer_participation_name = $event"
                        @update:signature-value="form.dealer_participation_signature = $event"
                    />
                </section>

                <!-- DPP Form example + Appointment + Acknowledgement intro -->
                <div class="cms-policy" v-html="formExampleHtml" />

                <!-- Acknowledgement signature (required) -->
                <section id="acknowledgement" class="not-prose">
                    <div class="rounded-lg border bg-card p-6 space-y-4">
                        <div>
                            <Label class="text-xs font-semibold uppercase tracking-wide text-muted-foreground">
                                Acknowledgement Name
                                <span class="text-destructive">*</span>
                            </Label>
                            <Input
                                v-model="form.acknowledgement_name"
                                placeholder="Type your name"
                                :class="form.errors.acknowledgement_name ? 'border-destructive' : ''"
                            />
                            <p v-if="form.errors.acknowledgement_name" class="mt-1 text-xs text-destructive">
                                {{ form.errors.acknowledgement_name }}
                            </p>
                        </div>
                        <SignaturePad
                            v-model="form.acknowledgement_signature"
                            :error="form.errors.acknowledgement_signature ?? null"
                        />
                        <Button type="submit" :disabled="!canSubmit">
                            <Loader2 v-if="form.processing" class="animate-spin" />
                            Submit Manual
                        </Button>
                    </div>
                </section>
            </form>
        </div>
    </AppLayout>
</template>

<style scoped>
.cms-policy :deep(h2) {
    color: var(--primary);
    font-size: 1.25rem;
    font-weight: 700;
    margin-top: 1.5rem;
    margin-bottom: 0.75rem;
}
.cms-policy :deep(h3) {
    color: var(--foreground);
    font-size: 1rem;
    font-weight: 600;
    margin-top: 1.25rem;
    margin-bottom: 0.5rem;
}
.cms-policy :deep(p) {
    line-height: 1.6;
    margin-bottom: 0.75rem;
}
.cms-policy :deep(ul) {
    list-style-type: disc;
    list-style-position: outside;
    padding-left: 1.5rem;
    margin-bottom: 0.75rem;
}
.cms-policy :deep(li) {
    margin-bottom: 0.25rem;
}
.cms-policy :deep(.dpp-example) {
    background-color: var(--card);
}
.cms-policy :deep(.dpp-example-watermark) {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) rotate(-30deg);
    transform-origin: center center;
    pointer-events: none;
    z-index: 0;
    font-size: 6rem;
    font-weight: 800;
    color: rgb(0 0 0 / 0.06);
    letter-spacing: 0.1em;
    white-space: nowrap;
}
.cms-policy :deep(.dpp-example > *:not(.dpp-example-watermark)) {
    position: relative;
    z-index: 1;
}
</style>
