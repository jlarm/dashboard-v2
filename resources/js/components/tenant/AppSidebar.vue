<script setup lang="ts">
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/tenant/NavUser.vue';
import StoreSwitcher from '@/components/tenant/StoreSwitcher.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
} from '@/components/ui/sidebar';
import { DOCUMENT_VIEWERS, EMPLOYEE_SECTION_VIEWERS, Role } from '@/constants/roles';
import doc from '@/routes/dealer/doc';
import employees from '@/routes/dealer/employees';
import logs from '@/routes/dealer/logs';
import sds from '@/routes/dealer/sds';
import { dashboard } from '@/routes/dealer';
import type { NavItem } from '@/types';
import { FileText, FlaskConical, LayoutGrid, ScrollText, Users } from 'lucide-vue-next';

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
        roles: EMPLOYEE_SECTION_VIEWERS,
    },
    {
        title: 'Documents',
        href: doc.index.url(),
        icon: FileText,
        roles: DOCUMENT_VIEWERS,
    },
    {
        title: 'SDS Sheets',
        href: sds.index.url(),
        icon: FlaskConical,
    },
];

const footerNavItems: NavItem[] = [
    {
        title: 'Activity Logs',
        href: logs.index.url(),
        icon: ScrollText,
        roles: [Role.SuperAdmin, Role.Consultant],
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <StoreSwitcher />
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavMain :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
