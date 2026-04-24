<script setup lang="ts">
import {
    NavigationMenu,
    NavigationMenuItem,
    NavigationMenuLink,
    NavigationMenuList,
} from '@/components/ui/navigation-menu';
import { useCurrentUrl } from '@/composables/useCurrentUrl';
import employees from '@/routes/dealer/employees';
import { Link } from '@inertiajs/vue3';

type NavKey = 'import';

type NavItem =
    | { kind: 'link'; name: string; href: string }
    | { kind: 'action'; name: string; key: NavKey }
    | { kind: 'disabled'; name: string };

const emit = defineEmits<{
    (e: 'import'): void;
}>();

const navItems: NavItem[] = [
    { kind: 'link', name: 'Employees', href: employees.index.url() },
    { kind: 'action', name: 'Import', key: 'import' },
    { kind: 'link', name: 'Invite Employee', href: employees.invite.url() },
    { kind: 'link', name: 'Open Invites', href: employees.openInvites.url() },
    { kind: 'link', name: 'Deleted', href: employees.deleted.url() },
];

const { isCurrentUrl } = useCurrentUrl();

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
                        :active="isCurrentUrl(item.href)"
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
