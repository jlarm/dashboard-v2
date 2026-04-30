<script setup lang="ts">
import { reactive, ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ArrowLeft, FileDown } from 'lucide-vue-next';
import AppLayout from '@/layouts/tenant/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { Textarea } from '@/components/ui/textarea';
import { Label } from '@/components/ui/label';
import { Checkbox } from '@/components/ui/checkbox';
import osha from '@/routes/dealer/audit/osha';
import type { BreadcrumbItem } from '@/types';
import type { AuditTypeSlug } from '@/components/audits/audit-types';

type Remediation = { id: number; comment: string; completed: boolean; user_name: string | null; photo_url: string | null };
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

const breadcrumbs: BreadcrumbItem[] = [
    { title: `${props.label} Audits`, href: osha.index.url() },
    { title: 'Remediation', href: osha.remediation.url({ audit: props.audit.uuid }) },
];

type RemediationDraft = {
    comment: string;
    completed: boolean;
    photo: File | null;
    remove_photo: boolean;
    existing_photo_url: string | null;
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
            },
        ]),
    ),
);

const submitting = ref(false);

const onPhoto = (violationId: number, event: Event): void => {
    const input = event.target as HTMLInputElement;
    drafts[violationId].photo = input.files?.[0] ?? null;
};

const removePhoto = (violationId: number): void => {
    drafts[violationId].remove_photo = true;
    drafts[violationId].existing_photo_url = null;
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
        osha.remediation.update.url({ audit: props.audit.uuid }),
        data as never,
        {
            forceFormData: true,
            headers: { 'X-HTTP-Method-Override': 'PATCH' },
            preserveScroll: true,
            onFinish: () => {
                submitting.value = false;
            },
        },
    );
};

const generateRemediationPdf = (): void => {
    router.post(`/audits/osha/${props.audit.uuid}/remediation/generate`, {}, { preserveScroll: true });
};
</script>

<template>
    <Head :title="`${label} remediation`" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <template #actions>
            <Link :href="osha.show.url({ audit: audit.uuid })">
                <Button variant="ghost">
                    <ArrowLeft class="size-4" />
                    Back
                </Button>
            </Link>
            <Button type="button" variant="outline" @click="generateRemediationPdf">
                Generate report
            </Button>
            <a v-if="audit.has_remediation_pdf" :href="`/audits/osha/${audit.uuid}/remediation/download`">
                <Button variant="outline">
                    <FileDown class="size-3.5" />
                    PDF
                </Button>
            </a>
        </template>

        <form class="space-y-4 p-4" @submit.prevent="submit">
            <div v-if="!audit.violations.length" class="rounded-lg border bg-card p-6 text-center text-sm text-muted-foreground">
                No violations to remediate.
            </div>
            <div
                v-for="violation in audit.violations"
                :key="violation.id"
                class="rounded-lg border bg-card p-4"
            >
                <p class="font-medium">{{ violation.statement }}</p>
                <p v-if="violation.comment" class="mt-1 text-sm text-muted-foreground">{{ violation.comment }}</p>

                <div class="mt-3 space-y-3">
                    <div>
                        <Label :for="`remediation-comment-${violation.id}`">Remediation notes</Label>
                        <Textarea
                            :id="`remediation-comment-${violation.id}`"
                            v-model="drafts[violation.id].comment"
                            rows="2"
                        />
                    </div>

                    <div class="flex items-center gap-2">
                        <Checkbox
                            v-model:checked="drafts[violation.id].completed"
                            :id="`remediation-done-${violation.id}`"
                        />
                        <Label :for="`remediation-done-${violation.id}`">Mark as completed</Label>
                    </div>

                    <div v-if="drafts[violation.id].existing_photo_url" class="flex items-center gap-3">
                        <img :src="drafts[violation.id].existing_photo_url!" class="size-16 rounded object-cover" alt="" />
                        <Button
                            type="button"
                            variant="ghost"
                            size="sm"
                            @click="removePhoto(violation.id)"
                        >
                            Remove photo
                        </Button>
                    </div>

                    <div>
                        <Label :for="`remediation-photo-${violation.id}`">Add photo</Label>
                        <input
                            :id="`remediation-photo-${violation.id}`"
                            type="file"
                            accept="image/*,.heic,.heif"
                            class="mt-1 block w-full text-sm"
                            @change="(event) => onPhoto(violation.id, event)"
                        />
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <Button type="submit" :disabled="submitting">
                    {{ submitting ? 'Saving…' : 'Save remediations' }}
                </Button>
            </div>
        </form>
    </AppLayout>
</template>
