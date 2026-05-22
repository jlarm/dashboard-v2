<script setup lang="ts">
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import { Pencil } from 'lucide-vue-next';
import {
    Popover,
    PopoverContent,
    PopoverTrigger,
} from '@/components/ui/popover';
import { useAuditRoutes } from '@/composables/useAuditRoutes';
import type { AuditTypeSlug } from '@/components/audits/audit-types';

const props = withDefaults(
    defineProps<{
        type: AuditTypeSlug;
        auditUuid: string;
        grade: string | null;
        editable: boolean;
        align?: 'start' | 'center' | 'end';
    }>(),
    {
        align: 'start',
    },
);

const gradeOptions = ['A', 'B', 'C', 'D', 'F'] as const;
const routes = useAuditRoutes(props.type);

const open = ref(false);
const saving = ref(false);

const setGrade = (grade: string): void => {
    saving.value = true;
    router.patch(
        routes.grade.url({ audit: props.auditUuid }),
        { grade },
        {
            preserveScroll: true,
            onSuccess: () => {
                open.value = false;
            },
            onFinish: () => {
                saving.value = false;
            },
        },
    );
};

const gradeBadgeClass = (grade: string | null): string => {
    switch (grade) {
        case 'A':
            return 'bg-emerald-100 text-emerald-700 ring-emerald-200 dark:bg-emerald-900/40 dark:text-emerald-300 dark:ring-emerald-900/60';
        case 'B':
            return 'bg-sky-100 text-sky-700 ring-sky-200 dark:bg-sky-900/40 dark:text-sky-300 dark:ring-sky-900/60';
        case 'C':
            return 'bg-yellow-100 text-yellow-700 ring-yellow-200 dark:bg-yellow-900/40 dark:text-yellow-300 dark:ring-yellow-900/60';
        case 'D':
            return 'bg-orange-100 text-orange-700 ring-orange-200 dark:bg-orange-900/40 dark:text-orange-300 dark:ring-orange-900/60';
        case 'F':
            return 'bg-red-100 text-red-700 ring-red-200 dark:bg-red-900/40 dark:text-red-300 dark:ring-red-900/60';
        default:
            return 'bg-muted text-muted-foreground ring-border';
    }
};
</script>

<template>
    <Popover v-if="editable" v-model:open="open">
        <PopoverTrigger as-child>
            <button
                type="button"
                class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold ring-1 transition hover:opacity-80"
                :class="gradeBadgeClass(grade)"
                :disabled="saving"
            >
                {{ grade ?? 'Set grade' }}
                <Pencil class="size-3 opacity-60" />
            </button>
        </PopoverTrigger>
        <PopoverContent class="w-auto p-2" :align="align">
            <div class="flex gap-1">
                <button
                    v-for="option in gradeOptions"
                    :key="option"
                    type="button"
                    class="grid size-9 place-items-center rounded-md text-sm font-semibold ring-1 transition hover:opacity-80"
                    :class="[
                        gradeBadgeClass(option),
                        grade === option ? 'ring-2 ring-foreground' : '',
                    ]"
                    :disabled="saving"
                    @click="setGrade(option)"
                >
                    {{ option }}
                </button>
            </div>
        </PopoverContent>
    </Popover>
    <span
        v-else
        class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold ring-1"
        :class="gradeBadgeClass(grade)"
    >
        {{ grade ?? '—' }}
    </span>
</template>
