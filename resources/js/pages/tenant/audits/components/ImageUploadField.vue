<script setup lang="ts">
import { computed, ref } from 'vue';
import { ImagePlus, X } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';

type ImageUploadFieldProps = {
    modelValue: File[];
    max?: number;
    label?: string;
    accept?: string;
};

const props = withDefaults(defineProps<ImageUploadFieldProps>(), {
    max: 3,
    label: 'Add photos',
    accept: 'image/*,.heic,.heif',
});

const emit = defineEmits<{
    (e: 'update:modelValue', files: File[]): void;
}>();

const fileInput = ref<HTMLInputElement | null>(null);
const isProcessing = ref(false);

const previews = computed(() => props.modelValue.map((file) => ({
    name: file.name,
    url: URL.createObjectURL(file),
})));

const isHeic = (file: File): boolean => /\.heic|\.heif$/i.test(file.name) || file.type === 'image/heic' || file.type === 'image/heif';

async function convertHeicToJpeg(file: File): Promise<File> {
    try {
        // @ts-expect-error heic2any ships without bundled types
        const heic2any = (await import('heic2any')).default;
        const blob = await heic2any({ blob: file, toType: 'image/jpeg', quality: 0.85 });
        const out = Array.isArray(blob) ? blob[0] : blob;
        return new File([out], file.name.replace(/\.heic|\.heif$/i, '.jpg'), { type: 'image/jpeg' });
    } catch {
        return file;
    }
}

async function downscale(file: File, maxLongEdge = 2000, quality = 0.82): Promise<File> {
    return new Promise((resolve) => {
        const img = new Image();
        img.onload = () => {
            const longEdge = Math.max(img.width, img.height);
            if (longEdge <= maxLongEdge) {
                resolve(file);
                return;
            }
            const scale = maxLongEdge / longEdge;
            const canvas = document.createElement('canvas');
            canvas.width = Math.round(img.width * scale);
            canvas.height = Math.round(img.height * scale);
            const ctx = canvas.getContext('2d');
            if (!ctx) {
                resolve(file);
                return;
            }
            ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
            canvas.toBlob(
                (blob) => {
                    if (!blob) {
                        resolve(file);
                        return;
                    }
                    resolve(new File([blob], file.name.replace(/\.(png|webp)$/i, '.jpg'), { type: 'image/jpeg' }));
                },
                'image/jpeg',
                quality,
            );
        };
        img.onerror = () => resolve(file);
        img.src = URL.createObjectURL(file);
    });
}

const onPick = async (event: Event): Promise<void> => {
    const input = event.target as HTMLInputElement;
    if (!input.files) return;
    isProcessing.value = true;
    try {
        const incoming = Array.from(input.files);
        const slotsLeft = Math.max(0, props.max - props.modelValue.length);
        const limited = incoming.slice(0, slotsLeft);
        const processed: File[] = [];
        for (const file of limited) {
            const ready = isHeic(file) ? await convertHeicToJpeg(file) : file;
            processed.push(await downscale(ready));
        }
        emit('update:modelValue', [...props.modelValue, ...processed]);
        input.value = '';
    } finally {
        isProcessing.value = false;
    }
};

const removeAt = (index: number): void => {
    const next = [...props.modelValue];
    next.splice(index, 1);
    emit('update:modelValue', next);
};

const triggerPicker = (): void => fileInput.value?.click();
</script>

<template>
    <div class="space-y-3">
        <div v-if="previews.length" class="flex flex-wrap gap-3">
            <div v-for="(preview, index) in previews" :key="preview.url" class="relative">
                <img
                    :src="preview.url"
                    :alt="preview.name"
                    class="size-24 rounded-md object-cover ring-1 ring-border"
                />
                <button
                    type="button"
                    class="absolute -right-2 -top-2 grid size-6 place-items-center rounded-full bg-destructive text-destructive-foreground"
                    @click="removeAt(index)"
                >
                    <X class="size-3.5" />
                    <span class="sr-only">Remove photo</span>
                </button>
            </div>
        </div>

        <div v-if="modelValue.length < max" class="flex items-center gap-2">
            <input
                ref="fileInput"
                type="file"
                :accept="accept"
                multiple
                capture="environment"
                class="hidden"
                @change="onPick"
            />
            <Button type="button" variant="outline" size="sm" :disabled="isProcessing" @click="triggerPicker">
                <ImagePlus class="size-4" />
                {{ isProcessing ? 'Processing…' : label }}
            </Button>
            <p class="text-xs text-muted-foreground">{{ modelValue.length }}/{{ max }} photos</p>
        </div>
    </div>
</template>
