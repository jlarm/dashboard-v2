<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import AuthLayout from '@/layouts/tenant/auth/AuthCardLayout.vue';
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import PasswordResetLinkController from '@/actions/App/Http/Controllers/Tenant/Auth/PasswordResetLinkController';
import AuthenticatedSessionController from '@/actions/App/Http/Controllers/Tenant/Auth/AuthenticatedSessionController';

defineProps<{
    status?: string;
}>();

const form = useForm({
    email: '',
});

const submit = (): void => {
    form.post(PasswordResetLinkController.store().url);
};
</script>

<template>
    <AuthLayout
        title="Forgot your password?"
        description="Enter your email and we'll send you a password reset link"
    >
        <Head title="Forgot password" />

        <div v-if="status" class="mb-4 text-center text-sm font-medium text-green-600">
            {{ status }}
        </div>

        <form class="flex flex-col gap-6" @submit.prevent="submit">
            <div class="grid gap-2">
                <Label for="email">Email</Label>
                <Input
                    id="email"
                    v-model="form.email"
                    type="email"
                    required
                    autofocus
                    autocomplete="email"
                    placeholder="m@example.com"
                />
                <InputError :message="form.errors.email" />
            </div>

            <Button type="submit" class="w-full" :disabled="form.processing">
                Email password reset link
            </Button>

            <div class="text-center text-sm text-muted-foreground">
                Return to
                <TextLink :href="AuthenticatedSessionController.create().url">
                    log in
                </TextLink>
            </div>
        </form>
    </AuthLayout>
</template>
