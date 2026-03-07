<script setup lang="ts">
import { Form } from '@inertiajs/vue3';
import AttendanceDayController from '@/actions/App/Http/Controllers/AttendanceDayController';
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
import type { Employee } from '@/types';

defineProps<{
    employees: Employee[];
}>();

const { isOpen, close } = useDialogManager('add-attendance-day');
</script>

<template>
    <Dialog v-model:open="isOpen">
        <DialogContent
            class="flex flex-col gap-0 overflow-y-visible p-0 sm:max-w-lg [&>button:last-child]:top-3.5"
        >
            <DialogHeader class="contents space-y-0 text-left">
                <DialogTitle class="border-b px-6 py-4 text-base">
                    Add attendance day
                </DialogTitle>
            </DialogHeader>
            <DialogDescription class="sr-only">
                Fill in the details to create a new attendance day record.
            </DialogDescription>

            <Form
                :action="AttendanceDayController.store()"
                disableWhileProcessing
                resetOnSuccess
                :onSuccess="() => close()"
                v-slot="{ errors, processing }"
            >
                <div class="overflow-y-auto p-6">
                    <div class="space-y-4">
                        <div class="*:not-first:mt-2">
                            <Label for="add-employee">Employee</Label>
                            <Select name="employee_id">
                                <SelectTrigger id="add-employee" class="w-full">
                                    <SelectValue placeholder="Select an employee" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem
                                        v-for="employee in employees"
                                        :key="employee.id"
                                        :value="String(employee.id)"
                                    >
                                        {{ employee.first_name }} {{ employee.last_name }}
                                        <span class="text-muted-foreground ml-1 text-xs">({{ employee.employee_number }})</span>
                                    </SelectItem>
                                </SelectContent>
                            </Select>
                            <InputError :message="errors.employee_id" />
                        </div>

                        <div class="*:not-first:mt-2">
                            <Label for="add-work-date">Work Date</Label>
                            <Input
                                id="add-work-date"
                                name="work_date"
                                type="date"
                                required
                            />
                            <InputError :message="errors.work_date" />
                        </div>

                        <div class="*:not-first:mt-2">
                            <Label for="add-status">Status</Label>
                            <Select name="status" required>
                                <SelectTrigger id="add-status" class="w-full">
                                    <SelectValue placeholder="Select status" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="present">Present</SelectItem>
                                    <SelectItem value="late">Late</SelectItem>
                                    <SelectItem value="absent">Absent</SelectItem>
                                    <SelectItem value="leave">Leave</SelectItem>
                                    <SelectItem value="holiday">Holiday</SelectItem>
                                </SelectContent>
                            </Select>
                            <InputError :message="errors.status" />
                        </div>

                        <div class="*:not-first:mt-2">
                            <Label for="add-remarks">Remarks</Label>
                            <Input
                                id="add-remarks"
                                name="remarks"
                                type="text"
                                placeholder="Optional remarks..."
                            />
                            <InputError :message="errors.remarks" />
                        </div>
                    </div>
                </div>

                <DialogFooter class="border-t px-6 py-4">
                    <DialogClose asChild>
                        <Button type="button" variant="outline">Cancel</Button>
                    </DialogClose>
                    <Button :disabled="processing">Add attendance day</Button>
                </DialogFooter>
            </Form>
        </DialogContent>
    </Dialog>
</template>

