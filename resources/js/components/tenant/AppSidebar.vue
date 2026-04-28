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
import { DOCUMENT_VIEWERS, EMPLOYEE_SECTION_VIEWERS } from '@/constants/roles';
import doc from '@/routes/dealer/doc';
import employees from '@/routes/dealer/employees';
import sds from '@/routes/dealer/sds';
import { dashboard } from '@/routes/dealer';
import type { NavItem } from '@/types';
import { FileText, FlaskConical, LayoutGrid, Users } from 'lucide-vue-next';

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
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
