<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Building2, CalendarDays, LayoutGrid, Users } from 'lucide-vue-next';
import AttendanceDayController from '@/actions/App/Http/Controllers/AttendanceDayController';
import DepartmentController from '@/actions/App/Http/Controllers/DepartmentController';
import EmployeeController from '@/actions/App/Http/Controllers/EmployeeController';
import AppLogo from '@/components/AppLogo.vue';
import NavFooter from '@/components/NavFooter.vue';
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
import type { NavItem } from '@/types';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: dashboard(),
        icon: LayoutGrid,
    },
    {
        title: 'Attendance Days',
        href: AttendanceDayController.index(),
        icon: CalendarDays,
    },
    {
        title: 'Employees',
        href: EmployeeController.index(),
        icon: Users,
    },
    {
        title: 'Departments',
        href: DepartmentController.index(),
        icon: Building2,
    },
];

const footerNavItems: NavItem[] = [];
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
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
