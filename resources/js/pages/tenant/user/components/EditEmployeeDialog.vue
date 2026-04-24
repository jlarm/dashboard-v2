<script setup lang="ts">
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
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import UserController from '@/actions/App/Http/Controllers/Tenant/UserController';
import type { Employee } from '@/pages/tenant/user/components/columns';
import { useForm } from '@inertiajs/vue3';
import { watch } from 'vue';

type StoreOption = { id: number; name: string };
type Option = { id: number; name: string };
type AuditOption = { value: string; label: string };

const props = defineProps<{
    employee: Employee;
    departments: Option[];
    roles: Option[];
    stores: StoreOption[] | null;
    auditTypes: AuditOption[];
    remediationReminders: string[];
}>();

const open = defineModel<boolean>('open', { required: true });

const currentPrimaryRoleId = (): number | null => {
    const match = props.employee.roles.find((role) =>
        props.roles.some((option) => option.id === role.id),
    );
    return match ? match.id : null;
};

const initialDepartmentId = (): number | null => {
    if (!props.employee.department_name) {
        return null;
    }

    return props.departments.find((d) => d.name === props.employee.department_name)?.id ?? null;
};

const form = useForm({
    department_id: initialDepartmentId(),
    role_id: currentPrimaryRoleId(),
    qualified_individual: props.employee.has_qualified_individual_role,
    store_ids: props.employee.stores.map((store) => store.id),
    audit_types: [...props.remediationReminders],
});

watch(open, (isOpen) => {
    if (isOpen) {
        form.reset();
        form.clearErrors();
    }
});

const toggleStore = (id: number) => {
    form.store_ids = form.store_ids.includes(id)
        ? form.store_ids.filter((value) => value !== id)
        : [...form.store_ids, id];
};

const toggleAuditType = (value: string) => {
    form.audit_types = form.audit_types.includes(value)
        ? form.audit_types.filter((v) => v !== value)
        : [...form.audit_types, value];
};

const submit = () => {
    form.patch(UserController.update.url({ slug: props.employee.slug }), {
        preserveScroll: true,
        onSuccess: () => {
            open.value = false;
        },
    });
};
</script>

<template>
    <Dialog v-model:open="open">
        <DialogContent class="sm:max-w-lg">
            <DialogHeader>
                <DialogTitle>Edit {{ employee.name }}</DialogTitle>
                <DialogDescription>
                    Update locations, department, role, and remediation reminder preferences.
                </DialogDescription>
            </DialogHeader>

            <form class="space-y-5" @submit.prevent="submit">
                <div v-if="stores" class="space-y-2">
                    <Label>Select Location(s)</Label>
                    <div class="space-y-2">
                        <label
                            v-for="store in stores"
                            :key="store.id"
                            class="flex cursor-pointer items-center gap-2 text-sm"
                        >
                            <Checkbox
                                :model-value="form.store_ids.includes(store.id)"
                                @update:model-value="() => toggleStore(store.id)"
                            />
                            <span>{{ store.name }}</span>
                        </label>
                    </div>
                    <p v-if="form.errors.store_ids" class="text-sm text-red-600">
                        {{ form.errors.store_ids }}
                    </p>
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
                                v-for="department in departments"
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
                    <Label for="role_id">Role</Label>
                    <Select
                        :model-value="form.role_id === null ? '' : String(form.role_id)"
                        @update:model-value="(value) => (form.role_id = value ? Number(value) : null)"
                    >
                        <SelectTrigger id="role_id" class="w-full">
                            <SelectValue placeholder="Select a role" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem
                                v-for="role in roles"
                                :key="role.id"
                                :value="String(role.id)"
                            >
                                {{ role.name }}
                            </SelectItem>
                        </SelectContent>
                    </Select>
                    <p v-if="form.errors.role_id" class="text-sm text-red-600">
                        {{ form.errors.role_id }}
                    </p>
                </div>

                <label
                    class="flex cursor-pointer items-start gap-3 rounded-md border border-blue-200 bg-blue-50/50 p-3 transition-colors hover:bg-blue-50"
                >
                    <Checkbox
                        :model-value="form.qualified_individual"
                        class="mt-0.5"
                        @update:model-value="(value) => (form.qualified_individual = value === true)"
                    />
                    <span class="flex-1">
                        <span class="block text-sm font-medium">Qualified Individual</span>
                        <span class="block text-xs text-muted-foreground">
                            Designates this employee as the qualified compliance contact for their department.
                        </span>
                    </span>
                </label>

                <div v-if="auditTypes.length > 0" class="space-y-2">
                    <Label>Remediation Reminders</Label>
                    <div class="divide-y rounded-md border">
                        <label
                            v-for="audit in auditTypes"
                            :key="audit.value"
                            class="flex cursor-pointer items-center gap-3 px-3 py-2.5 text-sm"
                        >
                            <Checkbox
                                :model-value="form.audit_types.includes(audit.value)"
                                @update:model-value="() => toggleAuditType(audit.value)"
                            />
                            <span>{{ audit.label }}</span>
                        </label>
                    </div>
                </div>

                <DialogFooter>
                    <Button type="button" variant="outline" :disabled="form.processing" @click="open = false">
                        Cancel
                    </Button>
                    <Button
                        type="submit"
                        :disabled="form.processing || form.role_id === null || form.department_id === null"
                    >
                        {{ form.processing ? 'Saving...' : 'Save changes' }}
                    </Button>
                </DialogFooter>
            </form>
        </DialogContent>
    </Dialog>
</template>
