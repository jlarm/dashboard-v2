<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { home } from '@/routes';

defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <div
        class="flex min-h-svh flex-col items-center justify-center gap-8 bg-muted p-6 md:p-10"
    >
        <div class="flex w-full max-w-md flex-col gap-8">
            <Link :href="home()" class="flex items-center justify-center">
                <AppLogoIcon class="h-10 w-auto" />
            </Link>

            <Card class="rounded-xl">
                <CardHeader class="px-8 pt-8 pb-0 text-center">
                    <CardTitle class="text-2xl font-bold">
                        {{ title }}
                    </CardTitle>
                    <CardDescription v-if="description">
                        {{ description }}
                    </CardDescription>
                </CardHeader>
                <CardContent class="px-8 py-8">
                    <slot />
                </CardContent>
            </Card>
        </div>
    </div>
</template>
