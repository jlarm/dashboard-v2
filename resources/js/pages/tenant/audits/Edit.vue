<script setup lang="ts">
import { reactive, ref } from 'vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import { ArrowLeft, Trash2, Search } from 'lucide-vue-next';
import AppLayout from '@/layouts/tenant/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { Checkbox } from '@/components/ui/checkbox';
import {
    Dialog,
    DialogContent,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';
import ImageUploadField from './components/ImageUploadField.vue';
import osha from '@/routes/dealer/audit/osha';
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
type AuditDetail = {
    id: number;
    uuid: string;
    date: string;
    violations: Violation[];
};

const props = defineProps<{
    type: AuditTypeSlug;
    label: string;
    audit: AuditDetail;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: `${props.label} Audits`, href: osha.index.url() },
    { title: 'Edit', href: osha.edit.url({ audit: props.audit.uuid }) },
];

type EditableViolation = Violation & { images: File[] };

const violations = reactive<EditableViolation[]>(
    props.audit.violations.map((v) => ({ ...v, images: [] as File[] })),
);
const date = ref(props.audit.date);
const submitting = ref(false);

const submit = (): void => {
    submitting.value = true;
    const data: Record<string, unknown> = { date: date.value };
    violations.forEach((violation, index) => {
        data[`violations[${index}][id]`] = violation.id;
        data[`violations[${index}][comment]`] = violation.comment;
        data[`violations[${index}][violation_date]`] = violation.violation_date ?? '';
        data[`violations[${index}][risk]`] = violation.risk ? 1 : 0;
        data[`violations[${index}][severity]`] = violation.severity ?? '';
        data[`violations[${index}][show_reference_image]`] = violation.show_reference_image ? 1 : 0;
        violation.images.forEach((file, fileIndex) => {
            data[`violations[${index}][images][${fileIndex}]`] = file;
        });
    });
    router.post(osha.update.url({ audit: props.audit.uuid }), data as never, {
        forceFormData: true,
        headers: { 'X-HTTP-Method-Override': 'PATCH' },
        preserveScroll: true,
        onFinish: () => {
            submitting.value = false;
        },
    });
};

const deleteViolation = (violation: Violation): void => {
    if (!confirm('Delete this violation?')) return;
    router.delete(osha.violations.destroy.url({ audit: props.audit.uuid, violation: violation.id }), {
        preserveScroll: true,
    });
};

const deletePhoto = (violation: Violation, photo: Photo): void => {
    if (!confirm('Remove this photo?')) return;
    router.delete(
        osha.violations.photos.destroy.url({
            audit: props.audit.uuid,
            violation: violation.id,
            photoId: photo.id,
        }),
        { preserveScroll: true },
    );
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
            `${osha.violations.search.url({ audit: props.audit.uuid })}?q=${encodeURIComponent(search.value)}`,
            { headers: { Accept: 'application/json' } },
        );
        searchResults.value = await response.json();
    } finally {
        searching.value = false;
    }
};

const addViolation = (statementId: number): void => {
    router.post(
        osha.violations.store.url({ audit: props.audit.uuid }),
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
            <Link :href="osha.show.url({ audit: audit.uuid })">
                <Button variant="ghost">
                    <ArrowLeft class="size-4" />
                    Back
                </Button>
            </Link>
        </template>

        <form class="space-y-6 p-4" @submit.prevent="submit">
            <div class="rounded-lg border bg-card p-4">
                <Label for="audit-date">Audit date</Label>
                <Input id="audit-date" v-model="date" type="date" class="mt-1 max-w-xs" />
            </div>

            <div class="flex items-center justify-between">
                <h2 class="text-base font-semibold">Violations</h2>
                <Dialog v-model:open="searchOpen">
                    <DialogTrigger as-child>
                        <Button type="button" variant="outline">
                            <Search class="size-4" />
                            Add violation
                        </Button>
                    </DialogTrigger>
                    <DialogContent class="max-w-2xl">
                        <DialogHeader>
                            <DialogTitle>Find a violation statement</DialogTitle>
                        </DialogHeader>
                        <Input
                            v-model="search"
                            placeholder="Search statements…"
                            @input="runSearch"
                        />
                        <div class="max-h-80 space-y-1 overflow-y-auto">
                            <p v-if="searching" class="text-sm text-muted-foreground">Searching…</p>
                            <p v-else-if="search.length >= 2 && !searchResults.length" class="text-sm text-muted-foreground">
                                No matches.
                            </p>
                            <button
                                v-for="result in searchResults"
                                :key="result.id"
                                type="button"
                                class="w-full rounded border p-3 text-left text-sm hover:bg-muted"
                                @click="addViolation(result.id)"
                            >
                                {{ result.statement }}
                            </button>
                        </div>
                    </DialogContent>
                </Dialog>
            </div>

            <div v-if="!violations.length" class="rounded-lg border bg-card p-6 text-center text-sm text-muted-foreground">
                No violations yet — add one above.
            </div>

            <div v-for="(violation, index) in violations" :key="violation.id" class="rounded-lg border bg-card p-4">
                <div class="flex items-start justify-between gap-3">
                    <p class="font-medium">{{ violation.statement }}</p>
                    <Button type="button" variant="ghost" size="sm" @click="deleteViolation(violation)">
                        <Trash2 class="size-4" />
                    </Button>
                </div>

                <div class="mt-3 grid gap-3 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <Label :for="`comment-${violation.id}`">Comment</Label>
                        <Textarea
                            :id="`comment-${violation.id}`"
                            v-model="violations[index].comment"
                            rows="2"
                        />
                    </div>
                    <div>
                        <Label :for="`date-${violation.id}`">Violation date</Label>
                        <Input
                            :id="`date-${violation.id}`"
                            v-model="violations[index].violation_date as string"
                            type="date"
                        />
                    </div>
                    <div>
                        <Label :for="`severity-${violation.id}`">Severity (0-10)</Label>
                        <Input
                            :id="`severity-${violation.id}`"
                            v-model.number="violations[index].severity as number"
                            type="number"
                            min="0"
                            max="10"
                        />
                    </div>
                    <div class="flex items-center gap-2">
                        <Checkbox v-model:checked="violations[index].risk" :id="`risk-${violation.id}`" />
                        <Label :for="`risk-${violation.id}`">Mark as risk</Label>
                    </div>
                    <div v-if="violation.reference_image_url" class="flex items-center gap-2">
                        <Checkbox
                            v-model:checked="violations[index].show_reference_image"
                            :id="`refimg-${violation.id}`"
                        />
                        <Label :for="`refimg-${violation.id}`">Include reference image in report</Label>
                    </div>
                </div>

                <div v-if="violation.photos.length" class="mt-3 flex flex-wrap gap-2">
                    <div v-for="photo in violation.photos" :key="photo.id" class="relative">
                        <img :src="photo.url" class="size-20 rounded object-cover" alt="" />
                        <button
                            type="button"
                            class="absolute -right-2 -top-2 grid size-6 place-items-center rounded-full bg-destructive text-destructive-foreground"
                            @click="deletePhoto(violation, photo)"
                        >
                            <Trash2 class="size-3" />
                        </button>
                    </div>
                </div>

                <div class="mt-3">
                    <ImageUploadField v-model="violations[index].images" :max="3" />
                </div>
            </div>

            <div class="flex justify-end">
                <Button type="submit" :disabled="submitting">
                    {{ submitting ? 'Saving…' : 'Save changes' }}
                </Button>
            </div>
        </form>
    </AppLayout>
</template>
