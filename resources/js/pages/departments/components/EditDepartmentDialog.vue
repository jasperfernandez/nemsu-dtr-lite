<script setup lang="ts">
import { Form } from '@inertiajs/vue3';
import DepartmentController from '@/actions/App/Http/Controllers/DepartmentController';
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
import { useDialogManager } from '@/composables/dialog/useDialogManager';
import type { Department } from '@/types';

const { isOpen, data, close } = useDialogManager<Department>('edit-department');
</script>

<template>
    <Dialog v-model:open="isOpen">
        <DialogContent
            class="flex flex-col gap-0 overflow-y-visible p-0 sm:max-w-lg [&>button:last-child]:top-3.5"
        >
            <DialogHeader class="contents space-y-0 text-left">
                <DialogTitle class="border-b px-6 py-4 text-base">
                    Edit department
                </DialogTitle>
            </DialogHeader>
            <DialogDescription class="sr-only">
                Make changes to the department.
            </DialogDescription>

            <Form
                v-if="data"
                :action="DepartmentController.update(data.id)"
                disableWhileProcessing
                resetOnSuccess
                :onSuccess="() => close()"
                v-slot="{ errors, processing }"
            >
                <div class="overflow-y-auto p-6">
                    <div class="space-y-4">
                        <div class="*:not-first:mt-2">
                            <Label for="edit-code">Code</Label>
                            <Input
                                :defaultValue="data.code"
                                id="edit-code"
                                name="code"
                                placeholder="ICTU"
                                type="text"
                                required
                            />
                            <InputError :message="errors.code" />
                        </div>
                        <div class="*:not-first:mt-2">
                            <Label for="edit-name">Name</Label>
                            <Input
                                :defaultValue="data.name"
                                id="edit-name"
                                name="name"
                                placeholder="Information and Communication Technology Unit"
                                required
                            />
                            <InputError :message="errors.name" />
                        </div>
                    </div>
                </div>

                <DialogFooter class="border-t px-6 py-4">
                    <DialogClose asChild>
                        <Button type="button" variant="outline">Cancel</Button>
                    </DialogClose>
                    <Button :disabled="processing">Save changes</Button>
                </DialogFooter>
            </Form>
        </DialogContent>
    </Dialog>
</template>

