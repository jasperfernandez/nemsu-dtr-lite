<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import LinkEmployeeController from '@/actions/App/Http/Controllers/LinkEmployeeController';
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import type { Department } from '@/types';

defineProps<{
    first_name: string;
    last_name: string;
    departments: Department[];
}>();
</script>

<template>
    <Head title="Link Employee Profile" />

    <div class="flex min-h-svh flex-col items-center justify-center gap-6 bg-background p-6 md:p-10">
        <div class="w-full max-w-md">
            <div class="flex flex-col gap-8">
                <div class="flex flex-col items-center gap-4">
                    <div class="mb-1 flex h-9 w-9 items-center justify-center rounded-md">
                        <AppLogoIcon class="size-9 fill-current text-foreground" />
                    </div>
                    <div class="space-y-2 text-center">
                        <h1 class="text-xl font-medium">Link your employee profile</h1>
                        <p class="text-center text-sm text-muted-foreground">
                            Complete your employee information to continue.
                        </p>
                    </div>
                </div>

                <Form
                    :action="LinkEmployeeController.store()"
                    disableWhileProcessing
                    v-slot="{ errors, processing }"
                    class="flex flex-col gap-5"
                >
                    <div class="grid grid-cols-2 gap-4">
                        <div class="grid gap-2">
                            <Label for="first_name">First Name</Label>
                            <Input
                                id="first_name"
                                name="first_name"
                                type="text"
                                :default-value="first_name"
                                required
                                placeholder="Juan"
                            />
                            <InputError :message="errors.first_name" />
                        </div>
                        <div class="grid gap-2">
                            <Label for="last_name">Last Name</Label>
                            <Input
                                id="last_name"
                                name="last_name"
                                type="text"
                                :default-value="last_name"
                                required
                                placeholder="Dela Cruz"
                            />
                            <InputError :message="errors.last_name" />
                        </div>
                    </div>

                    <div class="grid gap-2">
                        <Label for="employee_number">Employee Number</Label>
                        <Input
                            id="employee_number"
                            name="employee_number"
                            type="text"
                            required
                            placeholder="101"
                        />
                        <InputError :message="errors.employee_number" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="department_id">
                            Department
                            <span class="text-muted-foreground">(Optional)</span>
                        </Label>
                        <Select name="department_id">
                            <SelectTrigger id="department_id" class="w-full">
                                <SelectValue placeholder="Select department" />
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

                    <div class="grid gap-2">
                        <Label for="position">
                            Position
                            <span class="text-muted-foreground">(Optional)</span>
                        </Label>
                        <Input
                            id="position"
                            name="position"
                            type="text"
                            placeholder="Software Engineer"
                        />
                        <InputError :message="errors.position" />
                    </div>

                    <Button type="submit" class="w-full" :disabled="processing">
                        Save &amp; Continue
                    </Button>
                </Form>
            </div>
        </div>
    </div>
</template>

