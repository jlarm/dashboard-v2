<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Eraser } from 'lucide-vue-next';
import { onBeforeUnmount, onMounted, ref } from 'vue';

type Props = {
    modelValue: string | null;
    height?: number;
    error?: string | null;
};

const props = withDefaults(defineProps<Props>(), {
    height: 180,
    error: null,
});

const emit = defineEmits<{
    'update:modelValue': [value: string | null];
}>();

const canvasRef = ref<HTMLCanvasElement | null>(null);
const drawing = ref(false);
const hasInk = ref(false);
let lastX = 0;
let lastY = 0;
let resizeObserver: ResizeObserver | null = null;

const getCtx = (): CanvasRenderingContext2D | null => {
    const canvas = canvasRef.value;
    return canvas ? canvas.getContext('2d') : null;
};

const sizeCanvas = (): void => {
    const canvas = canvasRef.value;
    if (!canvas) {
        return;
    }

    const ratio = window.devicePixelRatio || 1;
    const cssWidth = canvas.clientWidth;
    const cssHeight = props.height;

    canvas.width = Math.max(1, Math.round(cssWidth * ratio));
    canvas.height = Math.max(1, Math.round(cssHeight * ratio));
    canvas.style.height = `${cssHeight}px`;

    const ctx = getCtx();
    if (!ctx) {
        return;
    }

    ctx.setTransform(ratio, 0, 0, ratio, 0, 0);
    ctx.lineWidth = 2;
    ctx.lineCap = 'round';
    ctx.lineJoin = 'round';
    ctx.strokeStyle = '#111827';
};

const pointerXY = (event: PointerEvent): { x: number; y: number } => {
    const canvas = canvasRef.value!;
    const rect = canvas.getBoundingClientRect();
    return {
        x: event.clientX - rect.left,
        y: event.clientY - rect.top,
    };
};

const onPointerDown = (event: PointerEvent): void => {
    const canvas = canvasRef.value;
    if (!canvas) {
        return;
    }
    canvas.setPointerCapture(event.pointerId);
    drawing.value = true;
    const { x, y } = pointerXY(event);
    lastX = x;
    lastY = y;

    const ctx = getCtx();
    if (!ctx) {
        return;
    }
    ctx.beginPath();
    ctx.arc(x, y, 1, 0, Math.PI * 2);
    ctx.fillStyle = '#111827';
    ctx.fill();
    hasInk.value = true;
};

const onPointerMove = (event: PointerEvent): void => {
    if (!drawing.value) {
        return;
    }
    const { x, y } = pointerXY(event);
    const ctx = getCtx();
    if (!ctx) {
        return;
    }

    ctx.beginPath();
    ctx.moveTo(lastX, lastY);
    ctx.lineTo(x, y);
    ctx.stroke();
    lastX = x;
    lastY = y;
};

const commit = (): void => {
    const canvas = canvasRef.value;
    if (!canvas) {
        return;
    }
    if (!hasInk.value) {
        emit('update:modelValue', null);
        return;
    }
    emit('update:modelValue', canvas.toDataURL('image/png'));
};

const onPointerUp = (event: PointerEvent): void => {
    if (!drawing.value) {
        return;
    }
    drawing.value = false;
    canvasRef.value?.releasePointerCapture(event.pointerId);
    commit();
};

const clear = (): void => {
    const canvas = canvasRef.value;
    const ctx = getCtx();
    if (!canvas || !ctx) {
        return;
    }
    ctx.save();
    ctx.setTransform(1, 0, 0, 1, 0, 0);
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    ctx.restore();
    hasInk.value = false;
    emit('update:modelValue', null);
};

onMounted(() => {
    sizeCanvas();
    resizeObserver = new ResizeObserver(sizeCanvas);
    if (canvasRef.value) {
        resizeObserver.observe(canvasRef.value);
    }
});

onBeforeUnmount(() => {
    resizeObserver?.disconnect();
    resizeObserver = null;
});
</script>

<template>
    <div class="space-y-2">
        <div
            class="relative overflow-hidden rounded-lg border bg-card"
            :class="error ? 'border-destructive' : 'border-input'"
        >
            <canvas
                ref="canvasRef"
                class="block w-full touch-none cursor-crosshair select-none"
                @pointerdown="onPointerDown"
                @pointermove="onPointerMove"
                @pointerup="onPointerUp"
                @pointercancel="onPointerUp"
            />
            <p
                v-if="!hasInk"
                class="pointer-events-none absolute inset-0 flex items-center justify-center text-sm text-muted-foreground"
            >
                Sign here
            </p>
        </div>
        <div class="flex items-center justify-between">
            <p v-if="error" class="text-sm text-destructive">{{ error }}</p>
            <span v-else class="text-xs text-muted-foreground">
                Use your mouse, finger, or stylus to sign.
            </span>
            <Button type="button" variant="ghost" size="sm" :disabled="!hasInk" @click="clear">
                <Eraser class="size-3.5" />
                Clear
            </Button>
        </div>
    </div>
</template>
