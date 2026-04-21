<script setup lang="ts">
import { onMounted, onBeforeUnmount, ref, watch } from "vue";
import { Button } from "@/components/ui/button";

const props = defineProps<{
    modelValue?: string | null;
    name?: string;
    disabled?: boolean;
}>();

const emit = defineEmits<{
    (e: "update:modelValue", value: string): void;
}>();

const canvasRef = ref<HTMLCanvasElement | null>(null);
const isDrawing = ref(false);
const isEmpty = ref(true);
let lastX = 0;
let lastY = 0;

const getContext = (): CanvasRenderingContext2D | null => {
    const canvas = canvasRef.value;
    if (!canvas) return null;
    return canvas.getContext("2d");
};

const resizeCanvas = (): void => {
    const canvas = canvasRef.value;
    if (!canvas) return;
    const dpr = window.devicePixelRatio || 1;
    const rect = canvas.getBoundingClientRect();
    canvas.width = rect.width * dpr;
    canvas.height = rect.height * dpr;
    const ctx = canvas.getContext("2d");
    if (ctx) {
        ctx.scale(dpr, dpr);
        ctx.lineCap = "round";
        ctx.lineJoin = "round";
        ctx.lineWidth = 2;
        ctx.strokeStyle = "#000";
    }
};

const eventPosition = (event: MouseEvent | TouchEvent): { x: number; y: number } => {
    const canvas = canvasRef.value;
    if (!canvas) return { x: 0, y: 0 };
    const rect = canvas.getBoundingClientRect();
    if ("touches" in event) {
        const touch = event.touches[0];
        return { x: touch.clientX - rect.left, y: touch.clientY - rect.top };
    }
    return { x: event.clientX - rect.left, y: event.clientY - rect.top };
};

const startDraw = (event: MouseEvent | TouchEvent): void => {
    if (props.disabled) return;
    event.preventDefault();
    isDrawing.value = true;
    const pos = eventPosition(event);
    lastX = pos.x;
    lastY = pos.y;
};

const draw = (event: MouseEvent | TouchEvent): void => {
    if (!isDrawing.value || props.disabled) return;
    event.preventDefault();
    const ctx = getContext();
    if (!ctx) return;
    const pos = eventPosition(event);
    ctx.beginPath();
    ctx.moveTo(lastX, lastY);
    ctx.lineTo(pos.x, pos.y);
    ctx.stroke();
    lastX = pos.x;
    lastY = pos.y;
    isEmpty.value = false;
};

const endDraw = (): void => {
    if (!isDrawing.value) return;
    isDrawing.value = false;
    const canvas = canvasRef.value;
    if (!canvas || isEmpty.value) return;
    emit("update:modelValue", canvas.toDataURL("image/png"));
};

const clear = (): void => {
    const canvas = canvasRef.value;
    const ctx = getContext();
    if (!canvas || !ctx) return;
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    isEmpty.value = true;
    emit("update:modelValue", "");
};

onMounted(() => {
    resizeCanvas();
    window.addEventListener("resize", resizeCanvas);
});

onBeforeUnmount(() => {
    window.removeEventListener("resize", resizeCanvas);
});

watch(
    () => props.modelValue,
    (value) => {
        if (!value) {
            isEmpty.value = true;
        }
    },
);
</script>

<template>
    <div class="space-y-2">
        <div class="border rounded-md bg-white">
            <canvas
                ref="canvasRef"
                class="block w-full h-40 touch-none rounded-md"
                @mousedown="startDraw"
                @mousemove="draw"
                @mouseup="endDraw"
                @mouseleave="endDraw"
                @touchstart="startDraw"
                @touchmove="draw"
                @touchend="endDraw"
            />
        </div>
        <input v-if="name" type="hidden" :name="name" :value="modelValue ?? ''" />
        <div class="flex justify-end">
            <Button type="button" size="sm" variant="ghost" :disabled="disabled" @click="clear">Clear</Button>
        </div>
    </div>
</template>
