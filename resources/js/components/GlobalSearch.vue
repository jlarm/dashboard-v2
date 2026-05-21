<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import {
    Building2,
    CornerDownLeft,
    FileText,
    FlaskConical,
    GraduationCap,
    Loader2,
    Search,
    Users,
} from 'lucide-vue-next';
import {
    DialogContent,
    DialogDescription,
    DialogOverlay,
    DialogPortal,
    DialogRoot,
    DialogTitle,
    VisuallyHidden,
} from 'reka-ui';
import {
    computed,
    nextTick,
    onBeforeUnmount,
    onMounted,
    ref,
    watch,
    type Component,
    type ComponentPublicInstance,
} from 'vue';
import { search } from '@/routes/dealer';

interface SearchResult {
    type: string;
    id: string;
    title: string;
    subtitle: string;
    url: string;
}

interface SearchGroup {
    key: string;
    label: string;
    items: SearchResult[];
}

interface DisplayItem extends SearchResult {
    flatIndex: number;
}

interface DisplayGroup {
    key: string;
    label: string;
    icon: Component;
    items: DisplayItem[];
}

const MIN_TERM_LENGTH = 2;
const DEBOUNCE_MS = 250;

const groupIcons: Record<string, Component> = {
    employees: Users,
    vendors: Building2,
    documents: FileText,
    sds: FlaskConical,
    courses: GraduationCap,
};

const open = ref(false);
const query = ref('');
const groups = ref<SearchGroup[]>([]);
const loading = ref(false);
const activeIndex = ref(0);
const inputEl = ref<HTMLInputElement | null>(null);
const itemEls = ref<Record<number, HTMLElement>>({});

function detectIsMac(): boolean {
    if (typeof navigator === 'undefined') {
        return false;
    }

    const uaPlatform = (
        navigator as Navigator & { userAgentData?: { platform?: string } }
    ).userAgentData?.platform;

    if (uaPlatform) {
        return uaPlatform.toLowerCase().includes('mac');
    }

    return /Mac|iPhone|iPad/i.test(navigator.userAgent);
}

const shortcutLabel = detectIsMac() ? '⌘K' : 'Ctrl K';

const trimmedQuery = computed(() => query.value.trim());

const displayGroups = computed<DisplayGroup[]>(() => {
    let flatIndex = 0;

    return groups.value.map((group) => ({
        key: group.key,
        label: group.label,
        icon: groupIcons[group.key] ?? FileText,
        items: group.items.map((item) => ({
            ...item,
            flatIndex: flatIndex++,
        })),
    }));
});

const flatItems = computed<DisplayItem[]>(() =>
    displayGroups.value.flatMap((group) => group.items),
);

const hasResults = computed(() => flatItems.value.length > 0);

const showEmptyState = computed(
    () =>
        !loading.value &&
        !hasResults.value &&
        trimmedQuery.value.length >= MIN_TERM_LENGTH,
);

const showHint = computed(() => trimmedQuery.value.length < MIN_TERM_LENGTH);

let debounceTimer: ReturnType<typeof setTimeout> | undefined;
let activeController: AbortController | null = null;

watch(query, () => {
    window.clearTimeout(debounceTimer);
    const term = query.value.trim();

    if (term.length < MIN_TERM_LENGTH) {
        activeController?.abort();
        groups.value = [];
        loading.value = false;

        return;
    }

    loading.value = true;
    debounceTimer = setTimeout(() => runSearch(term), DEBOUNCE_MS);
});

async function runSearch(term: string): Promise<void> {
    activeController?.abort();
    const controller = new AbortController();
    activeController = controller;

    try {
        const response = await fetch(search.url({ query: { q: term } }), {
            headers: {
                Accept: 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            credentials: 'same-origin',
            signal: controller.signal,
        });

        if (!response.ok) {
            groups.value = [];

            return;
        }

        const data = (await response.json()) as { groups?: SearchGroup[] };
        groups.value = (data.groups ?? []).filter(
            (group) => group.items.length > 0,
        );
        activeIndex.value = 0;
    } catch (error) {
        if ((error as Error).name !== 'AbortError') {
            groups.value = [];
        }
    } finally {
        if (activeController === controller) {
            loading.value = false;
            activeController = null;
        }
    }
}

function openPalette(): void {
    open.value = true;
}

function closePalette(): void {
    open.value = false;
}

watch(open, async (isOpen) => {
    if (isOpen) {
        await nextTick();
        inputEl.value?.focus();

        return;
    }

    window.clearTimeout(debounceTimer);
    activeController?.abort();
    query.value = '';
    groups.value = [];
    activeIndex.value = 0;
    loading.value = false;
});

function moveActive(delta: number): void {
    const total = flatItems.value.length;

    if (total === 0) {
        return;
    }

    activeIndex.value = (activeIndex.value + delta + total) % total;
    scrollActiveIntoView();
}

function scrollActiveIntoView(): void {
    nextTick(() => {
        itemEls.value[activeIndex.value]?.scrollIntoView({ block: 'nearest' });
    });
}

function selectActive(): void {
    const item = flatItems.value[activeIndex.value];

    if (item) {
        navigateTo(item);
    }
}

function navigateTo(item: SearchResult): void {
    closePalette();
    router.visit(item.url);
}

function onInputKeydown(event: KeyboardEvent): void {
    if (event.key === 'ArrowDown') {
        event.preventDefault();
        moveActive(1);
    } else if (event.key === 'ArrowUp') {
        event.preventDefault();
        moveActive(-1);
    } else if (event.key === 'Enter') {
        event.preventDefault();
        selectActive();
    }
}

function setItemRef(
    el: Element | ComponentPublicInstance | null,
    index: number,
): void {
    if (el instanceof HTMLElement) {
        itemEls.value[index] = el;
    } else {
        delete itemEls.value[index];
    }
}

function onGlobalKeydown(event: KeyboardEvent): void {
    if ((event.metaKey || event.ctrlKey) && event.key.toLowerCase() === 'k') {
        event.preventDefault();
        open.value = !open.value;
    }
}

onMounted(() => document.addEventListener('keydown', onGlobalKeydown));
onBeforeUnmount(() => {
    document.removeEventListener('keydown', onGlobalKeydown);
    window.clearTimeout(debounceTimer);
    activeController?.abort();
});
</script>

<template>
    <slot name="trigger" :open="openPalette" :shortcut="shortcutLabel">
        <button
            type="button"
            aria-label="Search"
            class="inline-flex h-9 cursor-pointer items-center gap-2 rounded-lg border border-input bg-background px-3 text-sm text-muted-foreground transition-colors hover:bg-accent hover:text-accent-foreground focus-visible:ring-2 focus-visible:ring-ring focus-visible:outline-none"
            @click="openPalette"
        >
            <Search class="size-4" />
            <span class="hidden md:inline">Search</span>
            <kbd
                class="ml-1 hidden h-5 items-center rounded border border-border bg-muted px-1.5 font-mono text-[10px] font-medium md:inline-flex"
            >
                {{ shortcutLabel }}
            </kbd>
        </button>
    </slot>

    <DialogRoot v-model:open="open">
        <DialogPortal>
            <DialogOverlay
                class="fixed inset-0 z-50 bg-black/50 data-[state=open]:animate-in data-[state=closed]:animate-out data-[state=open]:fade-in-0 data-[state=closed]:fade-out-0"
            />
            <DialogContent
                class="fixed left-1/2 top-[12vh] z-50 w-[calc(100%-2rem)] max-w-lg -translate-x-1/2 overflow-hidden rounded-xl border border-border bg-popover text-popover-foreground shadow-2xl data-[state=open]:animate-in data-[state=closed]:animate-out data-[state=open]:fade-in-0 data-[state=closed]:fade-out-0 data-[state=open]:zoom-in-95 data-[state=closed]:zoom-out-95"
            >
                <VisuallyHidden>
                    <DialogTitle>Search</DialogTitle>
                    <DialogDescription>
                        Search employees, vendors, documents, safety data
                        sheets, and courses.
                    </DialogDescription>
                </VisuallyHidden>

                <div
                    class="flex items-center gap-2.5 border-b border-border px-3.5"
                >
                    <Search class="size-4 shrink-0 text-muted-foreground" />
                    <input
                        ref="inputEl"
                        v-model="query"
                        type="text"
                        placeholder="Search employees, vendors, documents, courses…"
                        autocomplete="off"
                        spellcheck="false"
                        class="h-11 w-full border-0 bg-transparent p-0 text-sm text-foreground outline-none placeholder:text-muted-foreground focus:border-0 focus:outline-none focus:ring-0"
                        @keydown="onInputKeydown"
                    />
                    <Loader2
                        v-if="loading"
                        class="size-4 shrink-0 animate-spin text-muted-foreground"
                    />
                </div>

                <div
                    class="max-h-[19rem] overflow-x-hidden overflow-y-auto py-1.5"
                >
                    <p
                        v-if="showHint"
                        class="px-4 py-6 text-center text-sm text-muted-foreground"
                    >
                        Type at least {{ MIN_TERM_LENGTH }} characters to
                        search.
                    </p>

                    <p
                        v-else-if="showEmptyState"
                        class="px-4 py-6 text-center text-sm text-muted-foreground"
                    >
                        No results for &ldquo;{{ trimmedQuery }}&rdquo;.
                    </p>

                    <div
                        v-for="group in displayGroups"
                        :key="group.key"
                        class="mb-1 last:mb-0"
                    >
                        <p
                            class="px-3.5 pb-0.5 pt-1.5 text-[11px] font-medium text-muted-foreground"
                        >
                            {{ group.label }}
                        </p>
                        <button
                            v-for="item in group.items"
                            :key="item.id"
                            :ref="(el) => setItemRef(el, item.flatIndex)"
                            type="button"
                            class="flex w-full items-center gap-2.5 px-3.5 py-1.5 text-left transition-colors"
                            :class="
                                item.flatIndex === activeIndex
                                    ? 'bg-accent text-accent-foreground'
                                    : 'text-foreground'
                            "
                            @mousemove="activeIndex = item.flatIndex"
                            @click="navigateTo(item)"
                        >
                            <span
                                class="flex size-7 shrink-0 items-center justify-center rounded-md bg-muted text-muted-foreground"
                            >
                                <component
                                    :is="group.icon"
                                    class="size-3.5"
                                />
                            </span>
                            <span class="min-w-0 flex-1">
                                <span
                                    class="block truncate text-sm font-medium"
                                >
                                    {{ item.title }}
                                </span>
                                <span
                                    class="block truncate text-xs text-muted-foreground"
                                >
                                    {{ item.subtitle }}
                                </span>
                            </span>
                            <CornerDownLeft
                                v-if="item.flatIndex === activeIndex"
                                class="size-4 shrink-0 text-muted-foreground"
                            />
                        </button>
                    </div>
                </div>

                <div
                    class="flex items-center gap-3 border-t border-border bg-muted/40 px-3.5 py-2 text-[11px] text-muted-foreground"
                >
                    <span class="flex items-center gap-1.5">
                        <kbd
                            class="inline-flex h-5 min-w-5 items-center justify-center rounded border border-border bg-background px-1 font-mono text-[10px]"
                        >
                            ↵
                        </kbd>
                        to select
                    </span>
                    <span class="flex items-center gap-1.5">
                        <kbd
                            class="inline-flex h-5 min-w-5 items-center justify-center rounded border border-border bg-background px-1 font-mono text-[10px]"
                        >
                            ↑
                        </kbd>
                        <kbd
                            class="inline-flex h-5 min-w-5 items-center justify-center rounded border border-border bg-background px-1 font-mono text-[10px]"
                        >
                            ↓
                        </kbd>
                        to navigate
                    </span>
                    <span class="flex items-center gap-1.5">
                        <kbd
                            class="inline-flex h-5 min-w-5 items-center justify-center rounded border border-border bg-background px-1 font-mono text-[10px]"
                        >
                            esc
                        </kbd>
                        to close
                    </span>
                </div>
            </DialogContent>
        </DialogPortal>
    </DialogRoot>
</template>
