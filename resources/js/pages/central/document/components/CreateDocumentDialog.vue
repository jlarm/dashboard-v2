<script setup lang="ts">
import { Dialog, DialogContent, DialogFooter, DialogHeader, DialogTitle, DialogTrigger, DialogClose } from "@/components/ui/dialog";
import { Button } from "@/components/ui/button";
import { Form } from "@inertiajs/vue3";
import { Loader2 } from "lucide-vue-next";
import { Field, FieldError, FieldLabel } from "@/components/ui/field";
import { Input } from "@/components/ui/input";
import { FileUpload } from "@/components/ui/file-upload";
import { ref } from "vue";
import DocumentController from "@/actions/App/Http/Controllers/Central/DocumentController";

const open = ref(false);

const handleSuccess = (): void => {
    open.value = false;
};
</script>

<template>
    <Dialog v-model:open="open">
        <DialogTrigger as-child>
            <Button size="sm">Upload Document</Button>
        </DialogTrigger>
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Upload Document</DialogTitle>
            </DialogHeader>
            <Form
                v-slot="{ errors, processing }"
                :action="DocumentController.store()"
                enctype="multipart/form-data"
                reset-on-success
                @success="handleSuccess"
                class="space-y-5"
            >
                <Field>
                    <FieldLabel for="title">Document Name *</FieldLabel>
                    <Input id="title" name="title" type="text" />
                    <FieldError v-if="errors.title">{{ errors.title }}</FieldError>
                </Field>

                <Field>
                    <FieldLabel for="url">URL</FieldLabel>
                    <Input id="url" name="url" type="text" placeholder="https://example.com" />
                    <FieldError v-if="errors.url">{{ errors.url }}</FieldError>
                </Field>

                <Field>
                    <FieldLabel>File</FieldLabel>
                    <FileUpload name="file" />
                    <FieldError v-if="errors.file">{{ errors.file }}</FieldError>
                </Field>

                <DialogFooter>
                    <DialogClose as-child>
                        <Button type="button" variant="outline">Close</Button>
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
