<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { CheckCircle2 } from 'lucide-vue-next';
import AppLogo from '@/components/AppLogo.vue';
</script>

<template>
    <Head title="Thank You" />

    <div class="flex min-h-screen flex-col items-center justify-center bg-slate-50 px-4">
        <AppLogo class="mb-10 h-12 w-auto" />

        <div class="w-full max-w-md rounded-xl border bg-white p-10 text-center shadow-sm">
            <div class="mx-auto flex size-14 items-center justify-center rounded-full bg-emerald-100 text-emerald-600">
                <CheckCircle2 class="size-7" />
            </div>
            <h1 class="mt-5 text-2xl font-semibold tracking-tight text-slate-900">Thank you!</h1>
            <p class="mt-2 text-sm text-slate-600">
                Your submission has been received successfully. You can safely close this window.
            </p>
        </div>
    </div>
</template>
