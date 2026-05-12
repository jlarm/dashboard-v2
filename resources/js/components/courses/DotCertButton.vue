<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { Award } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import courses from '@/routes/dealer/courses';

const issue = (): void => {
    router.post(courses.dotCertificate.issue.url(), {}, { preserveScroll: true });
};
</script>

<template>
    <Button variant="outline" size="sm" @click="issue">
        <Award class="size-4" />
        Generate DOT Certificate
    </Button>
</template>
