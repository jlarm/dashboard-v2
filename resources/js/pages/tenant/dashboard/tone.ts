import type { PillTone } from './types';

export const pillClass = (tone: PillTone): string => {
    switch (tone) {
        case 'positive':
            return 'bg-emerald-50 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400';
        case 'warning':
            return 'bg-amber-50 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400';
        case 'negative':
            return 'bg-rose-50 text-rose-700 dark:bg-rose-500/10 dark:text-rose-400';
        default:
            return 'bg-muted text-muted-foreground';
    }
};

export const reminderDotClass = (tone: PillTone): string => {
    switch (tone) {
        case 'negative':
            return 'bg-rose-500';
        case 'warning':
            return 'bg-amber-500';
        case 'positive':
            return 'bg-emerald-500';
        default:
            return 'bg-sky-500';
    }
};
