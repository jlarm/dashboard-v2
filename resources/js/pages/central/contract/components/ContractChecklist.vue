<script setup lang="ts">
const props = defineProps<{
    steps: number[];
}>();

const items: Array<{ step: number; label: string }> = [
    { step: 1, label: "Create Contract" },
    { step: 2, label: "Contract sent for review" },
    { step: 3, label: "Contract signed by Dealer" },
    { step: 4, label: "Contract signed by ARMP" },
    { step: 5, label: "Contract approved and completed" },
];

const isComplete = (step: number): boolean => props.steps.includes(step);
</script>

<template>
    <div class="border rounded-md p-4">
        <h2 class="text-sm font-semibold leading-6">Checklist</h2>
        <ul class="divide-y">
            <li v-for="item in items" :key="item.step" class="flex justify-between gap-x-6 py-3">
                <div class="flex items-center gap-x-3">
                    <span v-if="item.step === 5 && isComplete(5)" aria-hidden="true">🎉</span>
                    <div v-else-if="isComplete(item.step)" class="flex-none rounded-full p-1 text-green-500 bg-green-500/10">
                        <div class="h-2 w-2 rounded-full bg-current"></div>
                    </div>
                    <div v-else class="flex-none rounded-full p-1 text-muted-foreground bg-muted">
                        <div class="h-2 w-2 rounded-full bg-current"></div>
                    </div>
                    <h3 class="min-w-0 text-sm leading-6">{{ item.label }}</h3>
                </div>
            </li>
        </ul>
    </div>
</template>
