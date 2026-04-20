<script setup lang="ts">
import employees from "@/routes/employees";
import {
    NavigationMenu,
    NavigationMenuItem,
    NavigationMenuLink,
    NavigationMenuList,
} from "@/components/ui/navigation-menu";
import { Link } from "@inertiajs/vue3";
import { useCurrentUrl } from "@/composables/useCurrentUrl";

const navItems = [
    { name: "Employees", href: employees.index.url() },
    { name: "Open Invites", href: employees.invites.url() },
    { name: "Deleted", href: employees.deleted.url() },
];

const { isCurrentUrl } = useCurrentUrl();
</script>

<template>
    <NavigationMenu>
        <NavigationMenuList>
            <NavigationMenuItem v-for="item in navItems" :key="item.name">
                <NavigationMenuLink as-child :active="isCurrentUrl(item.href)">
                    <Link :href="item.href">{{ item.name }}</Link>
                </NavigationMenuLink>
            </NavigationMenuItem>
        </NavigationMenuList>
    </NavigationMenu>
</template>
