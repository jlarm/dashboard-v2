<script setup lang="ts">
import { computed, reactive, ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { CheckCircle2, FileDown, FileText, Minus, Plus, Sparkles } from 'lucide-vue-next';
import AppLayout from '@/layouts/tenant/AppLayout.vue';
import {
    Accordion,
    AccordionContent,
    AccordionItem,
    AccordionTrigger,
} from '@/components/ui/accordion';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import {
    Field,
    FieldLabel,
} from '@/components/ui/field';
import { FileUpload } from '@/components/ui/file-upload';
import { Switch } from '@/components/ui/switch';
import { Textarea } from '@/components/ui/textarea';
import { useAuditRoutes, useGenerateRemediationRoute } from '@/composables/useAuditRoutes';
import type { BreadcrumbItem } from '@/types';
import type { AuditTypeSlug } from '@/components/audits/audit-types';

type Remediation = {
    id: number;
    comment: string;
    completed: boolean;
    user_name: string | null;
    photo_url: string | null;
    updated_at: string | null;
};
type Violation = {
    id: number;
    uuid: string;
    statement: string;
    comment: string;
    remediation: Remediation | null;
};
type AuditDetail = {
    id: number;
    uuid: string;
    date: string;
    has_remediation_pdf: boolean;
    violations: Violation[];
};

const props = defineProps<{
    type: AuditTypeSlug;
    label: string;
    audit: AuditDetail;
}>();

const routes = useAuditRoutes(props.type);
const generateRemediationRoute = useGenerateRemediationRoute(props.type);

const breadcrumbs: BreadcrumbItem[] = [
    { title: `${props.label} Audits`, href: routes.index.url() },
    { title: 'Remediation', href: routes.remediation.url({ audit: props.audit.uuid }) },
];

type RemediationDraft = {
    comment: string;
    completed: boolean;
    photo: File | null;
    remove_photo: boolean;
    existing_photo_url: string | null;
    upload_key: number;
};

const drafts = reactive<Record<number, RemediationDraft>>(
    Object.fromEntries(
        props.audit.violations.map((v) => [
            v.id,
            {
                comment: v.remediation?.comment ?? '',
                completed: v.remediation?.completed ?? false,
                photo: null,
                remove_photo: false,
                existing_photo_url: v.remediation?.photo_url ?? null,
                upload_key: 0,
            },
        ]),
    ),
);

const submitting = ref(false);
const generating = ref(false);
const openItem = ref<string>('');

const completedCount = computed(() => Object.values(drafts).filter((d) => d.completed).length);
const totalCount = computed(() => props.audit.violations.length);
const progress = computed(() =>
    totalCount.value === 0 ? 0 : Math.round((completedCount.value / totalCount.value) * 100),
);

const formatLastEdited = (iso: string | null | undefined): string => {
    if (!iso) return '';
    try {
        const formatted = new Date(iso).toLocaleDateString('en-US', {
            month: '2-digit',
            day: '2-digit',
            year: 'numeric',
        });
        return formatted;
    } catch {
        return '';
    }
};

const removeExistingPhoto = (violationId: number): void => {
    drafts[violationId].remove_photo = true;
    drafts[violationId].existing_photo_url = null;
    drafts[violationId].upload_key++;
};

const submit = (): void => {
    submitting.value = true;
    const data: Record<string, unknown> = {};
    Object.entries(drafts).forEach(([violationId, draft]) => {
        data[`remediations[${violationId}][comment]`] = draft.comment;
        data[`remediations[${violationId}][completed]`] = draft.completed ? 1 : 0;
        data[`remediations[${violationId}][remove_photo]`] = draft.remove_photo ? 1 : 0;
        if (draft.photo) {
            data[`remediations[${violationId}][photo]`] = draft.photo;
        }
    });

    router.post(
        routes.remediation.update.url({ audit: props.audit.uuid }),
        data as never,
        {
            forceFormData: true,
            headers: { 'X-HTTP-Method-Override': 'PATCH' },
            preserveScroll: true,
            onSuccess: () => {
                Object.values(drafts).forEach((draft) => {
                    draft.photo = null;
                    draft.remove_photo = false;
                    draft.upload_key++;
                });
            },
            onFinish: () => {
                submitting.value = false;
            },
        },
    );
};

const generateRemediationPdf = (): void => {
    generating.value = true;
    router.post(
        generateRemediationRoute.url({ audit: props.audit.uuid }),
        {},
        {
            preserveScroll: true,
            onFinish: () => {
                generating.value = false;
            },
        },
    );
};
</script>

<template>
    <Head :title="`${label} remediation`" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <template #actions>
            <Link :href="routes.index.url()">
                <Button variant="ghost" size="sm">
                    <span class="hidden sm:inline">Audits</span>
                </Button>
            </Link>
            <Button
                type="button"
                variant="outline"
                size="sm"
                :disabled="generating"
                @click="generateRemediationPdf"
            >
                <Sparkles class="size-4" />
                <span class="hidden sm:inline">{{ generating ? 'Generating…' : 'Generate report' }}</span>
            </Button>
            <a v-if="audit.has_remediation_pdf" :href="routes.remediation.download.url({ audit: audit.uuid })">
                <Button variant="outline" size="sm">
                    <FileDown class="size-4" />
                    <span class="hidden sm:inline">PDF</span>
                </Button>
            </a>
        </template>

        <form class="mx-auto flex max-w-2xl flex-col gap-4 px-3 pb-8 pt-4 sm:px-6" @submit.prevent="submit">
            <!-- Progress summary -->
            <div class="rounded-lg border bg-card p-4">
                <div class="flex items-center justify-between gap-3">
                    <div class="space-y-1">
                        <p class="text-xs uppercase tracking-wider text-muted-foreground">Remediation progress</p>
                        <p class="text-2xl font-semibold">
                            {{ completedCount }}<span class="text-base font-normal text-muted-foreground"> / {{ totalCount }}</span>
                        </p>
                    </div>
                    <Badge
                        :class="progress === 100
                            ? 'bg-emerald-100 text-emerald-700 ring-emerald-200 dark:bg-emerald-900/40 dark:text-emerald-300 dark:ring-emerald-900/60'
                            : 'bg-muted text-muted-foreground ring-border'"
                        class="rounded-full px-3 py-1 text-sm ring-1"
                    >
                        {{ progress }}%
                    </Badge>
                </div>
                <div class="mt-3 h-2 overflow-hidden rounded-full bg-muted">
                    <div
                        class="h-full rounded-full bg-emerald-500 transition-all"
                        :style="{ width: `${progress}%` }"
                    />
                </div>
            </div>

            <!-- Empty state -->
            <div
                v-if="!audit.violations.length"
                class="rounded-lg border bg-card p-10 text-center"
            >
                <CheckCircle2 class="mx-auto mb-3 size-8 text-muted-foreground" />
                <p class="text-sm font-medium">No violations to remediate</p>
                <p class="mt-1 text-xs text-muted-foreground">This audit has no recorded violations.</p>
            </div>

            <!-- Remediation accordion -->
            <Accordion
                v-else
                v-model="openItem"
                type="single"
                collapsible
                class="flex flex-col gap-3 rounded-none border-0"
            >
                <AccordionItem
                    v-for="violation in audit.violations"
                    :key="violation.id"
                    :value="`r-${violation.id}`"
                    class="overflow-hidden rounded-lg border border-border bg-card data-[state=open]:bg-card data-[state=open]:shadow-sm"
                >
                    <AccordionTrigger class="px-4 py-4 text-left text-sm font-semibold leading-snug hover:no-underline">
                        <span class="flex items-start gap-2">
                            <CheckCircle2
                                v-if="drafts[violation.id].completed"
                                class="mt-0.5 size-4 shrink-0 text-emerald-500"
                                aria-label="Completed"
                            />
                            <span>{{ violation.statement }}</span>
                        </span>
                        <template #icon>
                            <Plus class="size-4 shrink-0 text-muted-foreground group-aria-expanded/accordion-trigger:hidden" />
                            <Minus class="size-4 shrink-0 text-muted-foreground hidden group-aria-expanded/accordion-trigger:inline" />
                        </template>
                    </AccordionTrigger>
                    <AccordionContent class="space-y-5 px-4 pb-5 pt-1">
                        <p
                            v-if="violation.remediation?.updated_at"
                            class="text-xs text-muted-foreground"
                        >
                            Last edited: {{ formatLastEdited(violation.remediation.updated_at) }}<template v-if="violation.remediation.user_name"> by {{ violation.remediation.user_name }}</template>
                        </p>

                        <div v-if="violation.comment" class="rounded-md border bg-muted/30 px-3 py-2.5">
                            <div class="flex items-start gap-2">
                                <FileText class="mt-0.5 size-4 shrink-0 text-muted-foreground" />
                                <div class="space-y-0.5">
                                    <p class="text-xs uppercase tracking-wider text-muted-foreground">Original violation note</p>
                                    <p class="text-sm">{{ violation.comment }}</p>
                                </div>
                            </div>
                        </div>

                        <Field>
                            <FieldLabel
                                :for="`remediation-comment-${violation.id}`"
                                class="text-xs uppercase tracking-wider text-muted-foreground"
                            >
                                Remediation notes
                            </FieldLabel>
                            <Textarea
                                :id="`remediation-comment-${violation.id}`"
                                v-model="drafts[violation.id].comment"
                                rows="3"
                                class="resize-none text-base"
                                placeholder="What was done to remediate this violation…"
                            />
                        </Field>

                        <Field
                            orientation="horizontal"
                            class="rounded-lg border px-3 py-3 transition-colors"
                            :class="drafts[violation.id].completed
                                ? 'border-emerald-300 bg-emerald-50 dark:border-emerald-900/60 dark:bg-emerald-950/30'
                                : 'border-border bg-muted/30'"
                        >
                            <span
                                class="grid size-9 shrink-0 place-items-center rounded-md ring-1 transition-colors"
                                :class="drafts[violation.id].completed
                                    ? 'bg-emerald-100 text-emerald-600 ring-emerald-200 dark:bg-emerald-900/40 dark:text-emerald-300 dark:ring-emerald-900/60'
                                    : 'bg-background text-muted-foreground ring-border'"
                            >
                                <CheckCircle2 class="size-4" />
                            </span>
                            <FieldLabel
                                :for="`remediation-done-${violation.id}`"
                                class="flex-1 text-sm font-medium transition-colors"
                                :class="drafts[violation.id].completed ? 'text-emerald-700 dark:text-emerald-300' : ''"
                            >
                                Mark as completed
                            </FieldLabel>
                            <Switch
                                v-model="drafts[violation.id].completed"
                                :id="`remediation-done-${violation.id}`"
                                class="data-[state=checked]:bg-emerald-600 dark:data-[state=checked]:bg-emerald-500"
                            />
                        </Field>

                        <Field>
                            <FieldLabel class="text-xs uppercase tracking-wider text-muted-foreground">
                                Photo
                            </FieldLabel>
                            <div
                                v-if="drafts[violation.id].existing_photo_url"
                                class="flex items-center gap-3 rounded-lg border bg-muted/30 p-3"
                            >
                                <img
                                    :src="drafts[violation.id].existing_photo_url!"
                                    class="size-20 rounded-md object-cover ring-1 ring-border"
                                    alt=""
                                />
                                <div class="flex-1 text-xs text-muted-foreground">Photo attached.</div>
                                <Button
                                    type="button"
                                    variant="ghost"
                                    size="sm"
                                    class="text-destructive hover:text-destructive"
                                    @click="removeExistingPhoto(violation.id)"
                                >
                                    Remove
                                </Button>
                            </div>
                            <FileUpload
                                v-if="!drafts[violation.id].existing_photo_url"
                                :key="drafts[violation.id].upload_key"
                                accept="image/*,.heic,.heif"
                                label="Drop a photo here, or"
                                hint="JPG, PNG, WEBP, HEIC — up to 10 MB"
                                @update:file="drafts[violation.id].photo = $event"
                            />
                        </Field>
                    </AccordionContent>
                </AccordionItem>
            </Accordion>

            <div class="mt-2 flex items-center justify-between gap-3">
                <p class="text-xs text-muted-foreground">
                    {{ completedCount }} / {{ totalCount }} remediated
                </p>
                <div class="flex items-center gap-2">
                    <Link :href="routes.index.url()">
                        <Button type="button" variant="outline" class="h-11">Exit</Button>
                    </Link>
                    <Button type="button" :disabled="submitting" class="h-11 px-6" @click="submit">
                        {{ submitting ? 'Saving…' : 'Update' }}
                    </Button>
                </div>
            </div>
        </form>
    </AppLayout>
</template>
