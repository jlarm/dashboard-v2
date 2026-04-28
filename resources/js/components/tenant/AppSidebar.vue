<script setup lang="ts">
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/tenant/NavUser.vue';
import StoreSwitcher from '@/components/tenant/StoreSwitcher.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
} from '@/components/ui/sidebar';
import { AUTOMATED_REPORT_VIEWERS, DOCUMENT_VIEWERS, EMPLOYEE_SECTION_VIEWERS, Role, VENDOR_VIEWERS } from '@/constants/roles';
import doc from '@/routes/dealer/doc';
import employees from '@/routes/dealer/employees';
import locations from '@/routes/dealer/locations';
import logs from '@/routes/dealer/logs';
import sds from '@/routes/dealer/sds';
import vendor from '@/routes/dealer/vendor';
import settings from '@/routes/dealer/settings';
import automatedReports from '@/routes/dealer/settings/automated-reports';
import { dashboard } from '@/routes/dealer';
import type { NavItem } from '@/types';
import { Building2, FileText, FileBarChart2, FlaskConical, Handshake, LayoutGrid, ScrollText, Settings, Users } from 'lucide-vue-next';

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
    {
        title: 'Vendors',
        href: vendor.index.url(),
        icon: Handshake,
        roles: VENDOR_VIEWERS,
    },
];

const page = usePage<{ auth: { current_store_id: number | null } }>();

const showGlobalSettings = computed<boolean>(() => page.props.auth?.current_store_id === null);

const footerNavItems = computed<NavItem[]>(() => {
    const items: NavItem[] = [];

    if (showGlobalSettings.value) {
        items.push({
            title: 'Global Settings',
            href: settings.global.url(),
            icon: Settings,
            roles: [Role.SuperAdmin, Role.Consultant],
        });
    }

    items.push(
        {
            title: 'Automated Reports',
            href: automatedReports.index.url(),
            icon: FileBarChart2,
            roles: AUTOMATED_REPORT_VIEWERS,
        },
        {
            title: 'Locations',
            href: locations.index.url(),
            icon: Building2,
            roles: [Role.SuperAdmin, Role.Consultant],
        },
        {
            title: 'Activity Logs',
            href: logs.index.url(),
            icon: ScrollText,
            roles: [Role.SuperAdmin, Role.Consultant],
        },
    );

    return items;
});
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
