<script setup lang="ts">
import UserController from '@/actions/App/Http/Controllers/Tenant/UserController';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import EmployeeShowLayout from '@/pages/tenant/user/components/EmployeeShowLayout.vue';
import type { EmployeeShowProps } from '@/pages/tenant/user/components/types';
import { router, setLayoutProps } from '@inertiajs/vue3';
import { ref } from 'vue';

type CourseState = 'default' | 'add' | 'exclude';

type ManageableCourse = {
    id: number;
    name: string;
    required_for_user: boolean;
    state: CourseState;
};

type StatePill = {
    key: CourseState;
    label: string;
    toneActive: string;
    toneInactive: string;
};

defineOptions({ layout: EmployeeShowLayout });

const props = defineProps<EmployeeShowProps & { manageableCourses: ManageableCourse[] }>();

setLayoutProps<{ activeTab: 'manage-courses' }>({ activeTab: 'manage-courses' });

const statePills: StatePill[] = [
    {
        key: 'default',
        label: 'Default',
        toneActive: 'bg-gray-600 text-white border-gray-600 hover:bg-gray-600',
        toneInactive: 'text-gray-700 border-gray-200 hover:bg-gray-50',
    },
    {
        key: 'add',
        label: 'Add',
        toneActive: 'bg-emerald-600 text-white border-emerald-600 hover:bg-emerald-600',
        toneInactive: 'text-emerald-700 border-emerald-200 hover:bg-emerald-50',
    },
    {
        key: 'exclude',
        label: 'Exclude',
        toneActive: 'bg-rose-600 text-white border-rose-600 hover:bg-rose-600',
        toneInactive: 'text-rose-700 border-rose-200 hover:bg-rose-50',
    },
];

const busyCourseId = ref<number | null>(null);

const setState = (course: ManageableCourse, state: CourseState) => {
    if (course.state === state || busyCourseId.value !== null) {
        return;
    }

    busyCourseId.value = course.id;

    router.patch(
        UserController.updateCourseOverride.url({
            user: props.employee.slug,
            course: course.id,
        }),
        { state },
        {
            preserveScroll: true,
            preserveState: true,
            onFinish: () => {
                busyCourseId.value = null;
            },
        },
    );
};
</script>

<template>
    <div class="space-y-4">
        <div class="rounded-md border">
            <Table class="table-fixed">
                <TableHeader class="bg-muted">
                    <TableRow>
                        <TableHead>Course</TableHead>
                        <TableHead class="w-40">Default Rule</TableHead>
                        <TableHead class="w-64 text-right" />
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <TableRow v-for="course in manageableCourses" :key="course.id">
                        <TableCell class="truncate" :title="course.name">
                            {{ course.name }}
                        </TableCell>
                        <TableCell>
                            <span
                                v-if="course.required_for_user"
                                class="inline-flex items-center rounded-md bg-emerald-50 px-2 py-1 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/20"
                            >
                                Required
                            </span>
                            <span
                                v-else
                                class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10"
                            >
                                Optional
                            </span>
                        </TableCell>
                        <TableCell>
                            <div
                                class="ml-auto flex w-fit items-center gap-1 rounded-md border bg-background p-1"
                                role="group"
                                :aria-label="`Override for ${course.name}`"
                                :aria-busy="busyCourseId === course.id"
                            >
                                <button
                                    v-for="pill in statePills"
                                    :key="pill.key"
                                    type="button"
                                    class="rounded border border-transparent px-2.5 py-1 text-xs font-medium transition-colors disabled:opacity-60"
                                    :class="course.state === pill.key ? pill.toneActive : pill.toneInactive"
                                    :aria-pressed="course.state === pill.key"
                                    :disabled="busyCourseId !== null"
                                    @click="setState(course, pill.key)"
                                >
                                    {{ pill.label }}
                                </button>
                            </div>
                        </TableCell>
                    </TableRow>
                    <TableRow v-if="manageableCourses.length === 0">
                        <TableCell
                            :colspan="3"
                            class="py-10 text-center text-sm text-muted-foreground"
                        >
                            No courses available.
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>
    </div>
</template>
