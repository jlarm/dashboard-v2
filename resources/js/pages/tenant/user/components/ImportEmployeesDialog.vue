<script setup lang="ts">
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
import employees from '@/routes/dealer/employees';
import { useForm } from '@inertiajs/vue3';
import { Download } from 'lucide-vue-next';
import { ref, watch } from 'vue';

const open = defineModel<boolean>('open', { required: true });

const fileInput = ref<HTMLInputElement | null>(null);

const form = useForm<{ spreadsheet: File | null }>({
    spreadsheet: null,
});

watch(open, (isOpen) => {
    if (isOpen) {
        form.reset();
        form.clearErrors();
    }
});

const onFileChange = (event: Event) => {
    const target = event.target as HTMLInputElement;
    form.spreadsheet = target.files?.[0] ?? null;
};

const submit = () => {
    form.post(employees.import.url(), {
        preserveScroll: true,
        forceFormData: true,
        onSuccess: () => {
            open.value = false;
            if (fileInput.value) {
                fileInput.value.value = '';
            }
        },
    });
};
</script>

<template>
    <Dialog v-model:open="open">
        <DialogContent class="sm:max-w-lg">
            <DialogHeader>
                <DialogTitle>Import Employees</DialogTitle>
                <DialogDescription>
                    Upload a JSON file to invite employees in bulk. The import runs in the background — you'll receive an email with the results when it completes.
                </DialogDescription>
                <a
                    href="/templates/employees-import-template.json"
                    download="employees-import-template.json"
                    class="mt-1 inline-flex w-fit items-center gap-1 text-sm text-primary underline-offset-2 hover:underline"
                >
                    <Download class="size-3.5" />
                    Download template
                </a>
            </DialogHeader>

            <form class="space-y-4" @submit.prevent="submit">
                <div class="space-y-2">
                    <Label for="spreadsheet">Employees file</Label>
                    <input
                        id="spreadsheet"
                        ref="fileInput"
                        type="file"
                        accept=".json,application/json"
                        class="block w-full rounded-md border border-input bg-background text-sm file:mr-3 file:border-0 file:bg-muted file:px-3 file:py-2 file:text-sm file:font-medium"
                        @change="onFileChange"
                    />
                    <p class="text-xs text-muted-foreground">Must be a .json file (max 10 MB).</p>
                    <p v-if="form.errors.spreadsheet" class="text-sm text-red-600">
                        {{ form.errors.spreadsheet }}
                    </p>
                </div>

                <DialogFooter>
                    <Button type="button" variant="outline" :disabled="form.processing" @click="open = false">
                        Cancel
                    </Button>
                    <Button type="submit" :disabled="form.processing || !form.spreadsheet">
                        {{ form.processing ? 'Submitting...' : 'Submit' }}
                    </Button>
                </DialogFooter>
            </form>
        </DialogContent>
    </Dialog>
</template>
