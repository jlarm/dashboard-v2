<script setup lang="ts">
import { Button } from '@/components/ui/button';
import {
    Sheet,
    SheetContent,
    SheetHeader,
    SheetTitle,
    SheetTrigger,
} from '@/components/ui/sheet';
import notificationRoutes from '@/routes/dealer/notifications';
import { router, usePage } from '@inertiajs/vue3';
import {
    AlertTriangle,
    Bell,
    BellOff,
    CheckCheck,
    Info,
    Mail,
    Trash2,
    UserPlus,
    type LucideIcon,
} from 'lucide-vue-next';
import { computed, ref } from 'vue';

type NotificationLevel = 'success' | 'error' | 'info' | 'warning';

type NotificationAction = {
    label: string;
    url: string;
    variant?: 'default' | 'outline' | 'ghost';
};

type NotificationData = {
    title?: string;
    message?: string;
    level?: NotificationLevel;
    icon?: string;
    actions?: NotificationAction[];
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

const ICONS: Record<string, LucideIcon> = {
    AlertTriangle,
    Bell,
    Info,
    Mail,
    UserPlus,
};

const iconFor = (notification: NotificationItem): LucideIcon => {
    if (notification.data.icon && ICONS[notification.data.icon]) {
        return ICONS[notification.data.icon];
    }

    switch (notification.data.level) {
        case 'success':
            return CheckCheck;
        case 'error':
            return AlertTriangle;
        case 'warning':
            return AlertTriangle;
        default:
            return Bell;
    }
};

const iconWrapperClass = (level: NotificationLevel | undefined) => {
    switch (level) {
        case 'success':
            return 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-300';
        case 'error':
            return 'bg-red-100 text-red-700 dark:bg-red-500/15 dark:text-red-300';
        case 'warning':
            return 'bg-amber-100 text-amber-700 dark:bg-amber-500/15 dark:text-amber-300';
        default:
            return 'bg-blue-100 text-blue-700 dark:bg-blue-500/15 dark:text-blue-300';
    }
};

const visitAction = (notification: NotificationItem, action: NotificationAction) => {
    if (!notification.read_at) {
        markRead(notification);
    }

    open.value = false;
    router.visit(action.url);
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

type Group = { label: string; items: NotificationItem[] };

const grouped = computed<Group[]>(() => {
    const today: NotificationItem[] = [];
    const earlier: NotificationItem[] = [];
    const startOfToday = new Date();
    startOfToday.setHours(0, 0, 0, 0);

    for (const item of items.value) {
        const created = item.created_at ? new Date(item.created_at) : null;
        if (created && created >= startOfToday) {
            today.push(item);
        } else {
            earlier.push(item);
        }
    }

    return [
        { label: 'Today', items: today },
        { label: 'Earlier', items: earlier },
    ].filter((group) => group.items.length > 0);
});
</script>

<template>
    <Sheet v-model:open="open">
        <SheetTrigger as-child>
            <Button variant="ghost" size="icon" class="relative" aria-label="Notifications">
                <Bell class="size-5" />
                <span
                    v-if="unreadCount > 0"
                    class="absolute right-1 top-1 flex size-2 items-center justify-center rounded-full bg-red-500 ring-2 ring-background"
                />
            </Button>
        </SheetTrigger>

        <SheetContent class="flex w-full flex-col gap-0 p-0 sm:max-w-[420px]">
            <SheetHeader class="space-y-1 border-b px-6 py-4">
                <div class="flex items-center justify-between">
                    <SheetTitle class="text-base font-semibold tracking-tight">Notifications</SheetTitle>
                    <button
                        v-if="unreadCount > 0"
                        type="button"
                        :disabled="markingAll"
                        class="text-xs font-medium text-primary hover:underline disabled:opacity-50"
                        @click="markAllRead"
                    >
                        Mark all as read
                    </button>
                </div>
                <p class="text-xs text-muted-foreground">
                    <template v-if="unreadCount > 0">
                        {{ unreadCount }} unread {{ unreadCount === 1 ? 'notification' : 'notifications' }}
                    </template>
                    <template v-else-if="items.length > 0">
                        You're all caught up
                    </template>
                </p>
            </SheetHeader>

            <div class="flex-1 overflow-y-auto">
                <div
                    v-if="items.length === 0"
                    class="flex h-full flex-col items-center justify-center gap-3 p-8 text-center text-muted-foreground"
                >
                    <div class="flex size-12 items-center justify-center rounded-full bg-muted">
                        <BellOff class="size-5" />
                    </div>
                    <div class="space-y-1">
                        <p class="text-sm font-medium text-foreground">Nothing here yet</p>
                        <p class="text-xs">When something needs your attention, it'll show up here.</p>
                    </div>
                </div>

                <template v-else>
                    <div v-for="group in grouped" :key="group.label" class="border-b last:border-b-0">
                        <p class="px-6 pt-4 pb-2 text-[10px] font-semibold uppercase tracking-[0.14em] text-muted-foreground">
                            {{ group.label }}
                        </p>
                        <ul class="pb-2">
                            <li
                                v-for="notification in group.items"
                                :key="notification.id"
                                class="group relative flex items-start gap-3 px-6 py-3 transition-colors hover:bg-muted/50"
                                :class="!notification.read_at ? 'bg-primary/[0.03]' : ''"
                            >
                                <div
                                    class="flex size-9 shrink-0 items-center justify-center rounded-full"
                                    :class="iconWrapperClass(notification.data.level)"
                                >
                                    <component :is="iconFor(notification)" class="size-4" />
                                </div>

                                <div class="min-w-0 flex-1 space-y-1">
                                    <div class="flex items-baseline justify-between gap-2">
                                        <h3 class="truncate text-sm font-medium leading-tight text-foreground">
                                            {{ notification.data.title ?? 'Notification' }}
                                        </h3>
                                        <span class="shrink-0 text-[11px] text-muted-foreground">
                                            {{ notification.created_at_relative }}
                                        </span>
                                    </div>
                                    <p
                                        v-if="notification.data.message"
                                        class="text-sm leading-snug text-muted-foreground"
                                    >
                                        {{ notification.data.message }}
                                    </p>

                                    <div
                                        v-if="(notification.data.actions?.length ?? 0) > 0"
                                        class="flex flex-wrap items-center gap-2 pt-1"
                                    >
                                        <Button
                                            v-for="(action, index) in notification.data.actions"
                                            :key="index"
                                            :variant="action.variant ?? (index === 0 ? 'default' : 'outline')"
                                            size="sm"
                                            class="h-7 text-xs"
                                            :disabled="busyId === notification.id"
                                            @click="visitAction(notification, action)"
                                        >
                                            {{ action.label }}
                                        </Button>
                                    </div>
                                </div>

                                <span
                                    v-if="!notification.read_at"
                                    class="absolute right-3 top-1/2 size-1.5 -translate-y-1/2 rounded-full bg-primary"
                                    aria-hidden="true"
                                />

                                <div class="absolute right-2 top-2 hidden gap-0.5 group-hover:flex">
                                    <button
                                        v-if="!notification.read_at"
                                        type="button"
                                        :disabled="busyId === notification.id"
                                        class="inline-flex size-7 items-center justify-center rounded-md text-muted-foreground transition-colors hover:bg-background hover:text-foreground disabled:opacity-50"
                                        title="Mark as read"
                                        @click.stop="markRead(notification)"
                                    >
                                        <CheckCheck class="size-3.5" />
                                    </button>
                                    <button
                                        type="button"
                                        :disabled="busyId === notification.id"
                                        class="inline-flex size-7 items-center justify-center rounded-md text-muted-foreground transition-colors hover:bg-background hover:text-destructive disabled:opacity-50"
                                        title="Delete"
                                        @click.stop="destroy(notification)"
                                    >
                                        <Trash2 class="size-3.5" />
                                    </button>
                                </div>
                            </li>
                        </ul>
                    </div>
                </template>
            </div>
        </SheetContent>
    </Sheet>
</template>
