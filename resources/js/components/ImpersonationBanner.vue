<script setup lang="ts">
import { Button } from '@/components/ui/button';
import stopRoutes from '@/routes/dealer/stop';
import type { Auth } from '@/types/auth';
import { Link, usePage } from '@inertiajs/vue3';
import { LogOut } from 'lucide-vue-next';
import { computed } from 'vue';

const page = usePage<{ auth: Auth }>();
const impersonating = computed(() => page.props.auth.impersonating);
const currentUserName = computed(() => page.props.auth.user?.name ?? 'user');
</script>

<template>
    <div
        v-if="impersonating"
        class="flex flex-wrap items-center justify-between gap-2 border-b border-amber-300 bg-amber-100 px-4 py-2 text-sm text-amber-900"
        role="status"
    >
        <span>
            You are impersonating <strong>{{ currentUserName }}</strong>.
        </span>
        <Button as-child variant="outline" size="sm" class="border-amber-400 bg-white text-amber-900 hover:bg-amber-50">
            <Link :href="stopRoutes.impersonation.url()">
                <LogOut class="mr-1 size-4" />
                Return to your account
            </Link>
        </Button>
    </div>
</template>
