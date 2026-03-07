<script setup lang="ts">
import { Form } from '@inertiajs/vue3';
import EmployeeController from '@/actions/App/Http/Controllers/EmployeeController';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { useDialogManager } from '@/composables/dialog/useDialogManager';
import type { Department } from '@/types';

defineProps<{
    departments: Department[];
}>();

const { isOpen, close } = useDialogManager('add-employee');
</script>

<template>
    <Dialog v-model:open="isOpen">
        <DialogContent
            class="flex flex-col gap-0 overflow-y-visible p-0 sm:max-w-lg [&>button:last-child]:top-3.5"
        >
            <DialogHeader class="contents space-y-0 text-left">
                <DialogTitle class="border-b px-6 py-4 text-base">
                    Add employee
                </DialogTitle>
            </DialogHeader>
            <DialogDescription class="sr-only">
                Fill in the details to create a new employee.
            </DialogDescription>

            <Form
                :action="EmployeeController.store()"
                disableWhileProcessing
                resetOnSuccess
                :onSuccess="() => close()"
                v-slot="{ errors, processing }"
            >
                <div class="overflow-y-auto p-6">
                    <div class="space-y-4">
                        <div class="*:not-first:mt-2">
                            <Label for="add-employee-number"
                                >Employee Number</Label
                            >
                            <Input
                                id="add-employee-number"
                                name="employee_number"
                                placeholder="101"
                                type="text"
                                required
                            />
                            <InputError :message="errors.employee_number" />
                        </div>
                        <div class="*:not-first:mt-2">
                            <Label for="add-email">Email</Label>
                            <Input
                                id="add-email"
                                name="email"
                                placeholder="juan@example.com"
                                type="email"
                                required
                            />
                            <InputError :message="errors.email" />
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="*:not-first:mt-2">
                                <Label for="add-first-name">First Name</Label>
                                <Input
                                    id="add-first-name"
                                    name="first_name"
                                    placeholder="Juan"
                                    type="text"
                                    required
                                />
                                <InputError :message="errors.first_name" />
                            </div>
                            <div class="*:not-first:mt-2">
                                <Label for="add-last-name">Last Name</Label>
                                <Input
                                    id="add-last-name"
                                    name="last_name"
                                    placeholder="Dela Cruz"
                                    type="text"
                                    required
                                />
                                <InputError :message="errors.last_name" />
                            </div>
                        </div>
                        <div class="*:not-first:mt-2">
                            <Label for="add-position"
                                >Position
                                <span class="text-muted-foreground"
                                    >(Optional)</span
                                ></Label
                            >
                            <Input
                                id="add-position"
                                name="position"
                                placeholder="Software Engineer"
                                type="text"
                            />
                            <InputError :message="errors.position" />
                        </div>
                        <div class="*:not-first:mt-2">
                            <Label for="add-department"
                                >Department
                                <span class="text-muted-foreground"
                                    >(Optional)</span
                                ></Label
                            >
                            <Select name="department_id">
                                <SelectTrigger id="add-department" class="w-full">
                                    <SelectValue
                                        placeholder="Select department"
                                    />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem
                                        v-for="department in departments"
                                        :key="department.id"
                                        :value="String(department.id)"
                                    >
                                        {{ department.name }}
                                    </SelectItem>
                                </SelectContent>
                            </Select>
                            <InputError :message="errors.department_id" />
                        </div>
                        <div class="*:not-first:mt-2">
                            <Label for="add-status">Status</Label>
                            <Select defaultValue="active" name="status" required>
                                <SelectTrigger id="add-status" class="w-full">
                                    <SelectValue placeholder="Select status" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="active"
                                        >Active</SelectItem
                                    >
                                    <SelectItem value="inactive"
                                        >Inactive</SelectItem
                                    >
                                </SelectContent>
                            </Select>
                            <InputError :message="errors.status" />
                        </div>
                    </div>
                </div>

                <DialogFooter class="border-t px-6 py-4">
                    <DialogClose asChild>
                        <Button type="button" variant="outline">Cancel</Button>
                    </DialogClose>
                    <Button :disabled="processing">Add employee</Button>
                </DialogFooter>
            </Form>
        </DialogContent>
    </Dialog>
</template>
