<script setup lang="ts">
import UserController from '@/actions/App/Http/Controllers/Tenant/UserController';
import DatePicker from '@/components/DatePicker.vue';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import { Label } from '@/components/ui/label';
import EmployeeShowLayout from '@/pages/tenant/user/components/EmployeeShowLayout.vue';
import type { EmployeeShowProps } from '@/pages/tenant/user/components/types';
import { setLayoutProps, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

type CourseStatus = 'never' | 'passed' | 'failed' | 'expired';

type Course = {
    id: number;
    name: string;
    slug: string;
    last_taken_at: string | null;
    status: CourseStatus;
    status_label: string;
    percentage: number | null;
};

defineOptions({ layout: EmployeeShowLayout });

const props = defineProps<
    EmployeeShowProps & {
        courses: Course[];
        canRecordCourseResult: boolean;
    }
>();

setLayoutProps<{ activeTab: 'courses' }>({ activeTab: 'courses' });

const statusClass = (status: CourseStatus): string => {
    switch (status) {
        case 'passed':
            return 'bg-green-50 text-green-700 ring-green-600/20';
        case 'failed':
            return 'bg-red-50 text-red-700 ring-red-600/10';
        case 'expired':
            return 'bg-yellow-50 text-orange-700 ring-orange-600/10';
        default:
            return '';
    }
};

const recordOpen = ref(false);
const activeCourse = ref<Course | null>(null);

const todayIso = (): string => new Date().toISOString().slice(0, 10);

const form = useForm({ taken_on: todayIso() });

const openRecordDialog = (course: Course) => {
    activeCourse.value = course;
    form.reset();
    form.clearErrors();
    form.taken_on = todayIso();
    recordOpen.value = true;
};

const submitRecord = () => {
    if (!activeCourse.value) {
        return;
    }

    form.post(
        UserController.recordCourseResult.url({
            user: props.employee.slug,
            course: activeCourse.value.id,
        }),
        {
            preserveScroll: true,
            onSuccess: () => {
                recordOpen.value = false;
                activeCourse.value = null;
            },
        },
    );
};
</script>

<template>
    <div class="overflow-hidden rounded-md border bg-card">
        <table class="min-w-full divide-y divide-border">
            <thead class="bg-muted/50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-semibold tracking-wide text-muted-foreground uppercase">Name</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold tracking-wide text-muted-foreground uppercase">Last Taken</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold tracking-wide text-muted-foreground uppercase">Status</th>
                    <th class="px-4 py-2" />
                </tr>
            </thead>
            <tbody class="divide-y divide-border">
                <tr v-for="course in courses" :key="course.id">
                    <td class="px-4 py-2 text-sm">{{ course.name }}</td>
                    <td class="px-4 py-2 text-sm text-muted-foreground">
                        {{ course.last_taken_at ?? 'Never' }}
                    </td>
                    <td class="px-4 py-2 text-sm">
                        <span v-if="course.status === 'never'" class="text-muted-foreground">—</span>
                        <span
                            v-else
                            :class="`inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset ${statusClass(course.status)}`"
                        >
                            {{ course.status_label }}
                        </span>
                    </td>
                    <td class="px-4 py-2 text-right text-sm">
                        <button
                            v-if="canRecordCourseResult && course.status === 'never'"
                            type="button"
                            class="font-medium text-primary hover:underline"
                            @click="openRecordDialog(course)"
                        >
                            Edit
                        </button>
                    </td>
                </tr>
                <tr v-if="courses.length === 0">
                    <td colspan="4" class="px-4 py-10 text-center text-sm text-muted-foreground">
                        No required courses for this employee.
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <Dialog v-model:open="recordOpen">
        <DialogContent class="sm:max-w-md">
            <DialogHeader>
                <DialogTitle>{{ activeCourse?.name ?? 'Record course' }}</DialogTitle>
                <DialogDescription>
                    If the employee has previously taken this course, enter the date it was completed.
                </DialogDescription>
            </DialogHeader>

            <form class="space-y-4" @submit.prevent="submitRecord">
                <div class="space-y-2">
                    <Label for="taken_on">Date completed</Label>
                    <DatePicker
                        id="taken_on"
                        :model-value="form.taken_on"
                        :max-value="todayIso()"
                        placeholder="Pick a date"
                        @update:model-value="(value) => (form.taken_on = value ?? '')"
                    />
                    <p v-if="form.errors.taken_on" class="text-sm text-red-600">
                        {{ form.errors.taken_on }}
                    </p>
                </div>

                <DialogFooter>
                    <Button type="button" variant="outline" :disabled="form.processing" @click="recordOpen = false">
                        Cancel
                    </Button>
                    <Button type="submit" :disabled="form.processing || !form.taken_on">
                        {{ form.processing ? 'Saving...' : 'Update' }}
                    </Button>
                </DialogFooter>
            </form>
        </DialogContent>
    </Dialog>
</template>
