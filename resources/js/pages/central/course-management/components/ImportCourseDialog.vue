<script setup lang="ts">
import { ref } from "vue";
import { Form } from "@inertiajs/vue3";
import { Loader2 } from "lucide-vue-next";
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from "@/components/ui/dialog";
import { Button } from "@/components/ui/button";
import { Field, FieldError, FieldLabel } from "@/components/ui/field";
import CourseManagementController from "@/actions/App/Http/Controllers/Central/CourseManagementController";

const open = ref(false);

const handleSuccess = (): void => {
    open.value = false;
};
</script>

<template>
    <Dialog v-model:open="open">
        <DialogTrigger as-child>
            <Button size="sm">Import Courses</Button>
        </DialogTrigger>
        <DialogContent class="sm:max-w-lg">
            <DialogHeader>
                <DialogTitle>Import Courses</DialogTitle>
                <DialogDescription>
                    Upload a JSON file containing an array of courses. Existing courses (matched by slug)
                    are updated; new courses are created across every tenant.
                </DialogDescription>
            </DialogHeader>
            <Form
                v-slot="{ errors, processing }"
                :action="CourseManagementController.import()"
                enctype="multipart/form-data"
                reset-on-success
                @success="handleSuccess"
                class="space-y-6"
            >
                <Field>
                    <FieldLabel for="course-import-file">JSON file *</FieldLabel>
                    <input
                        id="course-import-file"
                        type="file"
                        name="file"
                        accept=".json,application/json"
                        class="text-sm"
                    />
                    <FieldError v-if="errors.file">{{ errors.file }}</FieldError>
                </Field>

                <DialogFooter>
                    <DialogClose as-child>
                        <Button type="button" variant="outline">Cancel</Button>
                    </DialogClose>
                    <Button type="submit" :disabled="processing">
                        <Loader2 v-if="processing" class="animate-spin" />
                        Import
                    </Button>
                </DialogFooter>
            </Form>
        </DialogContent>
    </Dialog>
</template>
