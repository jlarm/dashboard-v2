<script setup lang="ts">
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import {
    Table,
    TableBody,
    TableCell,
    TableEmpty,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import type { Log, PaginatedLogs } from '@/types';

defineProps<{
    logs: PaginatedLogs;
    search: string;
}>();

const emit = defineEmits<{
    viewPayload: [log: Log];
}>();

const formatOccurredAt = (value: string): string => {
    return new Intl.DateTimeFormat('en-US', {
        dateStyle: 'medium',
        timeStyle: 'short',
    }).format(new Date(value));
};

const formatStatus = (log: Log): string => {
    switch (log.event_type.toLowerCase()) {
        case 'accepted':
            return 'Accepted';
        case 'delivered':
            return 'Delivered';
        case 'failed':
        case 'permanent_fail':
        case 'permanent-fail':
            return 'Failed';
        case 'temporary_fail':
        case 'temporary-fail':
            return 'Temporary issue';
        case 'opened':
        case 'clicked':
        case 'complained':
        case 'unsubscribed':
            return 'N/A';
    }

    switch (log.delivery_status_severity?.toLowerCase()) {
        case 'success':
            return 'Delivered';
        case 'permanent':
            return 'Failed';
        case 'temporary':
            return 'Temporary issue';
        default:
            return 'N/A';
    }
};

const statusBadgeClass = (log: Log): string => {
    switch (formatStatus(log)) {
        case 'Delivered':
            return 'border-emerald-200 bg-emerald-50 text-emerald-700';
        case 'Accepted':
            return 'border-sky-200 bg-sky-50 text-sky-700';
        case 'Failed':
            return 'border-rose-200 bg-rose-50 text-rose-700';
        case 'Temporary issue':
            return 'border-amber-200 bg-amber-50 text-amber-700';
        default:
            return 'border-slate-200 bg-slate-50 text-slate-700';
    }
};

const shouldShowStatusCode = (log: Log): boolean => {
    return ['Failed', 'Temporary issue'].includes(formatStatus(log)) && Boolean(log.delivery_status_code);
};

const eventBadgeClass = (eventType: string): string => {
    switch (eventType.toLowerCase()) {
        case 'delivered':
            return 'border-emerald-200 bg-emerald-50 text-emerald-700';
        case 'accepted':
            return 'border-sky-200 bg-sky-50 text-sky-700';
        case 'failed':
        case 'permanent_fail':
        case 'permanent-fail':
            return 'border-rose-200 bg-rose-50 text-rose-700';
        case 'temporary_fail':
        case 'temporary-fail':
            return 'border-amber-200 bg-amber-50 text-amber-700';
        case 'opened':
        case 'clicked':
            return 'border-violet-200 bg-violet-50 text-violet-700';
        case 'complained':
        case 'unsubscribed':
            return 'border-orange-200 bg-orange-50 text-orange-700';
        default:
            return 'border-slate-200 bg-slate-50 text-slate-700';
    }
};
</script>

<template>
    <div class="rounded-xl border bg-background">
        <Table>
            <TableHeader>
                <TableRow>
                    <TableHead>Date</TableHead>
                    <TableHead>Event</TableHead>
                    <TableHead>From</TableHead>
                    <TableHead>Recipient</TableHead>
                    <TableHead>Delivery Status</TableHead>
                    <TableHead></TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                <TableEmpty v-if="logs.data.length === 0" :colspan="6">
                    {{ search === '' ? 'No Mailgun logs yet.' : 'No logs matched your search.' }}
                </TableEmpty>

                <TableRow v-for="log in logs.data" :key="log.id">
                    <TableCell>{{ formatOccurredAt(log.occurred_at) }}</TableCell>
                    <TableCell>
                        <Badge
                            variant="outline"
                            :class="eventBadgeClass(log.event_type)"
                        >
                            {{ log.event_type }}
                        </Badge>
                    </TableCell>
                    <TableCell>{{ log.sender ?? 'N/A' }}</TableCell>
                    <TableCell>{{ log.recipient }}</TableCell>
                    <TableCell>
                        <div class="flex items-center gap-2">
                            <template v-if="formatStatus(log) === 'N/A'">
                                <span class="text-sm text-muted-foreground">N/A</span>
                            </template>
                            <Badge
                                v-else
                                variant="outline"
                                :class="statusBadgeClass(log)"
                            >
                                {{ formatStatus(log) }}
                            </Badge>
                            <span
                                v-if="shouldShowStatusCode(log)"
                                class="text-sm text-muted-foreground"
                            >
                                {{ log.delivery_status_code }}
                            </span>
                        </div>
                    </TableCell>
                    <TableCell class="text-right">
                        <Button
                            variant="outline"
                            size="sm"
                            @click="emit('viewPayload', log)"
                        >
                            View payload
                        </Button>
                    </TableCell>
                </TableRow>
            </TableBody>
        </Table>
    </div>
</template>
