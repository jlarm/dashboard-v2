<script setup lang="ts">
import { computed, onBeforeUnmount, onMounted, ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import { Loader2 } from 'lucide-vue-next';
import AppLayout from '@/layouts/tenant/AppLayout.vue';
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import SignaturePad from '@/components/manuals/SignaturePad.vue';
import osha from '@/routes/dealer/manual/osha';
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
    { title: 'OSHA Manuals', href: osha.index.url() },
    { title: 'Sign Manual', href: osha.create.url() },
];

const sections = [
    { id: 'eap', label: 'Emergency Action Plan' },
    { id: 'hcp', label: 'Hazard Communication Program' },
    { id: 'hazwoper', label: 'HAZWOPER' },
    { id: 'lt', label: 'Lockout Tagout' },
    { id: 'esp', label: 'Electrical Safety Plan' },
    { id: 'swpp', label: 'Storm Water Pollution Plan' },
    { id: 'uomp', label: 'Used Oil Management Plan' },
    { id: 'rpp', label: 'Respiratory Protection Plan' },
    { id: 'bpp', label: 'Bloodborne Pathogens Plan' },
    { id: 'ppe', label: 'Personal Protection Plan – PPE' },
    { id: 'cgp', label: 'Compressed Gas Plan' },
    { id: 'wcp', label: 'Welding & Cutting Procedures' },
    { id: 'fpp', label: 'Fire Prevention Plan' },
    { id: 'mesg', label: 'Machine Equipment Safety/Guarding' },
    { id: 'heat', label: 'Heat Illness and Prevention Program' },
    { id: 'form', label: 'Signature' },
];

const activeId = ref<string | null>(null);
const contentRef = ref<HTMLElement | null>(null);
let observer: IntersectionObserver | null = null;

onMounted(() => {
    const isDesktop = window.matchMedia('(min-width: 1024px)').matches;
    const root = isDesktop ? contentRef.value : null;

    observer = new IntersectionObserver(
        (entries) => {
            const visible = entries
                .filter((entry) => entry.isIntersecting)
                .sort((a, b) => b.intersectionRatio - a.intersectionRatio)[0];
            if (visible) {
                activeId.value = visible.target.id;
            }
        },
        {
            root,
            rootMargin: '-30% 0px -55% 0px',
            threshold: [0, 0.25, 0.5, 1],
        },
    );

    sections.forEach((section) => {
        const element = document.getElementById(section.id);
        if (element) {
            observer?.observe(element);
        }
    });
});

onBeforeUnmount(() => {
    observer?.disconnect();
    observer = null;
});

const scrollToSection = (event: MouseEvent, id: string): void => {
    event.preventDefault();
    const target = document.getElementById(id);
    if (!target) {
        return;
    }
    const container = contentRef.value;
    if (container && window.matchMedia('(min-width: 1024px)').matches) {
        container.scrollTo({
            top: target.offsetTop - container.offsetTop - 12,
            behavior: 'smooth',
        });
    } else {
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
    activeId.value = id;
};

const form = useForm({
    signature: null as string | null,
});

const canSubmit = computed(() => form.signature !== null && !form.processing);

const submit = (): void => {
    form.post(osha.store.url(), {
        preserveScroll: true,
        onError: () => {
            scrollToSection(new MouseEvent('click'), 'form');
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
    <Head title="Sign OSHA Manual" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-5">
            <Heading
                title="OSHA Safety Manual"
                :description="`Review the policy below, then sign at the bottom for ${storeName}.`"
            />

            <div
                class="relative grid gap-8 lg:grid-cols-[16rem_minmax(0,1fr)] lg:h-[calc(100vh-12rem)] lg:overflow-hidden"
            >
                <aside class="hidden lg:block lg:overflow-y-auto pr-4">
                    <nav>
                        <ul class="space-y-2 text-sm">
                            <li v-for="section in sections" :key="section.id">
                                <a
                                    :href="`#${section.id}`"
                                    class="block transition-colors hover:text-foreground"
                                    :class="activeId === section.id ? 'font-semibold text-primary' : 'text-muted-foreground'"
                                    @click="scrollToSection($event, section.id)"
                                >
                                    {{ section.label }}
                                </a>
                            </li>
                        </ul>
                    </nav>
                </aside>

                <div
                    ref="contentRef"
                    class="prose prose-sm dark:prose-invert min-w-0 max-w-none space-y-10 lg:overflow-y-auto lg:pr-4"
                >
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
                    <div class="osha-policy" v-html="policyHtml" />

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
        </div>
    </AppLayout>
</template>

<style scoped>
.osha-policy :deep(article) {
    margin-top: 2.5rem;
    margin-bottom: 2.5rem;
}
.osha-policy :deep(h1) {
    color: var(--primary);
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
}
.osha-policy :deep(h2) {
    color: var(--primary);
    font-size: 1.125rem;
    font-weight: 600;
    margin-top: 1.25rem;
    margin-bottom: 0.5rem;
}
.osha-policy :deep(h4) {
    color: var(--primary);
    font-weight: 600;
}
.osha-policy :deep(.text-arm-blue-600),
.osha-policy :deep(.text-arm-blue-500) {
    color: var(--primary);
}
.osha-policy :deep(p) {
    line-height: 1.6;
    margin-bottom: 0.75rem;
}
.osha-policy :deep(ul),
.osha-policy :deep(ol) {
    list-style-position: outside;
    padding-left: 1.5rem;
    margin-bottom: 0.75rem;
}
.osha-policy :deep(ul) {
    list-style-type: disc;
}
.osha-policy :deep(ol) {
    list-style-type: decimal;
}
.osha-policy :deep(li) {
    margin-bottom: 0.25rem;
}
.osha-policy :deep(a) {
    color: var(--primary);
    text-decoration: underline;
}
</style>
