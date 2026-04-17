<script setup lang="ts">
import { computed } from 'vue';
import { VisArea, VisAxis, VisLine, VisXYContainer } from '@unovis/vue';
import {
    ChartContainer,
    ChartCrosshair,
    ChartTooltip,
    ChartTooltipContent,
    componentToString,
} from '@/components/ui/chart';
import type { ChartConfig } from '@/components/ui/chart';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import type { EmailVolumePoint } from '@/types';

type EmailVolumeChartPoint = EmailVolumePoint & {
    day: number;
    dateLabel: string;
};

const props = defineProps<{
    emailVolume: EmailVolumePoint[];
}>();

const chartConfig = {
    total: {
        label: 'Outgoing emails',
        color: 'var(--chart-2)',
    },
} satisfies ChartConfig;

const volumeDate = (point: EmailVolumePoint): Date => {
    return new Date(`${point.date}T00:00:00`);
};

const volumeDay = (point: EmailVolumeChartPoint): number => {
    return point.day;
};

const volumeTotal = (point: EmailVolumeChartPoint): number => {
    return point.total;
};

const formatChartDate = (value: number): string => {
    return new Intl.DateTimeFormat('en-US', {
        month: 'short',
        day: 'numeric',
    }).format(new Date(value));
};

const formatChartTooltipDate = (value: number | Date): string => {
    return new Intl.DateTimeFormat('en-US', {
        month: 'short',
        day: 'numeric',
        year: 'numeric',
    }).format(value instanceof Date ? value : new Date(value));
};

const chartData = computed<EmailVolumeChartPoint[]>(() => {
    return props.emailVolume.map((point) => ({
        ...point,
        day: volumeDate(point).getTime(),
        dateLabel: formatChartTooltipDate(volumeDate(point)),
    }));
});

const svgDefs = `
  <linearGradient id="fillTotal" x1="0" y1="0" x2="0" y2="1">
    <stop
      offset="5%"
      stop-color="var(--color-total)"
      stop-opacity="0.8"
    />
    <stop
      offset="95%"
      stop-color="var(--color-total)"
      stop-opacity="0.1"
    />
  </linearGradient>
`;
</script>

<template>
    <Card>
        <CardHeader class="space-y-1">
            <CardTitle>Emails sent per day</CardTitle>
            <CardDescription>
                Accepted, delivered, and failure Mailgun events over the last 30 days.
            </CardDescription>
        </CardHeader>
        <CardContent>
            <ChartContainer :config="chartConfig" class="h-[280px] w-full">
                <VisXYContainer
                    :data="chartData"
                    :height="280"
                    :yDomain="[0, undefined]"
                    :svg-defs="svgDefs"
                >
                    <VisArea
                        :x="volumeDay"
                        :y="volumeTotal"
                        color="url(#fillTotal)"
                        :opacity="0.4"
                    />
                    <VisLine
                        :x="volumeDay"
                        :y="volumeTotal"
                        :color="chartConfig.total.color"
                        :line-width="2"
                    />
                    <VisAxis
                        type="x"
                        :x="volumeDay"
                        :tick-line="false"
                        :domain-line="false"
                        :grid-line="false"
                        :num-ticks="6"
                        :tick-format="formatChartDate"
                        :tick-text-hide-overlapping="true"
                    />
                    <VisAxis
                        type="y"
                        :tick-line="false"
                        :domain-line="false"
                        :num-ticks="5"
                        :tick-format="(value: number) => value.toString()"
                    />
                    <ChartTooltip />
                    <ChartCrosshair
                        :template="componentToString(chartConfig, ChartTooltipContent, { labelKey: 'dateLabel' })"
                        :color="chartConfig.total.color"
                    />
                </VisXYContainer>
            </ChartContainer>
        </CardContent>
    </Card>
</template>
