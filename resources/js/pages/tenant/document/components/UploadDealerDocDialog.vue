<script setup lang="ts">
import { ref } from 'vue';
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
import DealerDocController from '@/actions/App/Http/Controllers/Tenant/DealerDocController';

const open = ref(false);

const handleSuccess = (): void => {
    open.value = false;
};
</script>

<template>
    <Dialog v-model:open="open">
        <DialogTrigger as-child>
            <Button size="sm" class="w-full sm:w-auto">Upload Document</Button>
        </DialogTrigger>
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Upload Document</DialogTitle>
            </DialogHeader>
            <Form
                v-slot="{ errors, processing }"
                :action="DealerDocController.store()"
                enctype="multipart/form-data"
                reset-on-success
                class="space-y-5"
                @success="handleSuccess"
            >
                <Field>
                    <FieldLabel for="title">PDF Title *</FieldLabel>
                    <Input id="title" name="title" type="text" autofocus />
                    <FieldError v-if="errors.title">{{ errors.title }}</FieldError>
                </Field>

                <Field>
                    <FieldLabel for="url">URL</FieldLabel>
                    <Input id="url" name="url" type="text" placeholder="https://example.com" />
                    <FieldError v-if="errors.url">{{ errors.url }}</FieldError>
                </Field>

                <Field>
                    <FieldLabel>Document</FieldLabel>
                    <FileUpload
                        name="file"
                        accept=".pdf"
                        hint="PDF up to 10 MB"
                    />
                    <FieldError v-if="errors.file">{{ errors.file }}</FieldError>
                </Field>

                <DialogFooter>
                    <DialogClose as-child>
                        <Button type="button" variant="outline">Cancel</Button>
                    </DialogClose>
                    <Button type="submit" :disabled="processing">
                        <Loader2 v-if="processing" class="animate-spin" />
                        Submit
                    </Button>
                </DialogFooter>
            </Form>
        </DialogContent>
    </Dialog>
</template>
