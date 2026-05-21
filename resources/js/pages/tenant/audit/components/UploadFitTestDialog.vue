<script setup lang="ts">
import { computed, ref } from 'vue';
import { Form } from '@inertiajs/vue3';
import { Loader2 } from 'lucide-vue-next';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';
import { Button } from '@/components/ui/button';
import { Field, FieldError, FieldLabel } from '@/components/ui/field';
import { FileUpload } from '@/components/ui/file-upload';
import { Input } from '@/components/ui/input';
import FitTestController from '@/actions/App/Http/Controllers/Tenant/Audit/FitTestController';

type Employee = {
    id: number;
    name: string;
};

const props = defineProps<{
    employees: Employee[];
}>();

const open = ref(false);
const query = ref('');
const selectedId = ref<number | null>(null);
const showDropdown = ref(false);

const matches = computed<Employee[]>(() => {
    const term = query.value.trim().toLowerCase();
    if (term === '') {
        return [];
    }
    return props.employees
        .filter((employee) => employee.name.toLowerCase().includes(term))
        .slice(0, 10);
});

const resetState = (): void => {
    query.value = '';
    selectedId.value = null;
    showDropdown.value = false;
};

const onInput = (): void => {
    selectedId.value = null;
    showDropdown.value = true;
};

const selectEmployee = (employee: Employee): void => {
    selectedId.value = employee.id;
    query.value = employee.name;
    showDropdown.value = false;
};

const onBlur = (): void => {
    window.setTimeout(() => {
        showDropdown.value = false;
    }, 120);
};

const handleSuccess = (): void => {
    open.value = false;
    resetState();
};
</script>

<template>
    <Dialog v-model:open="open" @update:open="(value) => !value && resetState()">
        <DialogTrigger as-child>
            <Button size="sm">Upload Fit Test</Button>
        </DialogTrigger>
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Upload Fit Test</DialogTitle>
            </DialogHeader>
            <Form
                v-slot="{ errors, processing }"
                :action="FitTestController.store()"
                enctype="multipart/form-data"
                reset-on-success
                class="space-y-5"
                @success="handleSuccess"
            >
                <input type="hidden" name="user_id" :value="selectedId ?? ''" />

                <Field>
                    <FieldLabel for="employee">Employee *</FieldLabel>
                    <div class="relative">
                        <Input
                            id="employee"
                            v-model="query"
                            type="text"
                            autocomplete="off"
                            placeholder="Search employees..."
                            @input="onInput"
                            @focus="showDropdown = true"
                            @blur="onBlur"
                        />
                        <div
                            v-if="showDropdown && query.trim() !== ''"
                            class="absolute z-50 mt-1 max-h-48 w-full overflow-y-auto rounded-md border bg-popover shadow-md"
                        >
                            <button
                                v-for="employee in matches"
                                :key="employee.id"
                                type="button"
                                class="block w-full px-3 py-2 text-left text-sm hover:bg-muted"
                                @mousedown.prevent="selectEmployee(employee)"
                            >
                                {{ employee.name }}
                            </button>
                            <p v-if="matches.length === 0" class="px-3 py-2 text-sm text-muted-foreground">
                                No employees found.
                            </p>
                        </div>
                    </div>
                    <FieldError v-if="errors.user_id">{{ errors.user_id }}</FieldError>
                </Field>

                <Field>
                    <FieldLabel for="date">Test Date *</FieldLabel>
                    <Input id="date" name="date" type="date" />
                    <FieldError v-if="errors.date">{{ errors.date }}</FieldError>
                </Field>

                <Field>
                    <FieldLabel>Document *</FieldLabel>
                    <FileUpload
                        name="file"
                        accept=".pdf"
                        hint="PDF up to 2 MB"
                    />
                    <FieldError v-if="errors.file">{{ errors.file }}</FieldError>
                </Field>

                <DialogFooter>
                    <DialogClose as-child>
                        <Button type="button" variant="outline">Cancel</Button>
                    </DialogClose>
                    <Button type="submit" :disabled="processing">
                        <Loader2 v-if="processing" class="animate-spin" />
                        Save
                    </Button>
                </DialogFooter>
            </Form>
        </DialogContent>
    </Dialog>
</template>
