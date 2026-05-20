<script setup lang="ts">
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import { Lock } from 'lucide-vue-next';
import { Badge } from '@/components/ui/badge';
import courses from '@/routes/dealer/courses';

type CourseListItem = {
    id: number;
    name: string;
    slug: string;
    status: 'never' | 'passed' | 'failed' | 'expired';
    status_label: string;
    percentage: number | null;
    last_taken_at: string | null;
    has_questions: boolean;
    is_locked: boolean;
    module_index: number | null;
};

const props = defineProps<{
    course: CourseListItem;
}>();

const isClickable = computed(() => props.course.has_questions && !props.course.is_locked);

const badgeClass = computed(() => {
    if (props.course.is_locked) return 'bg-zinc-100 text-zinc-600 ring-1 ring-zinc-200';
    switch (props.course.status) {
        case 'passed':
            return 'bg-emerald-100 text-emerald-800 ring-1 ring-emerald-200';
        case 'failed':
            return 'bg-red-100 text-red-800 ring-1 ring-red-200';
        case 'expired':
            return 'bg-red-100 text-red-800 ring-1 ring-red-200';
        default:
            return 'bg-zinc-100 text-zinc-700 ring-1 ring-zinc-200';
    }
});

const cardClass = computed(() => [
    'relative flex flex-col rounded-xl border p-4 transition-colors',
    props.course.is_locked
        ? 'cursor-not-allowed border-zinc-200 bg-zinc-50 opacity-50'
        : 'border-zinc-200 bg-white hover:border-zinc-400',
]);
</script>

<template>
    <div :class="cardClass" data-test="course-card" :data-slug="course.slug">
        <div class="min-w-0 flex-1 space-y-2">
            <div class="flex items-start justify-between gap-2">
                <h4 class="line-clamp-2 text-sm font-medium text-zinc-800">
                    {{ course.name }}
                </h4>
                <Lock v-if="course.is_locked" class="size-4 shrink-0 text-zinc-400" />
            </div>

            <div class="flex items-center justify-between gap-2">
                <span class="text-xs text-zinc-600">Grade:</span>
                <span class="text-sm font-medium text-zinc-800">
                    <template v-if="course.status === 'passed' && course.percentage !== null">
                        {{ course.percentage }}%
                    </template>
                    <template v-else>—</template>
                </span>
            </div>

            <div class="flex flex-wrap items-center justify-between gap-x-2 gap-y-1">
                <span class="text-xs text-zinc-600">Status:</span>
                <Badge :class="['max-w-full px-1.5 py-0.5 text-xs font-medium', badgeClass]">
                    {{ course.status_label }}
                </Badge>
            </div>

            <Link
                v-if="isClickable"
                :href="courses.show.url({ course: course.slug })"
                class="absolute inset-0 rounded-xl"
                :aria-label="`Open ${course.name}`"
            />
        </div>
    </div>
</template>
