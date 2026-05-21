<script setup lang="ts">
import { computed, reactive, ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { AlertTriangle, ArrowLeft, Save } from 'lucide-vue-next';
import AppLayout from '@/layouts/tenant/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { Field, FieldLabel } from '@/components/ui/field';
import { Input } from '@/components/ui/input';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { Switch } from '@/components/ui/switch';
import { Textarea } from '@/components/ui/textarea';
import dealJackets from '@/routes/dealer/audit/deal-jackets';
import type { BreadcrumbItem } from '@/types';

type Question = {
    id: number;
    question: string;
    statement: string;
    categories: string[];
    weight: number;
};

type Response = {
    statement: string;
    answer: 'yes' | 'no' | 'na' | null;
    high_risk: boolean;
    comment: string | null;
};

type Jacket = {
    id: number;
    uuid: string;
    audit_date: string;
    date_of_deal_jacket: string;
    customer_name: string | null;
    customer_deal_number: string | null;
    user_id: number | null;
    mileage: string | null;
    purchase_type: string | null;
    vehicle_type: string | null;
    responses: Response[];
};

const props = defineProps<{
    group: { id: number; uuid: string };
    jacket: Jacket | null;
    questions: Question[];
    managers: { id: number; name: string }[];
}>();

const isEdit = computed(() => props.jacket !== null);
const today = () => new Date().toISOString().slice(0, 10);

const form = reactive({
    audit_date: props.jacket?.audit_date ?? today(),
    date_of_deal_jacket: props.jacket?.date_of_deal_jacket ?? '',
    customer_name: props.jacket?.customer_name ?? '',
    customer_deal_number: props.jacket?.customer_deal_number ?? '',
    finance_manager: props.jacket?.user_id !== undefined && props.jacket?.user_id !== null
        ? String(props.jacket.user_id)
        : (props.jacket ? 'house' : ''),
    mileage: props.jacket?.mileage ?? '',
    purchase_type: props.jacket?.purchase_type ?? '',
    vehicle_type: props.jacket?.vehicle_type ?? '',
});

const filteredQuestions = computed<Question[]>(() => {
    if (!form.purchase_type || !form.vehicle_type) return [];
    return props.questions.filter(
        (q) => q.categories.includes(form.purchase_type) && q.categories.includes(form.vehicle_type),
    );
});

const responses = reactive<Record<number, Response>>({});

const syncResponses = (): void => {
    const next: Record<number, Response> = {};
    filteredQuestions.value.forEach((q) => {
        const existing = responses[q.id];
        const fromJacket = props.jacket?.responses.find((r) => r.statement === q.statement);
        next[q.id] = existing ?? {
            statement: q.statement,
            answer: (fromJacket?.answer as Response['answer']) ?? null,
            high_risk: fromJacket?.high_risk ?? false,
            comment: fromJacket?.comment ?? null,
        };
    });
    // Drop stale entries from previous purchase/vehicle types
    Object.keys(responses).forEach((key) => {
        if (!next[Number(key)]) delete responses[Number(key)];
    });
    Object.entries(next).forEach(([key, value]) => {
        responses[Number(key)] = value;
    });
};

syncResponses();

const onTypeChange = (): void => {
    syncResponses();
};

const submitting = ref(false);
const errors = ref<Record<string, string>>({});

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Deal Jackets', href: dealJackets.index.url() },
    { title: 'Group', href: dealJackets.show.url({ dealJacketGroup: props.group.uuid }) },
    {
        title: isEdit.value ? 'Edit deal jacket' : 'New deal jacket',
        href: isEdit.value && props.jacket
            ? dealJackets.edit.url({ dealJacketGroup: props.group.uuid, dealJacket: props.jacket.uuid })
            : dealJackets.create.url({ dealJacketGroup: props.group.uuid }),
    },
];

const answerClasses = (answer: 'yes' | 'no' | 'na'): string => {
    switch (answer) {
        case 'yes':
            return 'border-emerald-500 bg-emerald-500 text-white';
        case 'no':
            return 'border-red-600 bg-red-600 text-white';
        case 'na':
            return 'border-slate-400 bg-slate-400 text-white';
    }
};

const submit = (): void => {
    submitting.value = true;
    errors.value = {};

    const orderedQuestions = filteredQuestions.value;
    const responsePayload = orderedQuestions.map((q) => responses[q.id]);
    const weightPayload = orderedQuestions.map((q) => q.weight);

    const data: Record<string, unknown> = {
        audit_date: form.audit_date,
        date_of_deal_jacket: form.date_of_deal_jacket,
        customer_name: form.customer_name,
        customer_deal_number: form.customer_deal_number,
        finance_manager: form.finance_manager,
        mileage: form.mileage,
        purchase_type: form.purchase_type,
        vehicle_type: form.vehicle_type,
    };
    responsePayload.forEach((r, i) => {
        data[`responses[${i}][statement]`] = r.statement;
        data[`responses[${i}][answer]`] = r.answer ?? '';
        data[`responses[${i}][high_risk]`] = r.high_risk ? 1 : 0;
        data[`responses[${i}][comment]`] = r.comment ?? '';
    });
    weightPayload.forEach((w, i) => {
        data[`question_weights[${i}]`] = w;
    });

    const url = isEdit.value && props.jacket
        ? dealJackets.update.url({ dealJacketGroup: props.group.uuid, dealJacket: props.jacket.uuid })
        : dealJackets.store.url({ dealJacketGroup: props.group.uuid });

    const method = isEdit.value ? 'patch' : 'post';

    router[method](url, data as never, {
        forceFormData: true,
        preserveScroll: true,
        onError: (e) => {
            errors.value = e as Record<string, string>;
        },
        onFinish: () => {
            submitting.value = false;
        },
    });
};
</script>

<template>
    <Head :title="isEdit ? 'Edit deal jacket' : 'New deal jacket'" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <template #actions>
            <Link :href="dealJackets.show.url({ dealJacketGroup: group.uuid })">
                <Button variant="ghost" size="sm">
                    <ArrowLeft class="size-4" />
                    Back
                </Button>
            </Link>
            <Button size="sm" :disabled="submitting" @click="submit">
                <Save class="size-4" />
                {{ isEdit ? 'Update' : 'Create' }}
            </Button>
        </template>

        <form class="mx-auto max-w-3xl space-y-5 px-3 py-6 sm:px-6" @submit.prevent="submit">
            <section class="rounded-lg border bg-card p-5">
                <h2 class="text-sm font-semibold tracking-tight">Deal info</h2>
                <div class="mt-4 grid gap-4 md:grid-cols-2">
                    <Field>
                        <FieldLabel for="customer_name">Customer name</FieldLabel>
                        <Input id="customer_name" v-model="form.customer_name" type="text" />
                        <p v-if="errors.customer_name" class="text-xs text-destructive">{{ errors.customer_name }}</p>
                    </Field>
                    <Field>
                        <FieldLabel for="customer_deal_number">Deal #</FieldLabel>
                        <Input id="customer_deal_number" v-model="form.customer_deal_number" type="text" />
                        <p v-if="errors.customer_deal_number" class="text-xs text-destructive">{{ errors.customer_deal_number }}</p>
                    </Field>
                    <Field>
                        <FieldLabel for="audit_date">Audit date</FieldLabel>
                        <Input id="audit_date" v-model="form.audit_date" type="date" />
                    </Field>
                    <Field>
                        <FieldLabel for="date_of_deal_jacket">Deal jacket date</FieldLabel>
                        <Input id="date_of_deal_jacket" v-model="form.date_of_deal_jacket" type="date" />
                    </Field>
                    <Field>
                        <FieldLabel for="finance_manager">Finance manager</FieldLabel>
                        <Select v-model="form.finance_manager">
                            <SelectTrigger id="finance_manager" class="w-full">
                                <SelectValue placeholder="Select" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem value="house">House</SelectItem>
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
                    <Field>
                        <FieldLabel for="purchase_type">Deal type</FieldLabel>
                        <Select v-model="form.purchase_type" @update:model-value="onTypeChange">
                            <SelectTrigger id="purchase_type" class="w-full">
                                <SelectValue placeholder="Select" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem value="cash">Cash</SelectItem>
                                <SelectItem value="finance">Finance</SelectItem>
                                <SelectItem value="lease">Lease</SelectItem>
                            </SelectContent>
                        </Select>
                    </Field>
                    <Field>
                        <FieldLabel for="vehicle_type">Vehicle type</FieldLabel>
                        <Select v-model="form.vehicle_type" @update:model-value="onTypeChange">
                            <SelectTrigger id="vehicle_type" class="w-full">
                                <SelectValue placeholder="Select" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem value="new">New</SelectItem>
                                <SelectItem value="used">Used</SelectItem>
                            </SelectContent>
                        </Select>
                    </Field>
                </div>
            </section>

            <section v-if="filteredQuestions.length > 0" class="rounded-lg border bg-card p-5">
                <h2 class="text-sm font-semibold tracking-tight">Compliance questions</h2>
                <p class="mt-1 text-xs text-muted-foreground">{{ filteredQuestions.length }} questions for this deal type</p>
                <div class="mt-4 space-y-3">
                    <div
                        v-for="(question, index) in filteredQuestions"
                        :key="question.id"
                        class="space-y-3 rounded-lg border bg-card p-4"
                    >
                        <p class="text-sm font-medium leading-snug">{{ index + 1 }}. {{ question.question }}</p>

                        <Field>
                            <FieldLabel class="text-xs uppercase tracking-wider text-muted-foreground">
                                Answer
                            </FieldLabel>
                            <div class="grid grid-cols-3 gap-1.5">
                                <button
                                    v-for="opt in (['yes', 'no', 'na'] as const)"
                                    :key="opt"
                                    type="button"
                                    class="flex h-11 items-center justify-center rounded-md border text-sm font-medium transition"
                                    :class="responses[question.id].answer === opt
                                        ? answerClasses(opt)
                                        : 'border-input bg-muted/40 text-muted-foreground hover:bg-muted'"
                                    @click="responses[question.id].answer = responses[question.id].answer === opt ? null : opt"
                                >
                                    {{ opt === 'na' ? 'N/A' : (opt === 'yes' ? 'Yes' : 'No') }}
                                </button>
                            </div>
                        </Field>

                        <Field v-if="responses[question.id].answer === 'no'">
                            <FieldLabel :for="`q${question.id}_comment`" class="text-xs uppercase tracking-wider text-muted-foreground">
                                Comment
                            </FieldLabel>
                            <Textarea
                                :id="`q${question.id}_comment`"
                                v-model="responses[question.id].comment"
                                rows="2"
                                placeholder="What went wrong?"
                                class="resize-none text-sm"
                            />
                        </Field>

                        <Field
                            orientation="horizontal"
                            class="rounded-lg border px-3 py-3 transition-colors"
                            :class="responses[question.id].high_risk
                                ? 'border-red-300 bg-red-50 dark:border-red-900/60 dark:bg-red-950/30'
                                : 'border-border bg-muted/30'"
                        >
                            <span
                                class="grid size-9 shrink-0 place-items-center rounded-md ring-1 transition-colors"
                                :class="responses[question.id].high_risk
                                    ? 'bg-red-100 text-red-600 ring-red-200 dark:bg-red-900/40 dark:text-red-300 dark:ring-red-900/60'
                                    : 'bg-background text-muted-foreground ring-border'"
                            >
                                <AlertTriangle class="size-4" />
                            </span>
                            <FieldLabel
                                :for="`q${question.id}_high_risk`"
                                class="flex-1 text-sm font-medium transition-colors"
                                :class="responses[question.id].high_risk ? 'text-red-700 dark:text-red-300' : ''"
                            >
                                Flag as High Risk
                            </FieldLabel>
                            <Switch
                                v-model="responses[question.id].high_risk"
                                :id="`q${question.id}_high_risk`"
                                class="data-[state=checked]:bg-red-600 dark:data-[state=checked]:bg-red-500"
                            />
                        </Field>
                    </div>
                </div>
            </section>
            <section v-else class="rounded-lg border bg-card p-5 text-center text-sm text-muted-foreground">
                Select a deal type and vehicle type to see the compliance questions.
            </section>

            <div class="flex items-center justify-end gap-2 pb-8">
                <Link :href="dealJackets.show.url({ dealJacketGroup: group.uuid })">
                    <Button type="button" variant="outline" :disabled="submitting">
                        Cancel
                    </Button>
                </Link>
                <Button type="submit" :disabled="submitting">
                    <Save class="size-4" />
                    {{ isEdit ? 'Update' : 'Create' }}
                </Button>
            </div>
        </form>
    </AppLayout>
</template>
