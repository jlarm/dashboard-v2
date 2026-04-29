<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import scan from '@/routes/dealer/scan';
import { useForm } from '@inertiajs/vue3';
import { Loader2, UploadCloud } from 'lucide-vue-next';
import { ref } from 'vue';

const fileInput = ref<HTMLInputElement | null>(null);
const isDragging = ref(false);

const form = useForm<{ scan_type: string; summary_type: string; date: string; file: File | null }>({
    scan_type: '',
    summary_type: '',
    date: '',
    file: null,
});

const onFileChange = (event: Event): void => {
    const target = event.target as HTMLInputElement;
    form.file = target.files?.[0] ?? null;
};

const onDrop = (event: DragEvent): void => {
    isDragging.value = false;
    const file = event.dataTransfer?.files?.[0];
    if (file && file.type === 'application/pdf' && file.size <= 10 * 1024 * 1024) {
        form.file = file;
    }
};

const removeFile = (): void => {
    form.file = null;
    if (fileInput.value) {
        fileInput.value.value = '';
    }
};

const submit = (): void => {
    form.post(scan.archive.upload.url(), {
        preserveScroll: true,
        forceFormData: true,
        onSuccess: () => {
            form.reset();
            if (fileInput.value) {
                fileInput.value.value = '';
            }
        },
    });
};
</script>

<template>
    <article class="mx-auto max-w-3xl rounded-2xl border bg-card p-6">
        <header class="mb-6">
            <h2 class="text-base font-semibold tracking-tight text-foreground">Upload Scan Report</h2>
            <p class="mt-1 text-sm text-muted-foreground">
                Upload an archived PDF scan report. Reports are stored in the scans bucket and listed in the External or Internal tab.
            </p>
        </header>

        <form class="space-y-5" @submit.prevent="submit">
            <div class="grid gap-2">
                <Label for="scan_type">Scan Type</Label>
                <Select v-model="form.scan_type">
                    <SelectTrigger id="scan_type">
                        <SelectValue placeholder="Select a scan type" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectItem value="internal">Internal</SelectItem>
                        <SelectItem value="external">External</SelectItem>
                    </SelectContent>
                </Select>
                <InputError :message="form.errors.scan_type" />
            </div>

            <div class="grid gap-2">
                <Label for="summary_type">Summary Type</Label>
                <Select v-model="form.summary_type">
                    <SelectTrigger id="summary_type">
                        <SelectValue placeholder="Select a summary type" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectItem value="technical">Technical</SelectItem>
                        <SelectItem value="executive">Executive</SelectItem>
                    </SelectContent>
                </Select>
                <InputError :message="form.errors.summary_type" />
            </div>

            <div class="grid gap-2">
                <Label for="date">Date Ran</Label>
                <Input id="date" v-model="form.date" type="date" />
                <p class="text-xs text-muted-foreground">Optional — leave blank to use today's date.</p>
                <InputError :message="form.errors.date" />
            </div>

            <div class="grid gap-2">
                <Label>PDF</Label>
                <div
                    class="relative flex justify-center rounded-lg border border-dashed bg-muted/20 px-6 py-10"
                    :class="{ 'border-primary bg-primary/5': isDragging }"
                    @drop.prevent="onDrop"
                    @dragover.prevent="isDragging = true"
                    @dragleave.prevent="isDragging = false"
                >
                    <div class="text-center">
                        <UploadCloud class="mx-auto size-9 text-muted-foreground" />
                        <div class="mt-3 flex justify-center text-sm text-muted-foreground">
                            <label
                                for="file-upload"
                                class="cursor-pointer rounded-md font-medium text-primary hover:underline"
                            >
                                <span>Upload a file</span>
                                <input
                                    id="file-upload"
                                    ref="fileInput"
                                    type="file"
                                    accept="application/pdf"
                                    class="sr-only"
                                    @change="onFileChange"
                                />
                            </label>
                            <span class="pl-1">or drag and drop</span>
                        </div>
                        <p class="mt-1 text-xs text-muted-foreground">PDF up to 10MB</p>
                    </div>
                </div>
                <div v-if="form.file" class="flex items-center justify-between rounded-md border bg-muted/30 px-3 py-2 text-sm">
                    <span class="truncate text-foreground">{{ form.file.name }}</span>
                    <button
                        type="button"
                        class="ml-3 inline-flex size-6 items-center justify-center rounded-full text-muted-foreground hover:bg-muted hover:text-foreground"
                        aria-label="Remove file"
                        @click="removeFile"
                    >
                        ×
                    </button>
                </div>
                <InputError :message="form.errors.file" />
            </div>

            <div class="flex items-center justify-end">
                <Button type="submit" :disabled="form.processing">
                    <Loader2 v-if="form.processing" class="size-3.5 animate-spin" />
                    Submit
                </Button>
            </div>
        </form>
    </article>
</template>
