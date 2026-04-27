<script setup lang="ts">
import { Button } from '@/components/ui/button';
import {
    Sheet,
    SheetContent,
    SheetDescription,
    SheetHeader,
    SheetTitle,
    SheetTrigger,
} from '@/components/ui/sheet';
import notificationRoutes from '@/routes/dealer/notifications';
import { router, usePage } from '@inertiajs/vue3';
import { Bell, BellOff, ExternalLink, Trash2 } from 'lucide-vue-next';
import { computed, ref } from 'vue';

type NotificationData = {
    title?: string;
    message?: string;
    level?: 'success' | 'error' | 'info' | 'warning';
    action_url?: string | null;
    action_label?: string | null;
};

type NotificationItem = {
    id: string;
    type: string;
    data: NotificationData;
    read_at: string | null;
    created_at: string | null;
    created_at_relative: string | null;
};

type PageProps = {
    notifications: {
        items: NotificationItem[];
        unread_count: number;
    };
};

const page = usePage<PageProps>();
const items = computed<NotificationItem[]>(() => page.props.notifications?.items ?? []);
const unreadCount = computed(() => page.props.notifications?.unread_count ?? 0);

const open = ref(false);
const busyId = ref<string | null>(null);
const markingAll = ref(false);

const visitAction = (notification: NotificationItem) => {
    if (!notification.data.action_url) {
        return;
    }

    if (!notification.read_at) {
        markRead(notification);
    }

    open.value = false;
    router.visit(notification.data.action_url);
};

const markRead = (notification: NotificationItem) => {
    if (notification.read_at) {
        return;
    }

    busyId.value = notification.id;
    router.post(
        notificationRoutes.markRead.url({ notification: notification.id }),
        {},
        {
            preserveScroll: true,
            preserveState: true,
            onFinish: () => {
                busyId.value = null;
            },
        },
    );
};

const destroy = (notification: NotificationItem) => {
    busyId.value = notification.id;
    router.delete(notificationRoutes.destroy.url({ notification: notification.id }), {
        preserveScroll: true,
        preserveState: true,
        onFinish: () => {
            busyId.value = null;
        },
    });
};

const markAllRead = () => {
    if (unreadCount.value === 0) {
        return;
    }

    markingAll.value = true;
    router.post(
        notificationRoutes.markAllRead.url(),
        {},
        {
            preserveScroll: true,
            preserveState: true,
            onFinish: () => {
                markingAll.value = false;
            },
        },
    );
};

const levelClass = (level: NotificationData['level']) => {
    switch (level) {
        case 'success':
            return 'bg-emerald-50 text-emerald-700 ring-emerald-600/20';
        case 'error':
            return 'bg-red-50 text-red-700 ring-red-600/20';
        case 'warning':
            return 'bg-amber-50 text-amber-700 ring-amber-600/20';
        default:
            return 'bg-blue-50 text-blue-700 ring-blue-600/20';
    }
};
</script>

<template>
    <Sheet v-model:open="open">
        <SheetTrigger as-child>
            <Button variant="ghost" size="icon" class="relative" aria-label="Notifications">
                <Bell class="size-5" />
                <span
                    v-if="unreadCount > 0"
                    class="absolute -right-0.5 -top-0.5 inline-flex h-4 min-w-[1rem] items-center justify-center rounded-full bg-red-600 px-1 text-[10px] font-semibold text-white"
                >
                    {{ unreadCount > 99 ? '99+' : unreadCount }}
                </span>
            </Button>
        </SheetTrigger>

        <SheetContent class="flex w-full flex-col gap-0 p-0 sm:max-w-md">
            <SheetHeader class="border-b px-6 py-4">
                <div class="flex items-center justify-between gap-2">
                    <div>
                        <SheetTitle>Notifications</SheetTitle>
                        <SheetDescription class="text-xs">
                            <template v-if="unreadCount > 0">
                                {{ unreadCount }} unread
                            </template>
                            <template v-else>
                                You're all caught up
                            </template>
                        </SheetDescription>
                    </div>
                    <Button
                        v-if="unreadCount > 0"
                        variant="ghost"
                        size="sm"
                        :disabled="markingAll"
                        @click="markAllRead"
                    >
                        Mark all read
                    </Button>
                </div>
            </SheetHeader>

            <div class="flex-1 overflow-y-auto">
                <div v-if="items.length === 0" class="flex h-full flex-col items-center justify-center gap-2 p-8 text-center text-muted-foreground">
                    <BellOff class="size-8" />
                    <p class="text-sm">No notifications yet.</p>
                </div>

                <ul v-else class="divide-y">
                    <li
                        v-for="notification in items"
                        :key="notification.id"
                        class="flex flex-col gap-2 px-6 py-4"
                        :class="!notification.read_at ? 'bg-muted/30' : ''"
                    >
                        <div class="flex items-start gap-3">
                            <span
                                v-if="!notification.read_at"
                                class="mt-1.5 size-2 shrink-0 rounded-full bg-primary"
                                aria-label="Unread"
                            />
                            <div class="flex-1 space-y-1">
                                <div class="flex items-start justify-between gap-2">
                                    <h3 class="text-sm font-medium leading-tight">
                                        {{ notification.data.title ?? 'Notification' }}
                                    </h3>
                                    <span class="shrink-0 text-xs text-muted-foreground">
                                        {{ notification.created_at_relative }}
                                    </span>
                                </div>
                                <p v-if="notification.data.message" class="text-sm text-muted-foreground">
                                    {{ notification.data.message }}
                                </p>
                                <div
                                    v-if="notification.data.level"
                                    class="inline-flex w-fit items-center rounded px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wide ring-1 ring-inset"
                                    :class="levelClass(notification.data.level)"
                                >
                                    {{ notification.data.level }}
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-2">
                            <Button
                                v-if="notification.data.action_url && notification.data.action_label"
                                variant="outline"
                                size="sm"
                                :disabled="busyId === notification.id"
                                @click="visitAction(notification)"
                            >
                                <ExternalLink class="size-3.5" />
                                {{ notification.data.action_label }}
                            </Button>
                            <Button
                                v-if="!notification.read_at"
                                variant="ghost"
                                size="sm"
                                :disabled="busyId === notification.id"
                                @click="markRead(notification)"
                            >
                                Mark read
                            </Button>
                            <Button
                                variant="ghost"
                                size="icon"
                                class="size-8 text-muted-foreground hover:text-destructive"
                                :disabled="busyId === notification.id"
                                aria-label="Delete notification"
                                @click="destroy(notification)"
                            >
                                <Trash2 class="size-4" />
                            </Button>
                        </div>
                    </li>
                </ul>
            </div>
        </SheetContent>
    </Sheet>
</template>
