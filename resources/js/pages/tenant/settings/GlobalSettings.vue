<script setup lang="ts">
import { computed, ref, watch } from 'vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import { useDebounceFn } from '@vueuse/core';
import { AlertTriangle, Loader2, Search } from 'lucide-vue-next';
import AppLayout from '@/layouts/tenant/AppLayout.vue';
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Separator } from '@/components/ui/separator';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import GlobalSettingsController from '@/actions/App/Http/Controllers/Tenant/Settings/GlobalSettingsController';
import settings from '@/routes/dealer/settings';
import globalSettings from '@/routes/dealer/settings/global';
import type { BreadcrumbItem } from '@/types';

type Section = 'general' | 'course-management' | 'reset-courses';

type StoreItem = {
    id: number;
    name: string;
    courses_not_taken_notification: boolean;
    remediations_active: boolean;
};

type CourseItem = {
    id: number;
    name: string;
    slug: string;
    optional: boolean;
};

type ResettableUser = {
    id: number;
    name: string;
    email: string;
    stores: string[];
    status: 'completed' | 'in-progress' | 'not-started';
};

const props = defineProps<{
    section: Section;
    stores: StoreItem[];
    courses: CourseItem[];
    users: ResettableUser[];
    search: string;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Global Settings', href: settings.global.url() },
];

const sections: { key: Section; label: string; href: string }[] = [
    { key: 'general', label: 'General', href: settings.global.url() },
    { key: 'course-management', label: 'Course Management', href: globalSettings.courseManagement.url() },
    { key: 'reset-courses', label: 'Reset Courses', href: globalSettings.resetCourses.url() },
];

// ---------- General section actions ----------

const toggleStoreNotifications = (store: StoreItem): void => {
    router.post(
        GlobalSettingsController.toggleStoreNotifications.url({ store: store.id }),
        {},
        { preserveScroll: true, preserveState: true },
    );
};

const toggleStoreRemediations = (store: StoreItem): void => {
    router.post(
        GlobalSettingsController.toggleStoreRemediations.url({ store: store.id }),
        {},
        { preserveScroll: true, preserveState: true },
    );
};

// ---------- Course Management section actions ----------

const toggleOptionalCourse = (course: CourseItem): void => {
    router.patch(
        GlobalSettingsController.toggleOptionalCourse.url({ course: course.id }),
        {},
        { preserveScroll: true, preserveState: true },
    );
};

// ---------- Reset Courses section ----------

const mode = ref<'everyone' | 'selected-users'>('everyone');
const search = ref(props.search);
const selectedUserIds = ref<number[]>([]);
const confirmOpen = ref(false);
const resetting = ref(false);

const reloadUsers = (): void => {
    router.get(globalSettings.resetCourses.url(), search.value.trim() === '' ? {} : { search: search.value.trim() }, {
        preserveScroll: true,
        preserveState: true,
        replace: true,
        only: ['users', 'search'],
    });
};

const debouncedReload = useDebounceFn(reloadUsers, 300);
watch(search, debouncedReload);

watch(
    () => props.search,
    (next) => {
        search.value = next ?? '';
    },
);

const visibleUserIds = computed<number[]>(() => props.users.map((user) => user.id));

const allVisibleSelected = computed<boolean>(() =>
    visibleUserIds.value.length > 0 &&
    visibleUserIds.value.every((id) => selectedUserIds.value.includes(id)),
);

const isUserSelected = (id: number): boolean => selectedUserIds.value.includes(id);

const toggleUser = (id: number): void => {
    if (isUserSelected(id)) {
        selectedUserIds.value = selectedUserIds.value.filter((existing) => existing !== id);
        return;
    }
    selectedUserIds.value = [...selectedUserIds.value, id];
};

const toggleSelectAllVisible = (checked: boolean): void => {
    if (checked) {
        const merged = new Set([...selectedUserIds.value, ...visibleUserIds.value]);
        selectedUserIds.value = [...merged];
        return;
    }
    selectedUserIds.value = selectedUserIds.value.filter((id) => !visibleUserIds.value.includes(id));
};

const setMode = (next: 'everyone' | 'selected-users'): void => {
    mode.value = next;
};

const requestReset = (): void => {
    if (mode.value === 'selected-users' && selectedUserIds.value.length === 0) {
        return;
    }
    confirmOpen.value = true;
};

const cancelReset = (): void => {
    confirmOpen.value = false;
};

const confirmReset = (): void => {
    resetting.value = true;
    router.post(
        GlobalSettingsController.resetCourses.url(),
        {
            mode: mode.value,
            user_ids: mode.value === 'selected-users' ? selectedUserIds.value : [],
        },
        {
            preserveScroll: true,
            onFinish: () => {
                resetting.value = false;
                confirmOpen.value = false;
            },
            onSuccess: () => {
                if (mode.value === 'selected-users') {
                    selectedUserIds.value = [];
                }
            },
        },
    );
};

const statusLabel: Record<ResettableUser['status'], string> = {
    completed: 'Completed',
    'in-progress': 'In Progress',
    'not-started': 'Not Started',
};

const statusClass: Record<ResettableUser['status'], string> = {
    completed: 'bg-green-100 text-green-700',
    'in-progress': 'bg-amber-100 text-amber-700',
    'not-started': 'bg-muted text-muted-foreground',
};

const courseLabel = (course: CourseItem): string => {
    if (course.slug === 'sexual-harassment-e') {
        return `${course.name} (Employees)`;
    }
    if (course.slug === 'sexual-harassment-m') {
        return `${course.name} (Managers)`;
    }
    return course.name;
};

const confirmMessage = computed<string>(() =>
    mode.value === 'selected-users'
        ? 'Are you sure you want to reset courses for the selected users?'
        : 'Are you sure you want to reset all employee courses?',
);
</script>

<template>
    <Head title="Global Settings" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-6 px-4 py-6">
            <Heading
                title="Global Settings"
                description="Manage dealer-wide settings and course assignments."
            />

            <div class="flex justify-center">
                <nav class="inline-flex rounded-md border bg-muted/40 p-1" aria-label="Global Settings sections">
                    <Link
                        v-for="item in sections"
                        :key="item.key"
                        :href="item.href"
                        :class="[
                            'flex whitespace-nowrap items-center justify-center rounded-md px-4 py-1.5 text-sm transition-colors',
                            section === item.key ? 'bg-background text-foreground shadow-sm' : 'text-muted-foreground hover:text-foreground',
                        ]"
                        :aria-current="section === item.key ? 'page' : undefined"
                    >
                        {{ item.label }}
                    </Link>
                </nav>
            </div>

            <!-- General -->
            <div v-if="section === 'general'" class="mx-auto max-w-4xl space-y-6">
                <div class="rounded-md border bg-card p-6">
                    <h2 class="text-base font-medium">Store Course Notifications</h2>
                    <p class="mt-1 text-sm text-muted-foreground">
                        Enable or disable notifications for courses not taken at each store.
                    </p>
                    <Separator class="my-4" />
                    <div v-if="stores.length === 0" class="py-4 text-center text-sm text-muted-foreground">
                        No stores found.
                    </div>
                    <div v-else class="divide-y divide-border">
                        <div
                            v-for="store in stores"
                            :key="`notify-${store.id}`"
                            class="flex items-center justify-between py-3"
                        >
                            <span class="text-sm font-medium">{{ store.name }}</span>
                            <Checkbox
                                :model-value="store.courses_not_taken_notification"
                                @update:model-value="() => toggleStoreNotifications(store)"
                            />
                        </div>
                    </div>
                </div>

                <div class="rounded-md border bg-card p-6">
                    <h2 class="text-base font-medium">Audit Remediations</h2>
                    <p class="mt-1 text-sm text-muted-foreground">
                        Enable or disable the ability to remediate audits for each store.
                    </p>
                    <Separator class="my-4" />
                    <div v-if="stores.length === 0" class="py-4 text-center text-sm text-muted-foreground">
                        No stores found.
                    </div>
                    <div v-else class="divide-y divide-border">
                        <div
                            v-for="store in stores"
                            :key="`remediate-${store.id}`"
                            class="flex items-center justify-between py-3"
                        >
                            <span class="text-sm font-medium">{{ store.name }}</span>
                            <Checkbox
                                :model-value="store.remediations_active"
                                @update:model-value="() => toggleStoreRemediations(store)"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Course Management -->
            <div v-else-if="section === 'course-management'" class="mx-auto max-w-3xl space-y-4">
                <div class="rounded-md border bg-card p-6">
                    <p class="text-sm font-semibold">
                        Check off any course you would like to make optional in the dealership. You can always assign a
                        course to a specific employee.
                    </p>
                    <Separator class="my-4" />
                    <div class="space-y-2">
                        <label
                            v-for="course in courses"
                            :key="course.id"
                            class="flex cursor-pointer items-center gap-3"
                        >
                            <Checkbox
                                :model-value="course.optional"
                                @update:model-value="() => toggleOptionalCourse(course)"
                            />
                            <span class="text-sm">{{ courseLabel(course) }}</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Reset Courses -->
            <div v-else-if="section === 'reset-courses'" class="mx-auto max-w-5xl space-y-5">
                <div>
                    <h2 class="text-base font-semibold">Reset Courses</h2>
                    <p class="mt-1 text-sm text-muted-foreground">
                        Manage course progress resets. Choose to reset progress for everyone or target specific
                        individuals.
                    </p>
                </div>

                <div class="inline-flex h-10 rounded-md border bg-muted/40 p-1">
                    <button
                        type="button"
                        :class="[
                            'rounded-md px-6 text-sm font-medium transition-colors',
                            mode === 'everyone' ? 'bg-background text-foreground shadow-sm' : 'text-muted-foreground hover:text-foreground',
                        ]"
                        @click="setMode('everyone')"
                    >
                        Everyone
                    </button>
                    <button
                        type="button"
                        :class="[
                            'rounded-md px-6 text-sm font-medium transition-colors',
                            mode === 'selected-users' ? 'bg-background text-foreground shadow-sm' : 'text-muted-foreground hover:text-foreground',
                        ]"
                        @click="setMode('selected-users')"
                    >
                        Select Users
                    </button>
                </div>

                <div class="overflow-hidden rounded-md border bg-card">
                    <div v-if="mode === 'everyone'" class="px-5 py-6 text-sm text-muted-foreground">
                        This action will reset course progress for all employees across all locations.
                    </div>
                    <template v-else>
                        <div class="flex flex-col gap-3 border-b px-5 py-4 md:flex-row md:items-center md:justify-between">
                            <div class="relative w-full max-w-md">
                                <Search class="pointer-events-none absolute left-3 top-1/2 size-4 -translate-y-1/2 text-muted-foreground" />
                                <Input
                                    v-model="search"
                                    type="search"
                                    placeholder="Search by name, email or store..."
                                    class="pl-9"
                                />
                            </div>
                            <div class="inline-flex items-center rounded-md bg-muted px-3 py-2 text-sm font-medium">
                                {{ selectedUserIds.length }} selected
                            </div>
                        </div>

                        <div class="max-h-105 overflow-y-auto">
                            <Table>
                                <TableHeader class="sticky top-0 bg-muted/50 [&_tr]:border-b">
                                    <TableRow>
                                        <TableHead class="w-14">
                                            <Checkbox
                                                :model-value="allVisibleSelected"
                                                @update:model-value="(value) => toggleSelectAllVisible(value === true)"
                                            />
                                        </TableHead>
                                        <TableHead>User</TableHead>
                                        <TableHead>Store(s)</TableHead>
                                        <TableHead>Status</TableHead>
                                    </TableRow>
                                </TableHeader>
                                <TableBody>
                                    <template v-if="users.length > 0">
                                        <TableRow
                                            v-for="user in users"
                                            :key="user.id"
                                            :class="[
                                                'cursor-pointer transition-colors',
                                                isUserSelected(user.id) ? 'bg-primary/5' : 'hover:bg-muted/30',
                                            ]"
                                            @click="toggleUser(user.id)"
                                        >
                                            <TableCell @click.stop>
                                                <Checkbox
                                                    :model-value="isUserSelected(user.id)"
                                                    @update:model-value="() => toggleUser(user.id)"
                                                />
                                            </TableCell>
                                            <TableCell>
                                                <p class="truncate text-sm font-medium capitalize">{{ user.name }}</p>
                                                <p class="truncate text-xs text-muted-foreground">{{ user.email.toLowerCase() }}</p>
                                            </TableCell>
                                            <TableCell class="text-sm text-muted-foreground">
                                                {{ user.stores.length > 0 ? user.stores.join(', ') : 'No store assigned' }}
                                            </TableCell>
                                            <TableCell>
                                                <span
                                                    :class="['inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium', statusClass[user.status]]"
                                                >
                                                    {{ statusLabel[user.status] }}
                                                </span>
                                            </TableCell>
                                        </TableRow>
                                    </template>
                                    <TableRow v-else>
                                        <TableCell colspan="4" class="py-8 text-center text-sm text-muted-foreground">
                                            No users match your search.
                                        </TableCell>
                                    </TableRow>
                                </TableBody>
                            </Table>
                        </div>
                    </template>
                </div>

                <div class="flex flex-col gap-3 border-t pt-4 md:flex-row md:items-center md:justify-between">
                    <div class="flex items-start gap-2 text-sm text-amber-700">
                        <AlertTriangle class="mt-0.5 size-4 shrink-0" />
                        <p>
                            <span class="font-semibold">Permanent action.</span>
                            Resetting courses removes all progress data for the selected participants.
                        </p>
                    </div>
                    <Button
                        variant="destructive"
                        :disabled="resetting || (mode === 'selected-users' && selectedUserIds.length === 0)"
                        @click="requestReset"
                    >
                        <Loader2 v-if="resetting" class="size-3.5 animate-spin" />
                        {{ mode === 'selected-users' ? 'Reset Selected Courses' : 'Reset All Courses' }}
                    </Button>
                </div>
            </div>

        </div>

        <Dialog v-model:open="confirmOpen">
            <DialogContent>
                <DialogHeader>
                    <DialogTitle>Reset courses</DialogTitle>
                    <DialogDescription>{{ confirmMessage }}</DialogDescription>
                </DialogHeader>
                <DialogFooter>
                    <Button type="button" variant="outline" :disabled="resetting" @click="cancelReset">Cancel</Button>
                    <Button variant="destructive" :disabled="resetting" @click="confirmReset">
                        <Loader2 v-if="resetting" class="size-3.5 animate-spin" />
                        Confirm reset
                    </Button>
                </DialogFooter>
            </DialogContent>
        </Dialog>
    </AppLayout>
</template>
