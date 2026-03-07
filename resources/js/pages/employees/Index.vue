<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import EmployeeController from '@/actions/App/Http/Controllers/EmployeeController';
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import {
    Table,
    TableBody,
    TableCell,
    TableEmpty,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import { useDialogManager } from '@/composables/dialog/useDialogManager';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem, Department, Employee } from '@/types';
import AddEmployeeDialog from './components/AddEmployeeDialog.vue';
import DeleteEmployeeDialog from './components/DeleteEmployeeDialog.vue';
import EditEmployeeDialog from './components/EditEmployeeDialog.vue';

defineProps<{
    employees: Employee[];
    departments: Department[];
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Employees',
        href: EmployeeController.index(),
    },
];

const addDialog = useDialogManager('add-employee');
const editDialog = useDialogManager<Employee>('edit-employee');
const deleteDialog = useDialogManager<Employee>('delete-employee');
</script>

<template>
    <Head title="Employees" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div class="flex items-center justify-between">
                <Heading title="Employees" />
                <Button size="lg" @click="addDialog.open()">Add Employee</Button>
            </div>
            <div class="rounded-md border">
                <Table class="w-full caption-bottom text-sm">
                    <TableHeader>
                        <TableRow
                            class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted"
                        >
                            <TableHead
                                class="h-12 px-4 text-left align-middle font-medium text-muted-foreground"
                                >ID</TableHead
                            >
                            <TableHead
                                class="h-12 px-4 text-left align-middle font-medium text-muted-foreground"
                                >Employee #</TableHead
                            >
                            <TableHead
                                class="h-12 px-4 text-left align-middle font-medium text-muted-foreground"
                                >Full Name</TableHead
                            >
                            <TableHead
                                class="h-12 px-4 text-left align-middle font-medium text-muted-foreground"
                                >Department</TableHead
                            >
                            <TableHead
                                class="h-12 px-4 text-left align-middle font-medium text-muted-foreground"
                                >Email</TableHead
                            >
                            <TableHead
                                class="h-12 px-4 text-left align-middle font-medium text-muted-foreground"
                                >Position</TableHead
                            >
                            <TableHead
                                class="h-12 px-4 text-left align-middle font-medium text-muted-foreground"
                                >Status</TableHead
                            >
                            <TableHead
                                class="h-12 px-4 text-left align-middle font-medium text-muted-foreground"
                                >Actions</TableHead
                            >
                        </TableRow>
                    </TableHeader>
                    <TableBody class="[&_tr:last-child]:border-0">
                        <TableRow
                            v-for="employee in employees"
                            :key="employee.id"
                            class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted"
                        >
                            <TableCell class="p-4 align-middle">{{
                                employee.id
                            }}</TableCell>
                            <TableCell class="p-4 align-middle">{{
                                employee.employee_number
                            }}</TableCell>
                            <TableCell class="p-4 align-middle">{{
                                employee.first_name + ' ' + employee.last_name
                            }}</TableCell>
                            <TableCell class="p-4 align-middle">{{
                                employee.department?.name ?? '—'
                            }}</TableCell>
                            <TableCell class="p-4 align-middle">{{
                                employee.email ?? '—'
                            }}</TableCell>
                            <TableCell class="p-4 align-middle">{{
                                employee.position
                            }}</TableCell>
                            <TableCell class="p-4 align-middle capitalize">{{
                                employee.status
                            }}</TableCell>
                            <TableCell class="align-middle">
                                <Button
                                    variant="link"
                                    @click="editDialog.open(employee)"
                                    >Edit</Button
                                >
                                <Button
                                    variant="link"
                                    class="text-destructive"
                                    @click="deleteDialog.open(employee)"
                                    >Delete</Button
                                >
                            </TableCell>
                        </TableRow>
                        <TableEmpty
                            v-if="employees.length === 0"
                            :colspan="8"
                        >
                            No employees found.
                        </TableEmpty>
                    </TableBody>
                </Table>
            </div>
        </div>

        <AddEmployeeDialog :departments="departments" />
        <EditEmployeeDialog :departments="departments" />
        <DeleteEmployeeDialog />
    </AppLayout>
</template>

