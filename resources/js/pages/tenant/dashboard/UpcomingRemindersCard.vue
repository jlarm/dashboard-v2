<script setup lang="ts">
import { pillClass, reminderDotClass } from './tone';
import type { ReminderItem } from './types';

// Placeholder data — to be wired to a real query in a follow-up.
const reminders: ReminderItem[] = [
    { title: 'OSHA eyewash station remediation', assignee: 'Service Mgr', due: '2d', tone: 'negative' },
    { title: 'Annual GLBA safeguards review', assignee: 'Finance Dir', due: '5d', tone: 'warning' },
    { title: 'Body shop ventilation follow-up', assignee: 'BodyShop Mgr', due: '9d', tone: 'warning' },
    { title: 'Vendor questionnaire — DealerTrack', assignee: 'Compliance', due: '12d', tone: 'neutral' },
];
</script>

<template>
    <article class="overflow-hidden rounded-2xl border bg-card">
        <header class="flex items-center justify-between bg-muted/40 px-5 py-3">
            <h3 class="text-sm font-medium text-foreground">Upcoming Reminders</h3>
            <span class="text-xs text-muted-foreground">{{ reminders.length }}</span>
        </header>
        <ul class="divide-y">
            <li
                v-for="item in reminders"
                :key="item.title"
                class="flex items-start gap-3 px-5 py-3"
            >
                <span class="mt-1.5 size-1.5 shrink-0 rounded-full" :class="reminderDotClass(item.tone)" />
                <div class="min-w-0 flex-1">
                    <p class="truncate text-sm text-foreground">{{ item.title }}</p>
                    <p class="mt-0.5 text-xs text-muted-foreground">{{ item.assignee }}</p>
                </div>
                <span
                    class="shrink-0 rounded-md px-1.5 py-0.5 text-xs font-semibold tabular-nums"
                    :class="pillClass(item.tone)"
                >
                    {{ item.due }}
                </span>
            </li>
        </ul>
    </article>
</template>
