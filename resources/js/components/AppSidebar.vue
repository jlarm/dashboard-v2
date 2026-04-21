<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import {
    GraduationCap,
    Building,
    LayoutGrid,
    Users,
    FileText,
    FolderOpen,
    ScrollText,
    FileWarning
} from 'lucide-vue-next';
import { computed } from 'vue';
import AppLogo from '@/components/AppLogo.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { dashboard } from '@/routes';
import type { Auth, NavItem } from '@/types';
import employees from '@/routes/employees';
import dealerships from "@/routes/dealerships";
import courses from "@/routes/courses";
import documents from "@/routes/documents";
import sharedDocuments from "@/routes/shared-documents";
import contracts from "@/routes/contracts";
import violationStatements from "@/routes/violation-statements";

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: dashboard(),
        icon: LayoutGrid,
    },
    {
        title: 'Employees',
        href: employees.index.url(),
        icon: Users,
        roles: ['super-admin'],
    },
    {
        title: 'Dealerships',
        href: dealerships.index.url(),
        icon: Building,
    },
    {
        title: 'Courses',
        href: courses.index.url(),
        icon: GraduationCap,
    },
    {
        title: 'Documents',
        href: documents.index.url(),
        icon: FileText,
    },
    {
        title: 'Shared Documents',
        href: sharedDocuments.index.url(),
        icon: FolderOpen,
    },
    {
        title: 'Contracts',
        href: contracts.index.url(),
        icon: ScrollText,
    },
    {
        title: 'Violation Statements',
        href: violationStatements.index.url(),
        icon: FileWarning,
    }
];

const page = usePage<{ auth: Auth }>();

const visibleNavItems = computed(() =>
    mainNavItems.filter(
        (item) =>
            !item.roles || item.roles.some((role) => page.props.auth.roles.includes(role)),
    ),
);
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="dashboard()">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="visibleNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
