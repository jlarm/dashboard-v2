<script setup lang="ts">
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Field, FieldLabel } from "@/components/ui/field";
import { Plus, Trash2 } from "lucide-vue-next";

export type QuizAnswer = { key: string; value: string };

export type QuizQuestion = {
    question: string;
    answers: QuizAnswer[];
    correctAnswer: string;
};

const model = defineModel<QuizQuestion[]>({ required: true });

const nextAnswerKey = (answers: QuizAnswer[]): string => {
    const used = new Set(
        answers
            .map((a) => (a.key ?? "").trim().toLowerCase())
            .filter((k) => /^[a-z]$/.test(k)),
    );

    for (let code = 97; code <= 122; code++) {
        const letter = String.fromCharCode(code);
        if (!used.has(letter)) {
            return letter;
        }
    }

    return "";
};

const addQuestion = (): void => {
    model.value = [
        ...model.value,
        { question: "", answers: [{ key: "a", value: "" }], correctAnswer: "" },
    ];
};

const removeQuestion = (index: number): void => {
    model.value = model.value.filter((_, i) => i !== index);
};

const addAnswer = (questionIndex: number): void => {
    const answers = model.value[questionIndex].answers;
    answers.push({ key: nextAnswerKey(answers), value: "" });
};

const removeAnswer = (questionIndex: number, answerIndex: number): void => {
    const answers = model.value[questionIndex].answers;
    answers.splice(answerIndex, 1);
    answers.forEach((answer, i) => {
        answer.key = String.fromCharCode(97 + i);
    });
};
</script>

<template>
    <div class="space-y-5">
        <div
            v-for="(question, qIndex) in model"
            :key="qIndex"
            class="rounded-md border border-border bg-card p-4 space-y-4"
        >
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium">Question {{ qIndex + 1 }}</p>
                <Button
                    type="button"
                    variant="ghost"
                    size="sm"
                    class="text-destructive hover:text-destructive"
                    @click="removeQuestion(qIndex)"
                >
                    <Trash2 class="size-4" />
                </Button>
            </div>

            <Field>
                <FieldLabel :for="`question-${qIndex}`">Question</FieldLabel>
                <Input :id="`question-${qIndex}`" v-model="question.question" />
            </Field>

            <div class="space-y-2">
                <p class="text-xs font-medium text-muted-foreground uppercase tracking-wide">
                    Answers
                </p>
                <div
                    v-for="(answer, aIndex) in question.answers"
                    :key="aIndex"
                    class="flex items-start gap-2"
                >
                    <Input
                        v-model="answer.key"
                        placeholder="Key"
                        class="w-1/3"
                    />
                    <Input
                        v-model="answer.value"
                        placeholder="Value"
                        class="flex-1"
                    />
                    <Button
                        type="button"
                        variant="ghost"
                        size="sm"
                        class="text-destructive hover:text-destructive"
                        @click="removeAnswer(qIndex, aIndex)"
                    >
                        <Trash2 class="size-4" />
                    </Button>
                </div>
                <Button type="button" variant="outline" size="sm" @click="addAnswer(qIndex)">
                    <Plus class="size-4" />
                    Add Answer
                </Button>
            </div>

            <Field>
                <FieldLabel :for="`correct-answer-${qIndex}`">Correct Answer</FieldLabel>
                <Input
                    :id="`correct-answer-${qIndex}`"
                    v-model="question.correctAnswer"
                />
            </Field>
        </div>

        <Button type="button" variant="outline" size="sm" @click="addQuestion">
            <Plus class="size-4" />
            Add Question
        </Button>
    </div>
</template>
