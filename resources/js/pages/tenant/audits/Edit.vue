<script setup lang="ts">
import { computed, onBeforeUnmount, onMounted, reactive, ref, watch } from 'vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { AlertCircle, AlertTriangle, Check, ImagePlus, Loader2, MessageSquarePlus, Minus, Pencil, Plus, Search, Trash2, X } from 'lucide-vue-next';
import AppLayout from '@/layouts/tenant/AppLayout.vue';
import {
    Accordion,
    AccordionContent,
    AccordionItem,
    AccordionTrigger,
} from '@/components/ui/accordion';
import { Button } from '@/components/ui/button';
import DatePicker from '@/components/DatePicker.vue';
import { FileUpload } from '@/components/ui/file-upload';
import {
    Field,
    FieldDescription,
    FieldLabel,
} from '@/components/ui/field';
import { Input } from '@/components/ui/input';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import {
    Sheet,
    SheetContent,
    SheetDescription,
    SheetFooter,
    SheetHeader,
    SheetTitle,
} from '@/components/ui/sheet';
import { Switch } from '@/components/ui/switch';
import { Textarea } from '@/components/ui/textarea';
import { useAuditRoutes } from '@/composables/useAuditRoutes';
import type { BreadcrumbItem } from '@/types';
import type { AuditTypeSlug } from '@/components/audits/audit-types';

type Photo = { id: number; position: number; url: string };
type Violation = {
    id: number;
    uuid: string;
    statement_id: number | null;
    statement: string;
    comment: string;
    violation_date: string | null;
    risk: boolean;
    severity: number | null;
    show_reference_image: boolean;
    reference_image_url: string | null;
    photos: Photo[];
};
type AuditComment = {
    id: number;
    user_id: number;
    user_name: string;
    comment: string;
    created_at: string;
    photo_url: string | null;
};
type AuditDetail = {
    id: number;
    uuid: string;
    date: string;
    violations: Violation[];
    comments: AuditComment[];
};

type PreviousAuditIssue = {
    statement: string;
    severity: number | null;
    risk: boolean;
    remediation_resolved: boolean;
};
type PreviousAudit = {
    uuid: string;
    date: string;
    grade: string | null;
    violation_count: number;
    open_remediation_count: number;
    issues: PreviousAuditIssue[];
};

const props = defineProps<{
    type: AuditTypeSlug;
    label: string;
    audit: AuditDetail;
    previous_audit: PreviousAudit | null;
}>();

const routes = useAuditRoutes(props.type);

const breadcrumbs: BreadcrumbItem[] = [
    { title: `${props.label} Audits`, href: routes.index.url() },
    { title: 'Edit', href: routes.edit.url({ audit: props.audit.uuid }) },
];

type EditableViolation = Violation & { newPhotos: File[] };

const violations = reactive<EditableViolation[]>(
    props.audit.violations.map((v) => ({ ...v, newPhotos: [] as File[] })),
);
const date = ref(props.audit.date);
const openItem = ref<string>('');

type SaveState = 'idle' | 'saving' | 'saved' | 'error';
const saveState = ref<SaveState>('idle');
let saveTimer: ReturnType<typeof setTimeout> | null = null;

const saveLabel = computed<string>(() => {
    switch (saveState.value) {
        case 'saving':
            return 'Saving…';
        case 'saved':
            return 'All changes saved';
        case 'error':
            return 'Couldn’t save changes';
        default:
            return '';
    }
});

const priorOpen = ref(false);

onMounted(() => {
    // A freshly created audit has no violations yet — surface the previous
    // audit's issues automatically as a starting briefing.
    if (props.previous_audit && props.audit.violations.length === 0) {
        priorOpen.value = true;
    }
});

watch(
    () => props.audit.violations,
    (incoming) => {
        const incomingIds = new Set(incoming.map((v) => v.id));

        for (let index = violations.length - 1; index >= 0; index--) {
            if (!incomingIds.has(violations[index].id)) {
                violations.splice(index, 1);
            }
        }

        const existingIds = new Set(violations.map((v) => v.id));
        let newlyAddedId: number | null = null;
        for (const fresh of incoming) {
            if (!existingIds.has(fresh.id)) {
                violations.push({ ...fresh, newPhotos: [] });
                newlyAddedId = fresh.id;
                continue;
            }
            const local = violations.find((v) => v.id === fresh.id);
            if (local) {
                local.photos = fresh.photos;
                local.statement = fresh.statement;
                local.statement_id = fresh.statement_id;
                local.reference_image_url = fresh.reference_image_url;
            }
        }

        if (newlyAddedId !== null) {
            openItem.value = `v-${newlyAddedId}`;
        }
    },
);

const violationCount = computed(() => violations.length);

const page = usePage<{ auth: { user: { id: number; name: string } } }>();
const currentUserId = computed(() => page.props.auth?.user?.id ?? 0);

const newCommentBody = ref('');
const newCommentPhoto = ref<File | null>(null);
const newCommentUploadKey = ref(0);
const submittingComment = ref(false);

const editingCommentId = ref<number | null>(null);
const editingCommentBody = ref('');
const editingCommentPhoto = ref<File | null>(null);
const editingUploadKey = ref(0);
const editingRemovePhoto = ref(false);

const submitNewComment = (): void => {
    if (newCommentBody.value.trim() === '') return;
    submittingComment.value = true;
    const data: Record<string, unknown> = { comment: newCommentBody.value };
    if (newCommentPhoto.value) data.photo = newCommentPhoto.value;
    router.post(routes.comments.store.url({ audit: props.audit.uuid }), data as never, {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            newCommentBody.value = '';
            newCommentPhoto.value = null;
            newCommentUploadKey.value++;
        },
        onFinish: () => {
            submittingComment.value = false;
        },
    });
};

const startEditComment = (comment: AuditComment): void => {
    editingCommentId.value = comment.id;
    editingCommentBody.value = comment.comment;
    editingCommentPhoto.value = null;
    editingRemovePhoto.value = false;
    editingUploadKey.value++;
};

const cancelEditComment = (): void => {
    editingCommentId.value = null;
    editingCommentBody.value = '';
    editingCommentPhoto.value = null;
    editingRemovePhoto.value = false;
};

const submitEditComment = (comment: AuditComment): void => {
    if (editingCommentBody.value.trim() === '') return;
    const data: Record<string, unknown> = { comment: editingCommentBody.value };
    if (editingCommentPhoto.value) data.photo = editingCommentPhoto.value;
    if (editingRemovePhoto.value) data.remove_photo = 1;
    router.post(
        routes.comments.update.url({ audit: props.audit.uuid, comment: comment.id }),
        data as never,
        {
            forceFormData: true,
            headers: { 'X-HTTP-Method-Override': 'PATCH' },
            preserveScroll: true,
            onSuccess: () => cancelEditComment(),
        },
    );
};

const removeComment = (comment: AuditComment): void => {
    if (!confirm('Delete this comment?')) return;
    router.delete(
        routes.comments.destroy.url({ audit: props.audit.uuid, comment: comment.id }),
        { preserveScroll: true },
    );
};

const initials = (name: string): string => name
    .split(/\s+/)
    .filter(Boolean)
    .slice(0, 2)
    .map((part) => part[0]?.toUpperCase() ?? '')
    .join('') || '?';

const formatDate = (iso: string): string => {
    if (!iso) return '';
    try {
        return new Date(iso).toLocaleDateString(undefined, { month: 'short', day: 'numeric', year: 'numeric' });
    } catch {
        return '';
    }
};

const severityScale = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10] as const;

const severityClasses = (value: number): string => {
    if (value <= 3) {
        return 'border-yellow-500 bg-yellow-500 text-white shadow-sm';
    }
    if (value <= 7) {
        return 'border-orange-500 bg-orange-500 text-white shadow-sm';
    }
    return 'border-red-600 bg-red-600 text-white shadow-sm';
};

const fileInputRefs = ref<Record<number, HTMLInputElement | null>>({});

const setFileInputRef = (violationId: number) => (el: HTMLInputElement | object | null): void => {
    fileInputRefs.value[violationId] = el as HTMLInputElement | null;
};

const triggerFilePicker = (violationId: number): void => {
    fileInputRefs.value[violationId]?.click();
};

const isHeic = (file: File): boolean =>
    /\.heic|\.heif$/i.test(file.name) || file.type === 'image/heic' || file.type === 'image/heif';

async function convertHeicToJpeg(file: File): Promise<File> {
    try {
        const heic2any = (await import('heic2any')).default;
        const blob = await heic2any({ blob: file, toType: 'image/jpeg', quality: 0.85 });
        const out = Array.isArray(blob) ? blob[0] : blob;
        return new File([out], file.name.replace(/\.heic|\.heif$/i, '.jpg'), { type: 'image/jpeg' });
    } catch {
        return file;
    }
}

async function downscale(file: File, maxLongEdge = 2000, quality = 0.82): Promise<File> {
    return new Promise((resolve) => {
        const img = new Image();
        img.onload = () => {
            const longEdge = Math.max(img.width, img.height);
            if (longEdge <= maxLongEdge) {
                resolve(file);
                return;
            }
            const scale = maxLongEdge / longEdge;
            const canvas = document.createElement('canvas');
            canvas.width = Math.round(img.width * scale);
            canvas.height = Math.round(img.height * scale);
            const ctx = canvas.getContext('2d');
            if (!ctx) {
                resolve(file);
                return;
            }
            ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
            canvas.toBlob(
                (blob) => {
                    if (!blob) {
                        resolve(file);
                        return;
                    }
                    resolve(new File([blob], file.name.replace(/\.(png|webp)$/i, '.jpg'), { type: 'image/jpeg' }));
                },
                'image/jpeg',
                quality,
            );
        };
        img.onerror = () => resolve(file);
        img.src = URL.createObjectURL(file);
    });
}

const onPickFiles = async (violation: EditableViolation, event: Event): Promise<void> => {
    const input = event.target as HTMLInputElement;
    if (!input.files) return;
    const slotsLeft = Math.max(0, 3 - violation.photos.length - violation.newPhotos.length);
    if (slotsLeft <= 0) {
        input.value = '';
        return;
    }
    const incoming = Array.from(input.files).slice(0, slotsLeft);
    const processed: File[] = [];
    for (const file of incoming) {
        const ready = isHeic(file) ? await convertHeicToJpeg(file) : file;
        processed.push(await downscale(ready));
    }
    violation.newPhotos.push(...processed);
    input.value = '';
    if (processed.length > 0) {
        scheduleSave();
    }
};

const removeNewPhoto = (violation: EditableViolation, index: number): void => {
    violation.newPhotos.splice(index, 1);
    scheduleSave();
};

const objectUrl = (file: File): string => URL.createObjectURL(file);

const removeExistingPhoto = (violation: Violation, photo: Photo): void => {
    if (!confirm('Remove this photo?')) return;
    router.delete(
        routes.violations.photos.destroy.url({
            audit: props.audit.uuid,
            violation: violation.id,
            photoId: photo.id,
        }),
        { preserveScroll: true },
    );
};

const buildPayload = (): Record<string, unknown> => {
    const data: Record<string, unknown> = { date: date.value };
    violations.forEach((violation, index) => {
        data[`violations[${index}][id]`] = violation.id;
        data[`violations[${index}][comment]`] = violation.comment;
        data[`violations[${index}][violation_date]`] = violation.violation_date ?? '';
        data[`violations[${index}][risk]`] = violation.risk ? 1 : 0;
        data[`violations[${index}][severity]`] = violation.severity ?? 0;
        data[`violations[${index}][show_reference_image]`] = violation.show_reference_image ? 1 : 0;
        violation.newPhotos.forEach((file, fileIndex) => {
            data[`violations[${index}][images][${fileIndex}]`] = file;
        });
    });
    return data;
};

const persist = (): void => {
    if (saveTimer) {
        clearTimeout(saveTimer);
        saveTimer = null;
    }
    saveState.value = 'saving';
    router.post(routes.update.url({ audit: props.audit.uuid }), buildPayload() as never, {
        forceFormData: true,
        headers: { 'X-HTTP-Method-Override': 'PATCH' },
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            // Photos are now persisted server-side; drop the local copies so a
            // later auto-save doesn't re-upload them.
            violations.forEach((violation) => {
                violation.newPhotos.splice(0);
            });
            saveState.value = 'saved';
        },
        onError: () => {
            saveState.value = 'error';
        },
    });
};

const scheduleSave = (): void => {
    saveState.value = 'saving';
    if (saveTimer) {
        clearTimeout(saveTimer);
    }
    saveTimer = setTimeout(persist, 600);
};

// Auto-save whenever a savable field changes. The getter rebuilds a snapshot
// on every tracked change; photo additions/removals call scheduleSave directly
// since File objects aren't tracked here.
watch(
    () => [
        date.value,
        violations.map((violation) => ({
            id: violation.id,
            comment: violation.comment,
            violation_date: violation.violation_date,
            risk: violation.risk,
            severity: violation.severity,
            show_reference_image: violation.show_reference_image,
        })),
    ],
    () => scheduleSave(),
);

onBeforeUnmount(() => {
    if (saveTimer) {
        clearTimeout(saveTimer);
        saveTimer = null;
    }
});

const exit = (): void => {
    // Flush any pending or in-flight save before leaving so trailing edits
    // aren't lost; only navigate once the save succeeds.
    if (saveTimer || saveState.value === 'saving') {
        if (saveTimer) {
            clearTimeout(saveTimer);
            saveTimer = null;
        }
        saveState.value = 'saving';
        router.post(routes.update.url({ audit: props.audit.uuid }), buildPayload() as never, {
            forceFormData: true,
            headers: { 'X-HTTP-Method-Override': 'PATCH' },
            onSuccess: () => router.visit(routes.index.url()),
            onError: () => {
                saveState.value = 'error';
            },
        });
        return;
    }
    router.visit(routes.index.url());
};

const removeViolation = (violation: Violation): void => {
    if (!confirm('Delete this violation?')) return;
    router.delete(routes.violations.destroy.url({ audit: props.audit.uuid, violation: violation.id }), {
        preserveScroll: true,
    });
};

const search = ref('');
const searchResults = ref<Array<{ id: number; statement: string; reference_image_url: string | null }>>([]);
const searchOpen = ref(false);
const searching = ref(false);

const runSearch = async (): Promise<void> => {
    if (search.value.length < 2) {
        searchResults.value = [];
        return;
    }
    searching.value = true;
    try {
        const response = await fetch(
            `${routes.violations.search.url({ audit: props.audit.uuid })}?q=${encodeURIComponent(search.value)}`,
            { headers: { Accept: 'application/json' } },
        );
        searchResults.value = await response.json();
    } finally {
        searching.value = false;
    }
};

const addViolation = (statementId: number): void => {
    router.post(
        routes.violations.store.url({ audit: props.audit.uuid }),
        { statement_id: statementId },
        {
            preserveScroll: true,
            onSuccess: () => {
                searchOpen.value = false;
                search.value = '';
                searchResults.value = [];
            },
        },
    );
};
</script>

<template>
    <Head :title="`Edit ${label} audit`" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <template #actions>
            <span
                v-if="saveState !== 'idle'"
                class="inline-flex shrink-0 items-center gap-1.5 whitespace-nowrap text-xs font-medium"
                :class="saveState === 'error' ? 'text-destructive' : 'text-muted-foreground'"
                aria-live="polite"
            >
                <Loader2 v-if="saveState === 'saving'" class="size-3.5 shrink-0 animate-spin" />
                <Check v-else-if="saveState === 'saved'" class="size-3.5 shrink-0 text-emerald-600" />
                <AlertCircle v-else class="size-3.5 shrink-0" />
                <span class="hidden sm:inline">{{ saveLabel }}</span>
            </span>
            <button
                v-if="previous_audit"
                type="button"
                aria-label="Issues from the last audit"
                class="inline-flex shrink-0 items-center gap-1.5 whitespace-nowrap rounded-full border border-amber-300 bg-amber-50 px-2.5 py-1.5 text-xs font-medium text-amber-800 transition hover:bg-amber-100 dark:border-amber-900/60 dark:bg-amber-950/40 dark:text-amber-300 dark:hover:bg-amber-950/70"
                @click="priorOpen = true"
            >
                <AlertTriangle class="size-3.5 shrink-0" />
                <span class="hidden sm:inline">Last audit</span>
                <span class="rounded-full bg-amber-200 px-1.5 py-0.5 text-[11px] font-semibold leading-none dark:bg-amber-900/70">
                    {{ previous_audit.violation_count }}
                </span>
            </button>
            <Button type="button" variant="outline" size="sm" @click="searchOpen = true">
                <Plus class="size-4" />
                <span class="hidden sm:inline">Add violation</span>
            </Button>
        </template>

        <form class="mx-auto flex max-w-2xl flex-col gap-4 px-3 pb-8 pt-4 sm:px-6" @submit.prevent>
            <Field>
                <FieldLabel for="audit-date" class="text-xs uppercase tracking-wider text-muted-foreground">
                    Audit date
                </FieldLabel>
                <DatePicker id="audit-date" v-model="date" placeholder="Select date" />
            </Field>

            <Accordion v-model="openItem" type="single" collapsible class="flex flex-col gap-3 rounded-none border-0">
                <AccordionItem
                    v-for="violation in violations"
                    :key="violation.id"
                    :value="`v-${violation.id}`"
                    class="overflow-hidden rounded-lg border border-border bg-card data-[state=open]:bg-card data-[state=open]:shadow-sm"
                >
                    <AccordionTrigger
                        class="px-3 py-3 text-left text-sm font-semibold leading-snug hover:no-underline"
                    >
                        <span class="flex items-start gap-2">
                            <span>{{ violation.statement }}</span>
                        </span>
                        <template #icon>
                            <Plus class="size-4 shrink-0 text-muted-foreground group-aria-expanded/accordion-trigger:hidden" />
                            <Minus class="size-4 shrink-0 text-muted-foreground hidden group-aria-expanded/accordion-trigger:inline" />
                        </template>
                    </AccordionTrigger>
                    <AccordionContent class="space-y-3 px-3 pb-3 pt-1">
                        <Field>
                            <FieldLabel :for="`comment-${violation.id}`" class="text-xs uppercase tracking-wider text-muted-foreground">
                                Comment
                            </FieldLabel>
                            <Textarea
                                :id="`comment-${violation.id}`"
                                v-model="violation.comment"
                                rows="4"
                                class="resize-none text-base"
                                placeholder="Describe the violation…"
                            />
                        </Field>

                        <Field>
                            <FieldLabel class="text-xs uppercase tracking-wider text-muted-foreground">
                                Impact severity
                            </FieldLabel>
                            <div class="grid grid-cols-10 gap-1.5">
                                <button
                                    v-for="value in severityScale"
                                    :key="value"
                                    type="button"
                                    class="flex h-11 items-center justify-center rounded-md border text-sm font-medium transition"
                                    :class="
                                        violation.severity === value
                                            ? severityClasses(value)
                                            : 'border-input bg-muted/40 text-muted-foreground hover:bg-muted'
                                    "
                                    @click="violation.severity = violation.severity === value ? null : value"
                                >
                                    {{ value }}
                                </button>
                            </div>
                            <FieldDescription class="flex justify-between pt-1 text-[10px] font-semibold uppercase tracking-wider">
                                <span>Negligible</span>
                                <span>Critical</span>
                            </FieldDescription>
                        </Field>

                        <Field
                            orientation="horizontal"
                            class="rounded-lg border px-3 py-3 transition-colors"
                            :class="violation.risk
                                ? 'border-red-300 bg-red-50 dark:border-red-900/60 dark:bg-red-950/30'
                                : 'border-border bg-muted/30'"
                        >
                            <span
                                class="grid size-9 shrink-0 place-items-center rounded-md ring-1 transition-colors"
                                :class="violation.risk
                                    ? 'bg-red-100 text-red-600 ring-red-200 dark:bg-red-900/40 dark:text-red-300 dark:ring-red-900/60'
                                    : 'bg-background text-muted-foreground ring-border'"
                            >
                                <AlertTriangle class="size-4" />
                            </span>
                            <FieldLabel
                                :for="`risk-${violation.id}`"
                                class="flex-1 text-sm font-medium transition-colors"
                                :class="violation.risk ? 'text-red-700 dark:text-red-300' : ''"
                            >
                                Flag as High Risk
                            </FieldLabel>
                            <Switch
                                v-model="violation.risk"
                                :id="`risk-${violation.id}`"
                                class="data-[state=checked]:bg-red-600 dark:data-[state=checked]:bg-red-500"
                            />
                        </Field>

                        <Field
                            v-if="violation.reference_image_url"
                            orientation="horizontal"
                            class="rounded-lg border bg-muted/30 px-3 py-3"
                        >
                            <FieldLabel :for="`refimg-${violation.id}`" class="flex-1 text-sm font-medium">
                                Include reference image in report
                            </FieldLabel>
                            <Switch
                                v-model="violation.show_reference_image"
                                :id="`refimg-${violation.id}`"
                            />
                        </Field>

                        <Field>
                            <FieldLabel class="text-xs uppercase tracking-wider text-muted-foreground">
                                Photos <span class="font-normal normal-case text-muted-foreground/70">({{ violation.photos.length + violation.newPhotos.length }}/3)</span>
                            </FieldLabel>
                            <div class="grid grid-cols-6 gap-3">
                                <div v-for="photo in violation.photos" :key="`existing-${photo.id}`" class="space-y-1.5">
                                    <div class="aspect-square overflow-hidden rounded-md ring-1 ring-border">
                                        <img :src="photo.url" class="size-full object-cover" alt="" />
                                    </div>
                                    <button
                                        type="button"
                                        class="text-xs text-muted-foreground hover:text-destructive"
                                        @click="removeExistingPhoto(violation, photo)"
                                    >
                                        Clear
                                    </button>
                                </div>
                                <div v-for="(file, fIndex) in violation.newPhotos" :key="`new-${fIndex}`" class="space-y-1.5">
                                    <div class="aspect-square overflow-hidden rounded-md ring-1 ring-border">
                                        <img :src="objectUrl(file)" class="size-full object-cover" alt="" />
                                    </div>
                                    <button
                                        type="button"
                                        class="text-xs text-muted-foreground hover:text-destructive"
                                        @click="removeNewPhoto(violation, fIndex)"
                                    >
                                        Clear
                                    </button>
                                </div>
                                <button
                                    v-if="violation.photos.length + violation.newPhotos.length < 3"
                                    type="button"
                                    class="flex aspect-square flex-col items-center justify-center gap-1 rounded-md border border-dashed text-muted-foreground hover:border-primary hover:bg-muted/40 hover:text-primary"
                                    @click="triggerFilePicker(violation.id)"
                                >
                                    <ImagePlus class="size-4" />
                                    <span class="text-[10px] leading-tight">Add photo</span>
                                </button>
                            </div>
                            <input
                                :ref="setFileInputRef(violation.id)"
                                type="file"
                                accept="image/*,.heic,.heif"
                                multiple
                                capture="environment"
                                class="hidden"
                                @change="onPickFiles(violation, $event)"
                            />
                        </Field>

                        <div class="flex justify-end pt-2">
                            <Button
                                type="button"
                                variant="destructive"
                                size="sm"
                                @click="removeViolation(violation)"
                            >
                                Delete violation
                            </Button>
                        </div>
                    </AccordionContent>
                </AccordionItem>
            </Accordion>

            <button
                type="button"
                class="flex items-center justify-center gap-2 rounded-lg border border-dashed px-4 py-4 text-sm font-medium text-muted-foreground transition hover:border-primary hover:bg-muted/40 hover:text-primary"
                @click="searchOpen = true"
            >
                <Search class="size-4" />
                Add violation
            </button>

            <!-- Comments -->
            <section class="mt-4 space-y-3">
                <div class="flex items-baseline gap-2">
                    <h2 class="text-lg font-semibold tracking-tight">Comments</h2>
                    <span class="text-sm text-muted-foreground">({{ audit.comments.length }})</span>
                </div>

                <div
                    v-for="comment in audit.comments"
                    :key="comment.id"
                    class="rounded-lg border bg-card p-3"
                >
                    <div class="flex items-start gap-3">
                        <span class="grid size-9 shrink-0 place-items-center rounded-full bg-primary/10 text-xs font-semibold text-primary">
                            {{ initials(comment.user_name) }}
                        </span>
                        <div class="min-w-0 flex-1">
                            <div class="flex flex-wrap items-baseline gap-x-2">
                                <p class="text-sm font-semibold">{{ comment.user_name }}</p>
                                <p class="text-xs text-muted-foreground">{{ formatDate(comment.created_at) }}</p>
                            </div>

                            <template v-if="editingCommentId !== comment.id">
                                <p class="mt-1 whitespace-pre-wrap text-sm">{{ comment.comment }}</p>
                                <div v-if="comment.photo_url" class="mt-2">
                                    <img :src="comment.photo_url" class="max-h-48 rounded-md object-cover ring-1 ring-border" alt="" />
                                </div>
                            </template>

                            <div v-else class="mt-2 space-y-2">
                                <Textarea v-model="editingCommentBody" rows="3" class="resize-none text-base" />
                                <div v-if="comment.photo_url && !editingRemovePhoto && !editingCommentPhoto" class="flex items-center gap-3">
                                    <img :src="comment.photo_url" class="size-16 rounded-md object-cover ring-1 ring-border" alt="" />
                                    <Button type="button" variant="ghost" size="sm" @click="editingRemovePhoto = true">Remove photo</Button>
                                </div>
                                <FileUpload
                                    v-if="!comment.photo_url || editingRemovePhoto"
                                    :key="editingUploadKey"
                                    accept="image/*,.heic,.heif"
                                    label="Drop a photo here, or"
                                    hint="JPG, PNG, WEBP, HEIC — up to 10 MB"
                                    @update:file="editingCommentPhoto = $event"
                                />
                                <div class="flex justify-end gap-2">
                                    <Button type="button" variant="outline" size="sm" @click="cancelEditComment">Cancel</Button>
                                    <Button
                                        type="button"
                                        size="sm"
                                        :disabled="editingCommentBody.trim() === ''"
                                        @click="submitEditComment(comment)"
                                    >
                                        Save
                                    </Button>
                                </div>
                            </div>
                        </div>

                        <div v-if="editingCommentId !== comment.id && comment.user_id === currentUserId" class="flex shrink-0 items-center gap-1">
                            <Button
                                type="button"
                                variant="ghost"
                                size="icon"
                                class="size-8 text-muted-foreground hover:text-foreground"
                                @click="startEditComment(comment)"
                            >
                                <Pencil class="size-4" />
                                <span class="sr-only">Edit comment</span>
                            </Button>
                            <Button
                                type="button"
                                variant="ghost"
                                size="icon"
                                class="size-8 text-destructive hover:text-destructive"
                                @click="removeComment(comment)"
                            >
                                <Trash2 class="size-4" />
                                <span class="sr-only">Delete comment</span>
                            </Button>
                        </div>
                    </div>
                </div>

                <!-- Add comment -->
                <div class="space-y-3 rounded-lg border bg-card p-3">
                    <Textarea
                        v-model="newCommentBody"
                        rows="2"
                        class="resize-none text-base"
                        placeholder="Add a comment…"
                    />
                    <FileUpload
                        :key="newCommentUploadKey"
                        accept="image/*,.heic,.heif"
                        label="Drop a photo here, or"
                        hint="JPG, PNG, WEBP, HEIC — up to 10 MB"
                        @update:file="newCommentPhoto = $event"
                    />
                    <div class="flex justify-end">
                        <Button
                            type="button"
                            size="sm"
                            :disabled="submittingComment || newCommentBody.trim() === ''"
                            @click="submitNewComment"
                        >
                            <MessageSquarePlus class="size-4" />
                            {{ submittingComment ? 'Posting…' : 'Post' }}
                        </Button>
                    </div>
                </div>
            </section>

            <div class="mt-2 flex items-center justify-between gap-3">
                <p class="text-xs text-muted-foreground">
                    {{ violationCount }} violation{{ violationCount === 1 ? '' : 's' }}
                </p>
                <div class="flex items-center gap-3">
                    <span
                        v-if="saveState !== 'idle'"
                        class="flex items-center gap-1.5 text-xs font-medium"
                        :class="saveState === 'error' ? 'text-destructive' : 'text-muted-foreground'"
                        aria-live="polite"
                    >
                        <Loader2 v-if="saveState === 'saving'" class="size-3.5 animate-spin" />
                        <Check v-else-if="saveState === 'saved'" class="size-3.5 text-emerald-600" />
                        <AlertCircle v-else class="size-3.5" />
                        {{ saveLabel }}
                    </span>
                    <Button type="button" variant="outline" size="sm" @click="exit">
                        Done
                    </Button>
                </div>
            </div>
        </form>

        <!-- Add-violation dialog -->
        <Dialog v-model:open="searchOpen">
            <DialogContent class="flex max-h-[85vh] flex-col gap-4 sm:max-w-lg">
                <DialogHeader>
                    <DialogTitle>Find a violation statement</DialogTitle>
                    <DialogDescription>Search the {{ label }} statement library.</DialogDescription>
                </DialogHeader>
                <div class="relative">
                    <Search class="absolute left-3 top-1/2 size-4 -translate-y-1/2 text-muted-foreground" />
                    <Input
                        v-model="search"
                        placeholder="Search statements…"
                        class="h-12 pl-9 text-base"
                        autofocus
                        @input="runSearch"
                    />
                </div>
                <div class="-mx-2 flex-1 space-y-1.5 overflow-y-auto px-2">
                    <p v-if="searching" class="px-2 py-3 text-sm text-muted-foreground">Searching…</p>
                    <p
                        v-else-if="search.length >= 2 && !searchResults.length"
                        class="px-2 py-3 text-sm text-muted-foreground"
                    >
                        No matches.
                    </p>
                    <p
                        v-else-if="search.length < 2"
                        class="px-2 py-3 text-sm text-muted-foreground"
                    >
                        Type at least 2 characters.
                    </p>
                    <button
                        v-for="result in searchResults"
                        :key="result.id"
                        type="button"
                        class="w-full rounded-md border bg-card p-3 text-left text-sm leading-snug shadow-sm transition hover:bg-muted"
                        @click="addViolation(result.id)"
                    >
                        {{ result.statement }}
                    </button>
                </div>
            </DialogContent>
        </Dialog>

        <!-- Previous-audit briefing -->
        <Sheet v-if="previous_audit" v-model:open="priorOpen">
            <SheetContent side="bottom" class="max-h-[85vh] gap-0 p-0">
                <SheetHeader class="border-b px-4 py-3 pr-10 text-left">
                    <SheetTitle class="text-base">
                        Issues from the last {{ label }} audit
                    </SheetTitle>
                    <SheetDescription class="text-xs">
                        {{ formatDate(previous_audit.date) }}
                        · {{ previous_audit.violation_count }} violation{{ previous_audit.violation_count === 1 ? '' : 's' }}
                        <template v-if="previous_audit.grade"> · Grade {{ previous_audit.grade }}</template>
                        <template v-if="previous_audit.open_remediation_count > 0">
                            · {{ previous_audit.open_remediation_count }} unresolved
                        </template>
                    </SheetDescription>
                </SheetHeader>

                <div class="flex-1 divide-y overflow-y-auto overscroll-contain">
                    <div
                        v-for="(issue, index) in previous_audit.issues"
                        :key="index"
                        class="px-4 py-3"
                    >
                        <div class="flex flex-wrap items-center gap-1.5">
                            <span
                                v-if="issue.risk"
                                class="inline-flex items-center gap-1 rounded-full bg-red-100 px-2 py-0.5 text-[11px] font-semibold uppercase tracking-wide text-red-700 dark:bg-red-950/50 dark:text-red-300"
                            >
                                <AlertTriangle class="size-3" />
                                High risk
                            </span>
                            <span
                                v-if="issue.severity"
                                class="rounded-full bg-muted px-2 py-0.5 text-[11px] font-semibold text-muted-foreground"
                            >
                                Severity {{ issue.severity }}
                            </span>
                            <span
                                v-if="!issue.remediation_resolved"
                                class="inline-flex items-center gap-1 text-[11px] font-semibold text-red-600 dark:text-red-400"
                            >
                                <span class="size-1.5 rounded-full bg-red-500" />
                                Remediation still open
                            </span>
                            <span
                                v-else
                                class="text-[11px] font-semibold text-emerald-600 dark:text-emerald-400"
                            >
                                ✓ Resolved last cycle
                            </span>
                        </div>
                        <p class="mt-1.5 text-sm leading-snug">{{ issue.statement }}</p>
                    </div>
                    <p
                        v-if="!previous_audit.issues.length"
                        class="px-4 py-6 text-center text-sm text-muted-foreground"
                    >
                        The last audit had no recorded violations.
                    </p>
                </div>

                <SheetFooter class="border-t px-4 py-3">
                    <Link :href="routes.show.url({ audit: previous_audit.uuid })" class="w-full">
                        <Button type="button" variant="outline" size="sm" class="w-full">
                            View full last audit
                        </Button>
                    </Link>
                </SheetFooter>
            </SheetContent>
        </Sheet>
    </AppLayout>
</template>
