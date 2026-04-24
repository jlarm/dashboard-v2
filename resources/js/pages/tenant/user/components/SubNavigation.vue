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

type NavItem = {
    name: string;
    href: string;
    disabled: boolean;
};

const navItems: NavItem[] = [
    { name: 'Employees', href: employees.index.url(), disabled: false },
    { name: 'Import', href: '#', disabled: true },
    { name: 'Invite Employee', href: '#', disabled: true },
    { name: 'Open Invites', href: '#', disabled: true },
    { name: 'Deleted', href: '#', disabled: true },
];

const { isCurrentUrl } = useCurrentUrl();
</script>

<template>
    <NavigationMenu>
        <NavigationMenuList>
            <NavigationMenuItem v-for="item in navItems" :key="item.name">
                <NavigationMenuLink
                    v-if="item.disabled"
                    as="span"
                    aria-disabled="true"
                    class="cursor-not-allowed text-muted-foreground opacity-60"
                >
                    {{ item.name }}
                </NavigationMenuLink>
                <NavigationMenuLink
                    v-else
                    as-child
                    :active="isCurrentUrl(item.href)"
                    class="data-active:bg-primary/10 data-active:text-primary data-active:focus:bg-primary/10 data-active:hover:bg-primary/10"
                >
                    <Link :href="item.href">{{ item.name }}</Link>
                </NavigationMenuLink>
            </NavigationMenuItem>
        </NavigationMenuList>
    </NavigationMenu>
</template>
