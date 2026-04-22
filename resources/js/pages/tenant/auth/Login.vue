<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import AuthLayout from '@/layouts/tenant/auth/AuthCardLayout.vue';
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthenticatedSessionController from '@/actions/App/Http/Controllers/Tenant/Auth/AuthenticatedSessionController';
import { request as passwordRequest } from '@/routes/dealer/password';

defineProps<{
    canResetPassword: boolean;
    status?: string;
}>();

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = (): void => {
    form.post(AuthenticatedSessionController.store().url, {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <AuthLayout
        title="Welcome back"
        description="Enter your email below to login to your account"
    >
        <Head title="Log in" />

        <div
            v-if="status"
            class="mb-4 text-center text-sm font-medium text-green-600"
        >
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

            <div class="grid gap-2">
                <div class="flex items-center">
                    <Label for="password">Password</Label>
                    <TextLink
                        v-if="canResetPassword"
                        :href="passwordRequest().url"
                        class="ml-auto text-sm"
                    >
                        Forgot your password?
                    </TextLink>
                </div>
                <Input
                    id="password"
                    v-model="form.password"
                    type="password"
                    required
                    autocomplete="current-password"
                />
                <InputError :message="form.errors.password" />
            </div>

            <Button type="submit" class="w-full" :disabled="form.processing">
                Login
            </Button>
        </form>
    </AuthLayout>
</template>
