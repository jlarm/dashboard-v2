<script setup lang="ts">
import { computed, reactive, ref } from 'vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import { ArrowLeft, ImagePlus, Save, Trash2 } from 'lucide-vue-next';
import AppLayout from '@/layouts/tenant/AppLayout.vue';
import { Button } from '@/components/ui/button';
import {
    Field,
    FieldLabel,
} from '@/components/ui/field';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { Switch } from '@/components/ui/switch';
import { Textarea } from '@/components/ui/textarea';
import individual from '@/routes/dealer/audit/individual';
import type { BreadcrumbItem } from '@/types';

type Image = { id: number; url: string; preview_url: string | null };
type AnswerRow = { answer: string | null; comment: string | null; danger: boolean };
type AuditDetail = {
    id: number;
    uuid: string;
    parent_id: number | null;
    audit_date: string;
    deal_jacket_date: string | null;
    customer_name: string | null;
    customer_number: string | null;
    manager_id: number | null;
    mileage: string | null;
    draft: boolean;
    quarter: string;
    year: number;
    answers: Record<string, AnswerRow>;
    images: Image[];
};

type Question = { id: number; question: string; kind: 'finance' | 'condition' | 'yes_no' };

const props = defineProps<{
    audit: AuditDetail;
    questions: Question[];
    managers: { id: number; name: string }[];
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Deal Jackets Archived', href: individual.index.url() },
    {
        title: `${props.audit.quarter} ${props.audit.year}`,
        href: individual.show.url({ individualAudit: props.audit.parent_id ? '' : props.audit.uuid }),
    },
    {
        title: props.audit.customer_name || 'Edit deal jacket',
        href: individual.edit.url({ individualAudit: props.audit.uuid }),
    },
];

const answersMap = reactive<Record<number, AnswerRow>>(
    Object.fromEntries(
        props.questions.map((q) => [
            q.id,
            {
                answer: props.audit.answers[`q${q.id}`]?.answer ?? null,
                comment: props.audit.answers[`q${q.id}`]?.comment ?? null,
                danger: props.audit.answers[`q${q.id}`]?.danger ?? false,
            },
        ]),
    ) as Record<number, AnswerRow>,
);

const form = useForm({
    draft: props.audit.draft,
    audit_date: props.audit.audit_date,
    deal_jacket_date: props.audit.deal_jacket_date,
    customer_name: props.audit.customer_name ?? '',
    customer_number: props.audit.customer_number ?? '',
    manager_id: props.audit.manager_id,
    mileage: props.audit.mileage ?? '',
    exit: false as boolean,
});

const newImages = ref<File[]>([]);
const removeImageIds = ref<number[]>([]);
const fileInputRef = ref<HTMLInputElement | null>(null);

const existingImages = computed<Image[]>(() =>
    props.audit.images.filter((img) => !removeImageIds.value.includes(img.id)),
);

const submit = (exit: boolean): void => {
    const data: Record<string, unknown> = {
        _method: 'PATCH',
        draft: form.draft ? 1 : 0,
        audit_date: form.audit_date,
        deal_jacket_date: form.deal_jacket_date,
        customer_name: form.customer_name,
        customer_number: form.customer_number,
        manager_id: form.manager_id,
        mileage: form.mileage,
        exit: exit ? 1 : 0,
    };

    Object.entries(answersMap).forEach(([questionId, row]) => {
        data[`answers[${questionId}][answer]`] = row.answer ?? '';
        data[`answers[${questionId}][comment]`] = row.comment ?? '';
        data[`answers[${questionId}][danger]`] = row.danger ? 1 : 0;
    });

    removeImageIds.value.forEach((id, index) => {
        data[`remove_image_ids[${index}]`] = id;
    });

    newImages.value.forEach((file, index) => {
        data[`new_images[${index}]`] = file;
    });

    router.post(
        individual.update.url({ individualAudit: props.audit.uuid }),
        data as never,
        {
            forceFormData: true,
            preserveScroll: true,
            onSuccess: () => {
                newImages.value = [];
                removeImageIds.value = [];
            },
        },
    );
};

const triggerFilePicker = (): void => {
    fileInputRef.value?.click();
};

const onPickFiles = (event: Event): void => {
    const target = event.target as HTMLInputElement;
    const files = Array.from(target.files ?? []);
    newImages.value.push(...files);
    target.value = '';
};

const removeNewImage = (index: number): void => {
    newImages.value.splice(index, 1);
};

const markImageForRemoval = (id: number): void => {
    if (!removeImageIds.value.includes(id)) {
        removeImageIds.value.push(id);
    }
};

const objectUrl = (file: File): string => URL.createObjectURL(file);

const answerOptions = (kind: Question['kind']): { label: string; value: string }[] => {
    switch (kind) {
        case 'finance':
            return [
                { label: 'Cash', value: '1' },
                { label: 'Finance', value: '2' },
                { label: 'Lease', value: '3' },
            ];
        case 'condition':
            return [
                { label: 'New', value: '1' },
                { label: 'Used', value: '2' },
            ];
        default:
            return [
                { label: 'Yes', value: '1' },
                { label: 'No', value: '2' },
                { label: 'N/A', value: '3' },
            ];
    }
};
</script>

<template>
    <Head title="Edit deal jacket" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <template #actions>
            <Link
                v-if="audit.parent_id"
                :href="individual.show.url({ individualAudit: audit.uuid })"
                class="hidden sm:inline-flex"
            >
                <Button variant="ghost" size="sm">
                    <ArrowLeft class="size-4" />
                    Back
                </Button>
            </Link>
            <Button variant="outline" size="sm" :disabled="form.processing" @click="submit(false)">
                <Save class="size-4" />
                Save
            </Button>
            <Button size="sm" :disabled="form.processing" @click="submit(true)">
                Save &amp; exit
            </Button>
        </template>

        <form class="mx-auto max-w-3xl space-y-5 px-3 py-6 sm:px-6" @submit.prevent="submit(false)">
            <!-- Customer info -->
            <section class="rounded-lg border bg-card p-5 shadow-sm">
                <h2 class="text-sm font-semibold tracking-tight">Customer</h2>
                <div class="mt-4 grid gap-4 md:grid-cols-2">
                    <Field>
                        <FieldLabel for="customer_name">Customer name</FieldLabel>
                        <Input id="customer_name" v-model="form.customer_name" type="text" />
                    </Field>
                    <Field>
                        <FieldLabel for="customer_number">Customer number</FieldLabel>
                        <Input id="customer_number" v-model="form.customer_number" type="text" />
                    </Field>
                    <Field>
                        <FieldLabel for="audit_date">Audit date</FieldLabel>
                        <Input id="audit_date" v-model="form.audit_date" type="date" />
                    </Field>
                    <Field>
                        <FieldLabel for="deal_jacket_date">Deal jacket date</FieldLabel>
                        <Input id="deal_jacket_date" v-model="form.deal_jacket_date" type="date" />
                    </Field>
                    <Field>
                        <FieldLabel for="manager_id">Manager</FieldLabel>
                        <Select
                            :model-value="form.manager_id ? String(form.manager_id) : ''"
                            @update:model-value="(value) => (form.manager_id = value ? Number(value) : null)"
                        >
                            <SelectTrigger id="manager_id" class="w-full">
                                <SelectValue placeholder="Select a manager" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem v-for="m in managers" :key="m.id" :value="String(m.id)">
                                    {{ m.name }}
                                </SelectItem>
                            </SelectContent>
                        </Select>
                    </Field>
                    <Field>
                        <FieldLabel for="mileage">Mileage</FieldLabel>
                        <Input id="mileage" v-model="form.mileage" type="text" />
                    </Field>
                </div>
                <div class="mt-4 flex items-center gap-2">
                    <Switch id="draft" v-model="form.draft" />
                    <Label for="draft" class="text-sm">Draft</Label>
                </div>
            </section>

            <!-- Questions -->
            <section v-for="(question, index) in questions" :key="question.id" class="rounded-lg border bg-card p-5 shadow-sm">
                <p class="text-sm font-medium">{{ index + 1 }}. {{ question.question }}</p>
                <div class="mt-3 flex flex-wrap items-center gap-x-4 gap-y-2">
                    <label
                        v-for="opt in answerOptions(question.kind)"
                        :key="opt.value"
                        class="flex items-center gap-2 text-sm"
                    >
                        <input
                            type="radio"
                            :name="`q${question.id}_answer`"
                            :value="opt.value"
                            v-model="answersMap[question.id].answer"
                            class="size-4 border-input text-primary focus:ring-primary"
                        />
                        {{ opt.label }}
                    </label>
                </div>
                <div class="mt-3 grid gap-3 md:grid-cols-[1fr_auto]">
                    <Textarea
                        v-model="answersMap[question.id].comment"
                        rows="2"
                        placeholder="Comment (optional)"
                        class="resize-none text-sm"
                    />
                    <div class="flex items-center gap-2">
                        <Switch :id="`q${question.id}_danger`" v-model="answersMap[question.id].danger" />
                        <Label :for="`q${question.id}_danger`" class="text-xs">Danger</Label>
                    </div>
                </div>
            </section>

            <!-- Photos -->
            <section class="rounded-lg border bg-card p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <h2 class="text-sm font-semibold tracking-tight">Photos</h2>
                    <Button type="button" variant="outline" size="sm" @click="triggerFilePicker">
                        <ImagePlus class="size-4" />
                        Add photo
                    </Button>
                </div>
                <input
                    ref="fileInputRef"
                    type="file"
                    accept="image/*,.heic,.heif"
                    multiple
                    class="hidden"
                    @change="onPickFiles"
                />
                <div
                    v-if="existingImages.length + newImages.length > 0"
                    class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-3 md:grid-cols-4"
                >
                    <div
                        v-for="img in existingImages"
                        :key="`existing-${img.id}`"
                        class="relative aspect-square overflow-hidden rounded-md ring-1 ring-border"
                    >
                        <img :src="img.preview_url ?? img.url" class="size-full object-cover" alt="" />
                        <button
                            type="button"
                            class="absolute right-1 top-1 rounded-full bg-destructive p-1 text-destructive-foreground shadow"
                            @click="markImageForRemoval(img.id)"
                        >
                            <Trash2 class="size-3" />
                            <span class="sr-only">Remove</span>
                        </button>
                    </div>
                    <div
                        v-for="(file, idx) in newImages"
                        :key="`new-${idx}`"
                        class="relative aspect-square overflow-hidden rounded-md ring-1 ring-border"
                    >
                        <img :src="objectUrl(file)" class="size-full object-cover" alt="" />
                        <button
                            type="button"
                            class="absolute right-1 top-1 rounded-full bg-destructive p-1 text-destructive-foreground shadow"
                            @click="removeNewImage(idx)"
                        >
                            <Trash2 class="size-3" />
                            <span class="sr-only">Remove</span>
                        </button>
                    </div>
                </div>
                <p v-else class="mt-4 text-sm text-muted-foreground">No photos uploaded yet.</p>
            </section>

            <div class="flex items-center justify-end gap-2 pb-8">
                <Button type="button" variant="outline" :disabled="form.processing" @click="submit(false)">
                    <Save class="size-4" />
                    Save
                </Button>
                <Button type="submit" :disabled="form.processing" @click.prevent="submit(true)">
                    Save &amp; exit
                </Button>
            </div>
        </form>
    </AppLayout>
</template>
