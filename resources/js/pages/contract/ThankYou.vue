<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
import AppLogo from "@/components/AppLogo.vue";
</script>

<template>
    <Head title="Thank you" />
    <div class="min-h-screen flex flex-col items-center justify-center px-6 py-12 bg-background">
        <AppLogo class="h-10 w-auto mb-8" />
        <div class="max-w-lg text-center space-y-4">
            <h1 class="text-2xl font-semibold">Thank you</h1>
            <p class="text-muted-foreground">
                Your contract has been submitted. A member of the ARMP team will be in touch shortly.
            </p>
        </div>
    </div>
</template>
