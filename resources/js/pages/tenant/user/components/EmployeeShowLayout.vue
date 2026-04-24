<script setup lang="ts">
import EditEmployeeDialog from '@/pages/tenant/user/components/EditEmployeeDialog.vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import AppLayout from '@/layouts/tenant/AppLayout.vue';
import type { Employee } from '@/pages/tenant/user/components/columns';
import UserController from '@/actions/App/Http/Controllers/Tenant/UserController';
import employeesRoutes from '@/routes/dealer/employees';
import type { BreadcrumbItem } from '@/types';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { ArrowLeft, LogIn, MoreVertical, Pencil, Trash2 } from 'lucide-vue-next';
import { computed, ref } from 'vue';

type Permissions = {
    update: boolean;
    delete: boolean;
    impersonate: boolean;
    manage_courses: boolean;
};

type EditOptions = {
    departments: Array<{ id: number; name: string }>;
    roles: Array<{ id: number; name: string }>;
    stores: Array<{ id: number; name: string }> | null;
    audit_types: Array<{ value: string; label: string }>;
};

type PageProps = {
    employee: Employee;
    permissions: Permissions;
    editOptions: EditOptions | null;
    remediationReminders: string[];
};

defineProps<{
    activeTab: 'overview' | 'courses' | 'manage-courses' | 'dot-certificates';
}>();

const page = usePage<PageProps>();
const employee = computed(() => page.props.employee);
const permissions = computed(() => page.props.permissions);
const editOptions = computed(() => page.props.editOptions);
const remediationReminders = computed(() => page.props.remediationReminders ?? []);

const breadcrumbs = computed<BreadcrumbItem[]>(() => [
    { title: 'Employees', href: employeesRoutes.index.url() },
    { title: employee.value.name, href: UserController.show.url({ slug: employee.value.slug }) },
]);

const statusBadgeClass = computed(() => {
    switch (employee.value.training.status) {
        case 'compliant':
            return 'bg-green-100 text-green-700';
        case 'overdue':
            return 'bg-red-100 text-red-700';
        case 'at_risk':
            return 'bg-amber-100 text-amber-700';
        default:
            return 'bg-gray-100 text-gray-700';
    }
});

type TabKey = 'overview' | 'courses' | 'manage-courses' | 'dot-certificates';

type Tab = {
    key: TabKey;
    label: string;
    href: string;
    show: boolean;
};

const tabs = computed<Tab[]>(() => [
    {
        key: 'overview',
        label: 'Overview',
        href: UserController.show.url({ slug: employee.value.slug }),
        show: true,
    },
    {
        key: 'courses',
        label: 'Courses',
        href: UserController.courses.url({ slug: employee.value.slug }),
        show: true,
    },
    {
        key: 'manage-courses',
        label: 'Manage Courses',
        href: UserController.manageCourses.url({ slug: employee.value.slug }),
        show: permissions.value.manage_courses,
    },
    {
        key: 'dot-certificates',
        label: 'DOT Certificates',
        href: UserController.dotCertificates.url({ slug: employee.value.slug }),
        show: true,
    },
]);

const editOpen = ref(false);
const deleteOpen = ref(false);
const isDestroying = ref(false);
const isImpersonating = ref(false);

const confirmDelete = () => {
    isDestroying.value = true;
    router.delete(UserController.destroy.url({ slug: employee.value.slug }), {
        preserveScroll: true,
        onFinish: () => {
            isDestroying.value = false;
            deleteOpen.value = false;
        },
    });
};

const impersonate = () => {
    isImpersonating.value = true;
    router.post(
        UserController.impersonate.url({ slug: employee.value.slug }),
        {},
        {
            onFinish: () => {
                isImpersonating.value = false;
            },
        },
    );
};
</script>

<template>
    <Head :title="employee.name" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-6">
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div class="flex items-center gap-3">
                    <Link
                        :href="employeesRoutes.index.url()"
                        class="inline-flex size-8 items-center justify-center rounded-md border text-muted-foreground hover:bg-muted hover:text-foreground"
                        aria-label="Back to employees"
                    >
                        <ArrowLeft class="size-4" />
                    </Link>
                    <div>
                        <div class="flex items-center gap-2">
                            <h1 class="text-2xl font-semibold tracking-tight">{{ employee.name }}</h1>
                            <span
                                v-if="employee.has_qualified_individual_role"
                                class="shrink-0 rounded bg-emerald-50 px-1.5 py-0.5 text-[10px] font-semibold uppercase tracking-wide text-emerald-700 ring-1 ring-inset ring-emerald-600/20"
                                title="Qualified Individual"
                                aria-label="Qualified Individual"
                            >
                                QI
                            </span>
                        </div>
                        <p class="text-sm text-muted-foreground">{{ employee.email }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <Badge
                        variant="secondary"
                        :class="`w-fit border-0 px-2 py-1 text-xs font-medium ${statusBadgeClass}`"
                    >
                        {{ employee.training.status_label }}
                    </Badge>

                    <DropdownMenu v-if="permissions.update || permissions.delete || permissions.impersonate">
                        <DropdownMenuTrigger as-child>
                            <Button variant="outline" size="icon" aria-label="Actions">
                                <MoreVertical class="size-4" />
                            </Button>
                        </DropdownMenuTrigger>
                        <DropdownMenuContent align="end" class="w-48">
                            <DropdownMenuItem v-if="permissions.update" @select="editOpen = true">
                                <Pencil class="mr-2 size-4" />
                                Edit details
                            </DropdownMenuItem>
                            <DropdownMenuItem
                                v-if="permissions.impersonate"
                                :disabled="isImpersonating"
                                @select="impersonate"
                            >
                                <LogIn class="mr-2 size-4" />
                                Impersonate
                            </DropdownMenuItem>
                            <DropdownMenuSeparator v-if="permissions.delete" />
                            <DropdownMenuItem
                                v-if="permissions.delete"
                                class="text-red-600 focus:bg-red-50 focus:text-red-700"
                                @select="deleteOpen = true"
                            >
                                <Trash2 class="mr-2 size-4" />
                                Delete
                            </DropdownMenuItem>
                        </DropdownMenuContent>
                    </DropdownMenu>
                </div>
            </div>

            <nav class="flex items-center gap-1 border-b" aria-label="Employee sections">
                <Link
                    v-for="tab in tabs.filter((t) => t.show)"
                    :key="tab.key"
                    :href="tab.href"
                    prefetch
                    preserve-scroll
                    :class="[
                        'inline-flex items-center border-b-2 px-3 py-2 text-sm font-medium',
                        tab.key === activeTab
                            ? 'border-primary text-foreground'
                            : 'border-transparent text-muted-foreground hover:border-muted-foreground/50 hover:text-foreground',
                    ]"
                >
                    {{ tab.label }}
                </Link>
            </nav>

            <slot />
        </div>

        <EditEmployeeDialog
            v-if="permissions.update && editOptions"
            v-model:open="editOpen"
            :employee="employee"
            :departments="editOptions.departments"
            :roles="editOptions.roles"
            :stores="editOptions.stores"
            :audit-types="editOptions.audit_types"
            :remediation-reminders="remediationReminders"
        />

        <Dialog v-model:open="deleteOpen">
            <DialogContent>
                <DialogHeader>
                    <DialogTitle>Delete {{ employee.name }}?</DialogTitle>
                    <DialogDescription>
                        This will soft-delete the employee. Their records stay in the system and an admin can restore them later.
                    </DialogDescription>
                </DialogHeader>
                <DialogFooter>
                    <Button variant="outline" :disabled="isDestroying" @click="deleteOpen = false">
                        Cancel
                    </Button>
                    <Button variant="destructive" :disabled="isDestroying" @click="confirmDelete">
                        {{ isDestroying ? 'Deleting...' : 'Delete employee' }}
                    </Button>
                </DialogFooter>
            </DialogContent>
        </Dialog>
    </AppLayout>
</template>
