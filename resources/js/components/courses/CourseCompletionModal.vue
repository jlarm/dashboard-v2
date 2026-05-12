<script setup lang="ts">
import { computed, ref, watch } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import { CheckCircle2, XCircle } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';

type IncorrectQuestion = {
    question: string;
    incorrect_answer_key: string;
    incorrect_answer: string;
};

type QuizFlash = {
    percentage: number;
    passed: boolean;
    course_name: string;
    course_url: string;
    incorrect_questions: IncorrectQuestion[];
    dot_certificate_queued: boolean;
};

const page = usePage<{ flash?: { quiz?: QuizFlash | null } }>();

const open = ref(false);
const data = ref<QuizFlash | null>(null);

watch(
    () => page.props.flash?.quiz ?? null,
    (next) => {
        if (next) {
            data.value = next;
            open.value = true;
        }
    },
    { immediate: true },
);

const title = computed(() => (data.value?.passed ? 'You passed!' : 'Try again'));

const retake = (): void => {
    if (!data.value) return;
    router.visit(data.value.course_url);
    open.value = false;
};
</script>

<template>
    <Dialog v-model:open="open">
        <DialogContent v-if="data" class="sm:max-w-md">
            <DialogHeader>
                <div class="flex justify-center">
                    <CheckCircle2 v-if="data.passed" class="size-12 text-emerald-600" />
                    <XCircle v-else class="size-12 text-red-600" />
                </div>
                <DialogTitle class="text-center">{{ title }}</DialogTitle>
                <DialogDescription class="text-center">
                    {{ data.course_name }} — {{ data.percentage }}%
                </DialogDescription>
            </DialogHeader>

            <div v-if="data.dot_certificate_queued" class="rounded-md bg-emerald-50 px-3 py-2 text-sm text-emerald-800">
                Your DOT certificate is being generated and will appear in your profile shortly.
            </div>

            <div v-if="!data.passed && data.incorrect_questions.length > 0" class="space-y-2 text-sm">
                <p class="font-medium text-zinc-700">Review:</p>
                <ul class="space-y-2">
                    <li
                        v-for="(item, i) in data.incorrect_questions"
                        :key="i"
                        class="rounded-md bg-zinc-50 p-2 text-xs text-zinc-700"
                    >
                        <p class="font-medium">{{ item.question }}</p>
                        <p class="text-red-700">Your answer: {{ item.incorrect_answer || '—' }}</p>
                    </li>
                </ul>
            </div>

            <DialogFooter>
                <Button v-if="!data.passed" variant="outline" @click="retake">Retake course</Button>
                <Button @click="open = false">Close</Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
