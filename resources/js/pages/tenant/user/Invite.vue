<script setup lang="ts">
import DatePicker from '@/components/DatePicker.vue';
import MultiSelect from '@/components/MultiSelect.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import AppLayout from '@/layouts/tenant/AppLayout.vue';
import ImportEmployeesDialog from '@/pages/tenant/user/components/ImportEmployeesDialog.vue';
import SubNavigation from '@/pages/tenant/user/components/SubNavigation.vue';
import employees from '@/routes/dealer/employees';
import type { BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

type Option = { id: number; name: string };
type RoleOption = { name: string };

const props = defineProps<{
    options: {
        departments: Option[];
        roles: RoleOption[];
        courses: Option[];
        stores: Option[];
    };
    defaults: {
        department_id: number | null;
        role: string | null;
    };
}>();

const breadcrumbs = computed<BreadcrumbItem[]>(() => [
    { title: 'Employees', href: employees.index.url() },
    { title: 'Invite Employee', href: employees.invite.url() },
]);

const form = useForm<{
    name: string;
    email: string;
    department_id: number | null;
    role: string | null;
    qualified_individual: boolean;
    store_ids: number[];
    primary_store_id: number | null;
    courses: Record<string, string | null>;
}>({
    name: '',
    email: '',
    department_id: props.defaults.department_id,
    role: props.defaults.role,
    qualified_individual: false,
    store_ids: props.options.stores.length === 1 ? [props.options.stores[0].id] : [],
    primary_store_id: null,
    courses: {},
});

const importDialogOpen = ref(false);
const showCourses = ref(false);

const storeOptions = computed(() =>
    props.options.stores.map((store) => ({ value: store.id, label: store.name })),
);

const showStoreSelector = computed(() => props.options.stores.length > 1);
const requiresPrimary = computed(() => form.store_ids.length > 1);

const setStoreIds = (ids: number[]) => {
    form.store_ids = ids;
    if (!ids.includes(form.primary_store_id ?? -1)) {
        form.primary_store_id = null;
    }
};

const primaryCandidates = computed(() =>
    props.options.stores.filter((store) => form.store_ids.includes(store.id)),
);

const submit = () => {
    form.transform((data) => {
        const courses: Record<string, string> = {};
        for (const [id, value] of Object.entries(data.courses)) {
            if (value) {
                courses[id] = value;
            }
        }

        return {
            ...data,
            courses,
            primary_store_id: requiresPrimary.value ? data.primary_store_id : null,
        };
    }).post(employees.invite.store.url(), {
        preserveScroll: true,
    });
};
</script>

<template>
    <Head title="Invite Employee" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <template #actions>
            <SubNavigation @import="importDialogOpen = true" />
        </template>

        <ImportEmployeesDialog v-model:open="importDialogOpen" />

        <form class="mx-auto max-w-4xl space-y-8" @submit.prevent="submit">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div class="space-y-2">
                    <Label for="name">Employee name</Label>
                    <Input id="name" v-model="form.name" required autocomplete="off" />
                    <p v-if="form.errors.name" class="text-sm text-red-600">{{ form.errors.name }}</p>
                </div>

                <div class="space-y-2">
                    <Label for="email">Employee email</Label>
                    <Input id="email" v-model="form.email" type="email" required autocomplete="off" />
                    <p v-if="form.errors.email" class="text-sm text-red-600">{{ form.errors.email }}</p>
                </div>
            </div>

            <div v-if="showStoreSelector" class="space-y-4">
                <div class="space-y-2">
                    <Label>Select store(s)</Label>
                    <MultiSelect
                        :model-value="form.store_ids"
                        :options="storeOptions"
                        placeholder="Choose one or more stores"
                        search-placeholder="Search stores..."
                        @update:model-value="setStoreIds"
                    />
                    <p v-if="form.errors.store_ids" class="text-sm text-red-600">
                        {{ form.errors.store_ids }}
                    </p>
                </div>

                <div v-if="requiresPrimary" class="space-y-2">
                    <Label for="primary_store_id">Primary store</Label>
                    <Select
                        :model-value="form.primary_store_id === null ? '' : String(form.primary_store_id)"
                        @update:model-value="(value) => (form.primary_store_id = value ? Number(value) : null)"
                    >
                        <SelectTrigger id="primary_store_id" class="w-full">
                            <SelectValue placeholder="Choose a primary store..." />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem
                                v-for="store in primaryCandidates"
                                :key="store.id"
                                :value="String(store.id)"
                            >
                                {{ store.name }}
                            </SelectItem>
                        </SelectContent>
                    </Select>
                    <p v-if="form.errors.primary_store_id" class="text-sm text-red-600">
                        {{ form.errors.primary_store_id }}
                    </p>
                </div>
            </div>

            <div class="space-y-2">
                <Label for="department_id">Department</Label>
                <Select
                    :model-value="form.department_id === null ? '' : String(form.department_id)"
                    @update:model-value="(value) => (form.department_id = value ? Number(value) : null)"
                >
                    <SelectTrigger id="department_id" class="w-full">
                        <SelectValue placeholder="Select a department" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectItem
                            v-for="department in options.departments"
                            :key="department.id"
                            :value="String(department.id)"
                        >
                            {{ department.name }}
                        </SelectItem>
                    </SelectContent>
                </Select>
                <p v-if="form.errors.department_id" class="text-sm text-red-600">
                    {{ form.errors.department_id }}
                </p>
            </div>

            <div class="space-y-2">
                <Label for="role">Role</Label>
                <Select
                    :model-value="form.role ?? ''"
                    @update:model-value="(value) => (form.role = value ? String(value) : null)"
                >
                    <SelectTrigger id="role" class="w-full">
                        <SelectValue placeholder="Select a role" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectItem
                            v-for="role in options.roles"
                            :key="role.name"
                            :value="role.name"
                        >
                            {{ role.name }}
                        </SelectItem>
                    </SelectContent>
                </Select>
                <p v-if="form.errors.role" class="text-sm text-red-600">{{ form.errors.role }}</p>
            </div>

            <label class="flex cursor-pointer items-start gap-3 rounded-md border border-blue-200 bg-blue-50/50 p-3 transition-colors hover:bg-blue-50">
                <Checkbox
                    :model-value="form.qualified_individual"
                    class="mt-0.5"
                    @update:model-value="(value) => (form.qualified_individual = value === true)"
                />
                <span class="flex-1">
                    <span class="block text-sm font-medium">This employee is a Qualified Individual</span>
                    <span class="block text-xs text-muted-foreground">
                        Qualified Individuals can manage compliance for their department.
                    </span>
                </span>
            </label>

            <div class="space-y-3">
                <label class="flex cursor-pointer items-center gap-3 rounded-md bg-muted/40 p-3">
                    <Checkbox
                        :model-value="showCourses"
                        @update:model-value="(value) => (showCourses = value === true)"
                    />
                    <span class="text-sm font-medium">Add previously completed courses</span>
                </label>

                <div v-if="showCourses" class="space-y-4 rounded-md border p-4">
                    <p class="text-sm text-muted-foreground">
                        Add completed courses that are still valid.
                    </p>
                    <div
                        v-for="course in options.courses"
                        :key="course.id"
                        class="space-y-1"
                    >
                        <Label :for="`course-${course.id}`">{{ course.name }}</Label>
                        <DatePicker
                            :id="`course-${course.id}`"
                            :model-value="form.courses[course.id] ?? null"
                            placeholder="Training date"
                            @update:model-value="(value) => (form.courses[course.id] = value)"
                        />
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-2">
                <Button type="button" variant="outline" :disabled="form.processing" :as-child="true">
                    <a :href="employees.index.url()">Cancel</a>
                </Button>
                <Button type="submit" :disabled="form.processing">
                    {{ form.processing ? 'Sending...' : 'Send invite' }}
                </Button>
            </div>
        </form>
    </AppLayout>
</template>
