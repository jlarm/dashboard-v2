<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthLayout from '@/layouts/tenant/auth/AuthCardLayout.vue';
import employees from '@/routes/dealer/employees';
import { Head, useForm } from '@inertiajs/vue3';

type InviteProps = {
    id: number;
    name: string;
    email: string;
    company: string;
    stores: string[];
};

const props = defineProps<{ invite: InviteProps }>();

const form = useForm({
    id: props.invite.id,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(employees.store.url(), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Complete registration" />

    <AuthLayout
        :title="`Welcome, ${invite.name}`"
        :description="`Create a password to finish joining ${invite.company}.`"
    >
        <form class="flex flex-col gap-6" @submit.prevent="submit">
            <div class="grid gap-2 rounded-md border bg-muted/40 p-3 text-sm">
                <div class="flex justify-between gap-4">
                    <span class="text-muted-foreground">Email</span>
                    <span class="font-medium">{{ invite.email }}</span>
                </div>
                <div v-if="invite.stores.length > 0" class="flex justify-between gap-4">
                    <span class="text-muted-foreground">{{ invite.stores.length === 1 ? 'Store' : 'Stores' }}</span>
                    <span class="text-right font-medium">{{ invite.stores.join(', ') }}</span>
                </div>
            </div>

            <div class="grid gap-2">
                <Label for="password">Password</Label>
                <Input
                    id="password"
                    v-model="form.password"
                    type="password"
                    required
                    autofocus
                    autocomplete="new-password"
                />
                <InputError :message="form.errors.password" />
            </div>

            <div class="grid gap-2">
                <Label for="password_confirmation">Confirm password</Label>
                <Input
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    required
                    autocomplete="new-password"
                />
                <InputError :message="form.errors.password_confirmation" />
            </div>

            <Button type="submit" class="w-full" :disabled="form.processing">
                {{ form.processing ? 'Creating account...' : 'Complete registration' }}
            </Button>
        </form>
    </AuthLayout>
</template>
