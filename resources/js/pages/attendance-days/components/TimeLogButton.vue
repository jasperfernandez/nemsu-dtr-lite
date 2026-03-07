<script setup lang="ts">
import { Form } from '@inertiajs/vue3';
import { LogIn, LogOut } from 'lucide-vue-next';
import TimeLogController from '@/actions/App/Http/Controllers/TimeLogController';
import { Button } from '@/components/ui/button';
import type { AttendanceLog } from '@/types';

const props = defineProps<{
    lastLog?: AttendanceLog;
}>();

const isTimedIn = props.lastLog?.type === 'in';
</script>

<template>
    <Form :action="TimeLogController()" disableWhileProcessing v-slot="{ processing }">
        <Button type="submit" size="lg" :disabled="processing" :variant="isTimedIn ? 'destructive' : 'default'">
            <LogOut v-if="isTimedIn" class="size-4" />
            <LogIn v-else class="size-4" />
            {{ isTimedIn ? 'Time Out' : 'Time In' }}
        </Button>
    </Form>
</template>

