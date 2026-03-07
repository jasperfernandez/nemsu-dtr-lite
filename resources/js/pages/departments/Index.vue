<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import DepartmentController from '@/actions/App/Http/Controllers/DepartmentController';
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
import type { BreadcrumbItem, Department } from '@/types';
import AddDepartmentDialog from './components/AddDepartmentDialog.vue';
import DeleteDepartmentDialog from './components/DeleteDepartmentDialog.vue';
import EditDepartmentDialog from './components/EditDepartmentDialog.vue';

defineProps<{
    departments: Department[];
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Departments',
        href: DepartmentController.index(),
    },
];

const addDialog = useDialogManager('add-department');
const editDialog = useDialogManager<Department>('edit-department');
const deleteDialog = useDialogManager<Department>('delete-department');
</script>

<template>
    <Head title="Departments" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div class="flex items-center justify-between">
                <Heading title="Departments" />
                <Button size="lg" @click="addDialog.open()"
                    >Add Department</Button
                >
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
                                >Code</TableHead
                            >
                            <TableHead
                                class="h-12 px-4 text-left align-middle font-medium text-muted-foreground"
                                >Name</TableHead
                            >
                            <TableHead
                                class="h-12 px-4 text-left align-middle font-medium text-muted-foreground"
                                >Created At</TableHead
                            >
                            <TableHead
                                class="h-12 px-4 text-left align-middle font-medium text-muted-foreground"
                                >Actions</TableHead
                            >
                        </TableRow>
                    </TableHeader>
                    <TableBody class="[&_tr:last-child]:border-0">
                        <TableRow
                            v-for="department in departments"
                            :key="department.id"
                            class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted"
                        >
                            <TableCell class="p-4 align-middle">{{
                                department.id
                            }}</TableCell>
                            <TableCell class="p-4 align-middle">{{
                                department.code
                            }}</TableCell>
                            <TableCell class="p-4 align-middle">{{
                                department.name
                            }}</TableCell>
                            <TableCell class="p-4 align-middle">{{
                                new Date(
                                    department.created_at,
                                ).toLocaleDateString()
                            }}</TableCell>
                            <TableCell class="p-4 align-middle">
                                <Button
                                    variant="link"
                                    @click="editDialog.open(department)"
                                    >Edit</Button
                                >
                                <Button
                                    variant="link"
                                    class="text-destructive"
                                    @click="deleteDialog.open(department)"
                                    >Delete</Button
                                >
                            </TableCell>
                        </TableRow>
                        <TableEmpty
                            v-if="departments.length === 0"
                            :colspan="5"
                        >
                            No departments found.
                        </TableEmpty>
                    </TableBody>
                </Table>
            </div>
        </div>

        <AddDepartmentDialog />
        <EditDepartmentDialog />
        <DeleteDepartmentDialog />
    </AppLayout>
</template>
