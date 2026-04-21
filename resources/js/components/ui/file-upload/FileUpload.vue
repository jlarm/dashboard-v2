<script setup lang="ts">
import { ref, computed } from "vue";
import { UploadCloud, X, FileText } from "lucide-vue-next";
import { cn } from "@/lib/utils";

interface Props {
    name?: string;
    accept?: string;
    label?: string;
    hint?: string;
    class?: string;
}

const props = withDefaults(defineProps<Props>(), {
    name: "file",
    accept: ".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.zip,.rar",
    label: "Drop your file here, or",
    hint: "PDF, Word, Excel, PowerPoint, ZIP — up to 10 MB",
});

const emit = defineEmits<{
    (e: "update:file", file: File | null): void;
}>();

const isDragging = ref(false);
const selectedFile = ref<File | null>(null);
const fileInputRef = ref<HTMLInputElement | null>(null);

const formattedSize = computed((): string => {
    if (!selectedFile.value) return "";
    const bytes = selectedFile.value.size;
    if (bytes < 1024) return `${bytes} B`;
    if (bytes < 1024 * 1024) return `${(bytes / 1024).toFixed(1)} KB`;
    return `${(bytes / (1024 * 1024)).toFixed(1)} MB`;
});

const setFile = (file: File): void => {
    selectedFile.value = file;
    emit("update:file", file);

    if (fileInputRef.value) {
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        fileInputRef.value.files = dataTransfer.files;
    }
};

const removeFile = (): void => {
    selectedFile.value = null;
    emit("update:file", null);
    if (fileInputRef.value) {
        fileInputRef.value.value = "";
    }
};

const onDragOver = (event: DragEvent): void => {
    event.preventDefault();
    isDragging.value = true;
};

const onDragLeave = (): void => {
    isDragging.value = false;
};

const onDrop = (event: DragEvent): void => {
    event.preventDefault();
    isDragging.value = false;
    const file = event.dataTransfer?.files?.[0];
    if (file) {
        setFile(file);
    }
};

const onInputChange = (event: Event): void => {
    const file = (event.target as HTMLInputElement).files?.[0];
    if (file) {
        setFile(file);
    }
};
</script>

<template>
    <div :class="cn('w-full', props.class)" data-slot="file-upload">
        <input
            ref="fileInputRef"
            :name="name"
            :accept="accept"
            type="file"
            class="sr-only"
            @change="onInputChange"
        />

        <!-- Drop zone -->
        <div
            v-if="!selectedFile"
            role="button"
            tabindex="0"
            :class="cn(
                'flex flex-col items-center justify-center gap-3 rounded-lg border-2 border-dashed px-6 py-10 text-center transition-colors cursor-pointer',
                isDragging
                    ? 'border-primary bg-primary/5'
                    : 'border-border hover:border-primary/50 hover:bg-muted/50',
            )"
            @dragover="onDragOver"
            @dragleave="onDragLeave"
            @drop="onDrop"
            @click="fileInputRef?.click()"
            @keydown.enter.space.prevent="fileInputRef?.click()"
        >
            <UploadCloud class="size-8 text-muted-foreground" />
            <div class="space-y-1">
                <p class="text-sm font-medium">
                    {{ label }}
                    <span class="text-primary underline-offset-2 hover:underline">browse</span>
                </p>
                <p class="text-xs text-muted-foreground">{{ hint }}</p>
            </div>
        </div>

        <!-- Selected file preview -->
        <div
            v-else
            class="flex items-center gap-3 rounded-lg border bg-muted/40 px-4 py-3"
        >
            <FileText class="size-5 shrink-0 text-muted-foreground" />
            <div class="min-w-0 flex-1">
                <p class="truncate text-sm font-medium">{{ selectedFile.name }}</p>
                <p class="text-xs text-muted-foreground">{{ formattedSize }}</p>
            </div>
            <button
                type="button"
                class="shrink-0 rounded-sm text-muted-foreground transition-colors hover:text-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
                aria-label="Remove file"
                @click="removeFile"
            >
                <X class="size-4" />
            </button>
        </div>
    </div>
</template>
