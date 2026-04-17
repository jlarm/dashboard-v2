<script setup>
import { Head } from '@inertiajs/vue3';

defineProps({
    message: { type: String, default: 'Hello from Inertia + Vue 3' },
});
</script>

<template>
    <Head title="Welcome" />
    <div class="p-8">
        <h1 class="text-2xl font-semibold">{{ message }}</h1>
    </div>
</template>
