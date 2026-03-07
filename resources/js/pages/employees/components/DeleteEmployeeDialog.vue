<script setup lang="ts">
import { Form } from '@inertiajs/vue3';
import { Trash } from 'lucide-vue-next';
import EmployeeController from '@/actions/App/Http/Controllers/EmployeeController';
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
} from '@/components/ui/alert-dialog';
import { Button } from '@/components/ui/button';
import { useDialogManager } from '@/composables/dialog/useDialogManager';
import type { Employee } from '@/types';

const { isOpen, data, close } = useDialogManager<Employee>('delete-employee');
</script>

<template>
    <AlertDialog v-model:open="isOpen">
        <AlertDialogContent>
            <div class="flex flex-col gap-2 max-sm:items-center sm:flex-row sm:gap-4">
                <div
                    class="flex size-9 shrink-0 items-center justify-center rounded-full border"
                    aria-hidden="true"
                >
                    <Trash
                        class="size-4 text-destructive opacity-80"
                        aria-hidden="true"
                    />
                </div>
                <AlertDialogHeader>
                    <AlertDialogTitle>Are you absolutely sure?</AlertDialogTitle>
                    <AlertDialogDescription>
                        This action cannot be undone. This will permanently delete
                        <span v-if="data" class="font-medium">{{ data.first_name }} {{ data.last_name }}</span>
                        and remove their data from the database.
                    </AlertDialogDescription>
                </AlertDialogHeader>
            </div>
            <AlertDialogFooter>
                <AlertDialogCancel>Cancel</AlertDialogCancel>
                <AlertDialogAction asChild>
                    <Form
                        v-if="data"
                        :action="EmployeeController.destroy(data.id)"
                        :onSuccess="() => close()"
                    >
                        <Button type="submit" variant="destructive">Delete</Button>
                    </Form>
                </AlertDialogAction>
            </AlertDialogFooter>
        </AlertDialogContent>
    </AlertDialog>
</template>

