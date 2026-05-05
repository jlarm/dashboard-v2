<script setup lang="ts">
import { computed } from "vue";
import { useForm } from "@inertiajs/vue3";
import { Button } from "@/components/ui/button";
import { Field, FieldDescription, FieldError, FieldLabel } from "@/components/ui/field";
import { Loader2 } from "lucide-vue-next";
import MultiSelect from "@/components/MultiSelect.vue";
import courseManagementRoutes from "@/routes/course-management";

type IntOption = { value: number; label: string };
type StringOption = { value: string; label: string };

const props = defineProps<{
    slug: string;
    departmentIds: number[];
    roleIds: number[];
    statesRequired: string[];
    replacesCourseSlugs: string[];
    tenantIds: string[];
    options: {
        departments: IntOption[];
        roles: IntOption[];
        states: StringOption[];
        courses: StringOption[];
        tenants: StringOption[];
    };
}>();

const form = useForm({
    department_ids: [...props.departmentIds],
    role_ids: [...props.roleIds],
    states_required: [...props.statesRequired],
    replaces_course_slugs: [...props.replacesCourseSlugs],
    tenant_ids: [...props.tenantIds],
});

const hasStatesSelected = computed(() => form.states_required.length > 0);

const submit = (): void => {
    if (!hasStatesSelected.value) {
        form.replaces_course_slugs = [];
    }

    form.patch(courseManagementRoutes.updateSettings(props.slug).url, {
        preserveScroll: true,
    });
};
</script>

<template>
    <form class="space-y-6" @submit.prevent="submit">
        <Field>
            <FieldLabel>Departments</FieldLabel>
            <MultiSelect
                v-model="form.department_ids"
                :options="options.departments"
                placeholder="Select departments..."
            />
            <FieldDescription>
                Departments this course applies to.
            </FieldDescription>
            <FieldError v-if="form.errors.department_ids">{{ form.errors.department_ids }}</FieldError>
        </Field>

        <Field>
            <FieldLabel>Roles</FieldLabel>
            <MultiSelect
                v-model="form.role_ids"
                :options="options.roles"
                placeholder="Select roles..."
            />
            <FieldDescription>
                Roles that are assigned this course.
            </FieldDescription>
            <FieldError v-if="form.errors.role_ids">{{ form.errors.role_ids }}</FieldError>
        </Field>

        <Field>
            <FieldLabel>States required</FieldLabel>
            <MultiSelect
                v-model="form.states_required"
                :options="options.states"
                placeholder="Select states..."
                search-placeholder="Search states..."
            />
            <FieldDescription>
                Restrict this course to specific states. Leave empty to apply everywhere.
            </FieldDescription>
            <FieldError v-if="form.errors.states_required">{{ form.errors.states_required }}</FieldError>
        </Field>

        <Field v-if="hasStatesSelected">
            <FieldLabel>Replaces course</FieldLabel>
            <MultiSelect
                v-model="form.replaces_course_slugs"
                :options="options.courses"
                placeholder="Select courses this replaces..."
                search-placeholder="Search courses..."
            />
            <FieldDescription>
                Employees in the selected states will complete this course instead of the replaced one(s).
            </FieldDescription>
            <FieldError v-if="form.errors.replaces_course_slugs">{{ form.errors.replaces_course_slugs }}</FieldError>
        </Field>

        <Field>
            <FieldLabel>Assigned tenants</FieldLabel>
            <MultiSelect
                v-model="form.tenant_ids"
                :options="options.tenants"
                placeholder="Select tenants..."
                search-placeholder="Search tenants..."
            />
            <FieldDescription>
                Restrict this course to specific tenants. Leave empty to make it available to all tenants.
            </FieldDescription>
            <FieldError v-if="form.errors.tenant_ids">{{ form.errors.tenant_ids }}</FieldError>
        </Field>

        <div class="flex justify-end">
            <Button type="submit" :disabled="form.processing">
                <Loader2 v-if="form.processing" class="animate-spin" />
                Save Settings
            </Button>
        </div>
    </form>
</template>
