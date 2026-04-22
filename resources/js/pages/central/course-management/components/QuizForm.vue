<script setup lang="ts">
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import { Button } from "@/components/ui/button";
import { FieldError } from "@/components/ui/field";
import { Loader2 } from "lucide-vue-next";
import QuestionsRepeater, {
    type QuizQuestion,
} from "@/pages/central/course-management/components/QuestionsRepeater.vue";
import courseManagementRoutes from "@/routes/course-management";

type RawAnswer = Record<string, string> | { key: string; value: string };

type RawQuestion = {
    question?: string;
    answers?: RawAnswer[];
    correctAnswer?: string;
};

const props = defineProps<{
    slug: string;
    questions: RawQuestion[];
}>();

const normaliseAnswers = (answers: RawAnswer[] | undefined): { key: string; value: string }[] => {
    if (!answers || answers.length === 0) {
        return [{ key: "a", value: "" }];
    }

    return answers.map((answer) => {
        if ("key" in answer && "value" in answer) {
            return { key: String(answer.key ?? ""), value: String(answer.value ?? "") };
        }

        const [key, value] = Object.entries(answer)[0] ?? ["", ""];
        return { key: String(key), value: String(value) };
    });
};

const initial: QuizQuestion[] = (props.questions ?? []).map((q) => ({
    question: q.question ?? "",
    answers: normaliseAnswers(q.answers),
    correctAnswer: q.correctAnswer ?? "",
}));

const questions = ref<QuizQuestion[]>(initial);

const form = useForm<{ questions: QuizQuestion[] }>({ questions: initial });

const submit = (): void => {
    form.questions = questions.value;
    form.patch(courseManagementRoutes.updateQuiz(props.slug).url, {
        preserveScroll: true,
    });
};
</script>

<template>
    <form class="space-y-6" @submit.prevent="submit">
        <QuestionsRepeater v-model="questions" />
        <FieldError v-if="form.errors.questions">{{ form.errors.questions }}</FieldError>

        <div class="flex justify-end">
            <Button type="submit" :disabled="form.processing">
                <Loader2 v-if="form.processing" class="animate-spin" />
                Save Quiz
            </Button>
        </div>
    </form>
</template>
