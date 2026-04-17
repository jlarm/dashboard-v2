<script setup lang="ts">
import { Form, Link } from '@inertiajs/vue3';
import DashboardController from '@/actions/App/Http/Controllers/DashboardController';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';

defineProps<{
    search: string;
}>();
</script>

<template>
    <Form
        v-bind="DashboardController.index.form()"
        :options="{
            preserveScroll: true,
            replace: true,
        }"
        class="flex flex-col gap-3 sm:flex-row sm:items-center"
    >
        <Input
            name="search"
            type="search"
            :default-value="search"
            placeholder="Search event, sender, recipient, status, or event ID"
            class="sm:max-w-md"
        />

        <div class="flex gap-2">
            <Button type="submit">Search</Button>

            <Button
                v-if="search !== ''"
                as-child
                variant="outline"
            >
                <Link :href="DashboardController.index.url()" preserve-scroll>
                    Clear
                </Link>
            </Button>
        </div>
    </Form>
</template>
