<script setup lang="ts">
import {
    NavigationMenu,
    NavigationMenuItem,
    NavigationMenuLink,
    NavigationMenuList,
} from '@/components/ui/navigation-menu';
import { useCurrentUrl } from '@/composables/useCurrentUrl';
import employees from '@/routes/dealer/employees';
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

type NavKey = 'import';

type NavItem =
    | { kind: 'link'; name: string; href: string }
    | { kind: 'action'; name: string; key: NavKey }
    | { kind: 'disabled'; name: string };

const emit = defineEmits<{
    (e: 'import'): void;
}>();

const page = usePage<{ auth: { roles: string[] } }>();
const roles = computed(() => page.props.auth?.roles ?? []);
const isSuperAdmin = computed(() => roles.value.includes('super-admin'));
const isManager = computed(() => roles.value.includes('Manager') && !isSuperAdmin.value);

const navItems = computed<NavItem[]>(() => [
    { kind: 'link', name: 'Employees', href: employees.index.url() },
    ...(isSuperAdmin.value ? [{ kind: 'action', name: 'Import', key: 'import' } as const] : []),
    { kind: 'link', name: 'Invite Employee', href: employees.invite.url() },
    { kind: 'link', name: 'Open Invites', href: employees.openInvites.url() },
    ...(isManager.value ? [] : [{ kind: 'link', name: 'Deleted', href: employees.deleted.url() } as const]),
]);

const { currentUrl, isCurrentUrl } = useCurrentUrl();

const linkPrefixes = computed(() =>
    navItems.value
        .filter((item): item is { kind: 'link'; name: string; href: string } => item.kind === 'link')
        .map((item) => item.href),
);

const isActiveLink = (href: string): boolean => {
    if (isCurrentUrl(href)) {
        return true;
    }

    if (href !== employees.index.url()) {
        return false;
    }

    // The Employees link covers per-employee show pages too — but not the
    // sibling nav links (invite, open-invites, deleted) which have their own
    // entries and shouldn't double-highlight.
    if (!currentUrl.value.startsWith(href)) {
        return false;
    }

    return !linkPrefixes.value
        .filter((prefix) => prefix !== href)
        .some((prefix) => currentUrl.value.startsWith(prefix));
};

const activeClasses =
    'hover:bg-primary/10 hover:text-primary focus:bg-primary/10 focus:text-primary data-active:bg-primary/10 data-active:text-primary data-active:focus:bg-primary/10 data-active:hover:bg-primary/10';
const disabledClasses = 'cursor-not-allowed text-muted-foreground opacity-60';
</script>

<template>
    <NavigationMenu>
        <NavigationMenuList>
            <NavigationMenuItem v-for="item in navItems" :key="item.name">
                <template v-if="item.kind === 'link'">
                    <NavigationMenuLink
                        as-child
                        :active="isActiveLink(item.href)"
                        :class="activeClasses"
                    >
                        <Link :href="item.href">{{ item.name }}</Link>
                    </NavigationMenuLink>
                </template>
                <template v-else-if="item.kind === 'action'">
                    <NavigationMenuLink
                        as-child
                        :class="activeClasses"
                    >
                        <button type="button" class="cursor-pointer" @click="emit(item.key)">
                            {{ item.name }}
                        </button>
                    </NavigationMenuLink>
                </template>
                <template v-else>
                    <NavigationMenuLink
                        as="span"
                        aria-disabled="true"
                        :class="disabledClasses"
                    >
                        {{ item.name }}
                    </NavigationMenuLink>
                </template>
            </NavigationMenuItem>
        </NavigationMenuList>
    </NavigationMenu>
</template>
