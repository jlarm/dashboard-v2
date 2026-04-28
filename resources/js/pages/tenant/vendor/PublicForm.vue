<script setup lang="ts">
import { computed, reactive, ref } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import { CheckCircle2, FileUp, Loader2, ShieldCheck } from 'lucide-vue-next';
import AppLogo from '@/components/AppLogo.vue';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import SignaturePad from '@/pages/central/contract/components/SignaturePad.vue';

type VendorFormProps = {
    id: number;
    vendor_name: string;
    contact_name: string;
};

type Question = { index: number; text: string };

const props = defineProps<{
    vendorForm: VendorFormProps;
    storeName: string;
    questions: Record<number, string>;
    submitUrl: string;
}>();

type ResponseValue = 'yes' | 'no' | 'na' | '';

type Mode = 'questions' | 'document';

const mode = ref<Mode>('questions');

const questionList = computed<Question[]>(() =>
    Object.entries(props.questions)
        .map(([index, text]) => ({ index: Number(index), text }))
        .sort((a, b) => a.index - b.index),
);

const responses = reactive<Record<number, { response: ResponseValue; comment: string }>>(
    questionList.value.reduce(
        (acc, q) => {
            acc[q.index] = { response: '', comment: '' };
            return acc;
        },
        {} as Record<number, { response: ResponseValue; comment: string }>,
    ),
);

const signature = ref<string>('');
const document = ref<File | null>(null);
const errors = ref<Record<string, string>>({});
const processing = ref(false);

const totalAnswered = computed<number>(() =>
    Object.values(responses).filter((r) => r.response !== '').length,
);

const completionPct = computed<number>(() =>
    Math.round((totalAnswered.value / questionList.value.length) * 100),
);

const onFile = (event: Event): void => {
    const target = event.target as HTMLInputElement;
    document.value = target.files && target.files[0] ? target.files[0] : null;
};

const switchMode = (next: Mode): void => {
    mode.value = next;
    errors.value = {};
};

const fieldError = (key: string): string | undefined => errors.value[key];

const submit = (): void => {
    errors.value = {};
    processing.value = true;

    if (mode.value === 'document') {
        if (!document.value) {
            errors.value.document = 'Please upload a PDF document.';
            processing.value = false;
            return;
        }

        router.post(
            props.submitUrl,
            { document: document.value },
            {
                forceFormData: true,
                preserveScroll: true,
                onError: (errs) => {
                    errors.value = errs;
                },
                onFinish: () => {
                    processing.value = false;
                },
            },
        );
        return;
    }

    const responsesPayload: Record<number, { response: string; comment: string | null }> = {};
    for (const q of questionList.value) {
        responsesPayload[q.index] = {
            response: responses[q.index].response,
            comment: responses[q.index].comment.trim() === '' ? null : responses[q.index].comment.trim(),
        };
    }

    router.post(props.submitUrl, {
        signature: signature.value,
        responses: responsesPayload,
    }, {
        preserveScroll: true,
        onError: (errs) => {
            errors.value = errs;
        },
        onFinish: () => {
            processing.value = false;
        },
    });
};
</script>

<template>
    <Head title="Vendor Risk Assessment" />

    <div class="min-h-screen bg-slate-50 pb-20">
        <header class="border-b bg-white">
            <div class="mx-auto flex max-w-3xl items-center justify-between gap-4 px-4 py-5">
                <AppLogo class="h-8 w-auto" />
                <span class="text-xs font-medium uppercase tracking-wide text-slate-500">
                    {{ props.storeName }}
                </span>
            </div>
        </header>

        <main class="mx-auto max-w-3xl px-4 py-10">
            <section class="rounded-xl border bg-white p-8 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="flex size-10 items-center justify-center rounded-full bg-emerald-100 text-emerald-700">
                        <ShieldCheck class="size-5" />
                    </div>
                    <div>
                        <h1 class="text-xl font-semibold tracking-tight text-slate-900">
                            Third-Party Vendor Risk Assessment
                        </h1>
                        <p class="text-sm text-slate-500">{{ props.vendorForm.vendor_name }}</p>
                    </div>
                </div>

                <p class="mt-6 text-sm leading-6 text-slate-600">
                    Hi <span class="font-medium text-slate-800">{{ props.vendorForm.contact_name }}</span>, please
                    complete the Risk Assessment below and provide electronic sign-off. We are finalizing our
                    GLBA / Safeguards Rule requirements and need to confirm that {{ props.vendorForm.vendor_name }}
                    has adequate policies, procedures, and IT/cybersecurity controls in place to protect customer
                    information.
                </p>

                <p class="mt-3 text-sm leading-6 text-slate-600">
                    You can either upload an existing written policies-and-procedures program (signed by an Owner
                    or board member), or answer the questionnaire and sign electronically below.
                </p>
            </section>

            <div class="mt-6 inline-flex rounded-md border bg-white p-1 shadow-sm">
                <button
                    type="button"
                    :class="[
                        'rounded-md px-4 py-1.5 text-sm font-medium transition',
                        mode === 'questions' ? 'bg-slate-900 text-white' : 'text-slate-600 hover:text-slate-900',
                    ]"
                    @click="switchMode('questions')"
                >
                    Answer questionnaire
                </button>
                <button
                    type="button"
                    :class="[
                        'rounded-md px-4 py-1.5 text-sm font-medium transition',
                        mode === 'document' ? 'bg-slate-900 text-white' : 'text-slate-600 hover:text-slate-900',
                    ]"
                    @click="switchMode('document')"
                >
                    Upload PDF
                </button>
            </div>

            <form class="mt-6 space-y-6" @submit.prevent="submit">
                <section v-if="mode === 'document'" class="rounded-xl border border-dashed bg-white p-8">
                    <div class="flex flex-col items-center text-center">
                        <FileUp class="size-10 text-slate-400" />
                        <h2 class="mt-3 text-base font-semibold text-slate-900">
                            Upload completed Risk Assessment (PDF)
                        </h2>
                        <p class="mt-2 max-w-md text-sm text-slate-600">
                            If {{ props.vendorForm.vendor_name }} already has a written policies-and-procedures program
                            outlining its response to GLBA / Safeguards-related security and IT incidents, you may
                            upload a PDF here. The document must be signed by an Owner, board member, or upper
                            management.
                        </p>
                        <label class="mt-5 inline-flex cursor-pointer items-center gap-2 rounded-md border bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm hover:bg-slate-50">
                            <span>Choose PDF file</span>
                            <input type="file" accept="application/pdf" class="hidden" @change="onFile" />
                        </label>
                        <p v-if="document" class="mt-3 text-xs text-emerald-700">
                            Selected: {{ document.name }}
                        </p>
                        <p v-if="fieldError('document')" class="mt-2 text-xs text-red-600">
                            {{ fieldError('document') }}
                        </p>
                    </div>
                </section>

                <section v-else class="space-y-4">
                    <div class="rounded-xl border bg-white px-6 py-4">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-slate-700">
                                Question {{ totalAnswered }} of {{ questionList.length }}
                            </p>
                            <span class="text-xs text-slate-500 tabular-nums">{{ completionPct }}% complete</span>
                        </div>
                        <div class="mt-2 h-1.5 overflow-hidden rounded-full bg-slate-100">
                            <div
                                class="h-full rounded-full bg-emerald-500 transition-all"
                                :style="{ width: `${completionPct}%` }"
                            />
                        </div>
                    </div>

                    <div
                        v-for="q in questionList"
                        :key="q.index"
                        class="rounded-xl border bg-white p-6"
                    >
                        <div class="flex items-start gap-3">
                            <span class="mt-0.5 inline-flex size-6 shrink-0 items-center justify-center rounded-full bg-slate-900 text-xs font-semibold text-white">
                                {{ q.index }}
                            </span>
                            <Label class="text-sm font-medium leading-6 text-slate-900">
                                {{ q.text }}
                            </Label>
                        </div>

                        <div class="mt-4 grid grid-cols-1 gap-2 sm:grid-cols-3">
                            <label
                                v-for="option in (['yes', 'no', 'na'] as const)"
                                :key="option"
                                :class="[
                                    'flex cursor-pointer items-center justify-center gap-2 rounded-md border px-3 py-2 text-sm font-medium transition',
                                    responses[q.index].response === option
                                        ? 'border-slate-900 bg-slate-900 text-white'
                                        : 'border-slate-200 bg-white text-slate-700 hover:border-slate-300',
                                ]"
                            >
                                <input
                                    v-model="responses[q.index].response"
                                    type="radio"
                                    :value="option"
                                    class="hidden"
                                />
                                <CheckCircle2
                                    v-if="responses[q.index].response === option"
                                    class="size-3.5"
                                />
                                <span>{{ option === 'na' ? 'N/A' : option.charAt(0).toUpperCase() + option.slice(1) }}</span>
                            </label>
                        </div>

                        <div class="mt-4">
                            <Label
                                :for="`comment-${q.index}`"
                                class="text-xs font-medium uppercase tracking-wide text-slate-500"
                            >
                                Comments (optional)
                            </Label>
                            <Textarea
                                :id="`comment-${q.index}`"
                                v-model="responses[q.index].comment"
                                rows="2"
                                class="mt-1.5"
                            />
                        </div>

                        <p
                            v-if="fieldError(`responses.${q.index}.response`)"
                            class="mt-2 text-xs text-red-600"
                        >
                            {{ fieldError(`responses.${q.index}.response`) }}
                        </p>
                    </div>

                    <div class="rounded-xl border bg-white p-6">
                        <Label class="text-sm font-medium text-slate-900">
                            Electronic Signature
                        </Label>
                        <p class="mt-1 text-xs text-slate-500">
                            Sign in the box below using your mouse, finger, or stylus.
                        </p>
                        <SignaturePad v-model="signature" class="mt-3" />
                        <p v-if="fieldError('signature')" class="mt-2 text-xs text-red-600">
                            {{ fieldError('signature') }}
                        </p>
                    </div>
                </section>

                <div class="flex justify-end">
                    <Button type="submit" size="lg" :disabled="processing">
                        <Loader2 v-if="processing" class="size-4 animate-spin" />
                        Submit assessment
                    </Button>
                </div>
            </form>
        </main>
    </div>
</template>
