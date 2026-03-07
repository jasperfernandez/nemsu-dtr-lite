<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { ChevronDown, ChevronRight, Clock, LogIn, LogOut } from 'lucide-vue-next';
import { ref } from 'vue';
import AttendanceDayController from '@/actions/App/Http/Controllers/AttendanceDayController';
import Heading from '@/components/Heading.vue';
import { Badge } from '@/components/ui/badge';
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
import type { AttendanceDay, BreadcrumbItem, Employee } from '@/types';
import AddAttendanceDayDialog from './components/AddAttendanceDayDialog.vue';
import DeleteAttendanceDayDialog from './components/DeleteAttendanceDayDialog.vue';
import EditAttendanceDayDialog from './components/EditAttendanceDayDialog.vue';

defineProps<{
    attendanceDays: AttendanceDay[];
    employees: Employee[];
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Logs',
        href: AttendanceDayController.index(),
    },
];

const addDialog = useDialogManager('add-attendance-day');
const editDialog = useDialogManager<AttendanceDay>('edit-attendance-day');
const deleteDialog = useDialogManager<AttendanceDay>('delete-attendance-day');

const expandedRows = ref<Set<number>>(new Set());

function toggleRow(id: number) {
    if (expandedRows.value.has(id)) {
        expandedRows.value.delete(id);
    } else {
        expandedRows.value.add(id);
    }
}

function isExpanded(id: number) {
    return expandedRows.value.has(id);
}

const statusVariantMap: Record<string, 'default' | 'secondary' | 'destructive' | 'outline'> = {
    present: 'default',
    late: 'secondary',
    absent: 'destructive',
    leave: 'outline',
    holiday: 'outline',
};

function formatDate(dateStr: string) {
    return new Date(dateStr).toLocaleDateString('en-US', {
        weekday: 'short',
        year: 'numeric',
        month: 'short',
        day: 'numeric',
    });
}

function formatTime(dateTimeStr: string) {
    return new Date(dateTimeStr).toLocaleTimeString('en-US', {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
    });
}

function getLogIn(day: AttendanceDay) {
    return day.attendance_logs?.find((l) => l.type === 'in');
}

function getLogOut(day: AttendanceDay) {
    // Last "out" log of the day
    const outs = day.attendance_logs?.filter((l) => l.type === 'out') ?? [];
    return outs[outs.length - 1];
}

function computeDuration(day: AttendanceDay): string | null {
    const logIn = getLogIn(day);
    const logOut = getLogOut(day);
    if (!logIn || !logOut) return null;
    const diff = new Date(logOut.log_time).getTime() - new Date(logIn.log_time).getTime();
    const hours = Math.floor(diff / 3600000);
    const minutes = Math.floor((diff % 3600000) / 60000);
    return `${hours}h ${minutes}m`;
}
</script>

<template>
    <Head title="Logs" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="flex items-center justify-between">
                <Heading title="Logs" description="Daily time records with time-in and time-out logs." />
                <Button size="lg" @click="addDialog.open()">Add Attendance Day</Button>
            </div>

            <div class="rounded-md border">
                <Table class="w-full caption-bottom text-sm">
                    <TableHeader>
                        <TableRow class="border-b transition-colors hover:bg-muted/50">
                            <TableHead class="h-12 w-10 px-4" />
                            <TableHead class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">
                                Work Date
                            </TableHead>
                            <TableHead class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">
                                Employee
                            </TableHead>
                            <TableHead class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">
                                Time In
                            </TableHead>
                            <TableHead class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">
                                Time Out
                            </TableHead>
                            <TableHead class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">
                                Duration
                            </TableHead>
                            <TableHead class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">
                                Logs
                            </TableHead>
                            <TableHead class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">
                                Actions
                            </TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody class="[&_tr:last-child]:border-0">
                        <template v-for="day in attendanceDays" :key="day.id">
                            <!-- Main row -->
                            <TableRow
                                class="border-b transition-colors hover:bg-muted/50"
                                :class="{ 'bg-muted/30': isExpanded(day.id) }"
                            >
                                <!-- Expand toggle -->
                                <TableCell class="w-10 px-4 align-middle">
                                    <Button
                                        v-if="day.attendance_logs && day.attendance_logs.length > 0"
                                        variant="ghost"
                                        size="icon"
                                        class="size-7"
                                        @click="toggleRow(day.id)"
                                        :aria-label="isExpanded(day.id) ? 'Collapse logs' : 'Expand logs'"
                                    >
                                        <ChevronDown
                                            v-if="isExpanded(day.id)"
                                            class="size-4 text-muted-foreground"
                                        />
                                        <ChevronRight
                                            v-else
                                            class="size-4 text-muted-foreground"
                                        />
                                    </Button>
                                </TableCell>

                                <TableCell class="p-4 align-middle font-medium">
                                    {{ formatDate(day.work_date) }}
                                </TableCell>

                                <TableCell class="p-4 align-middle">
                                    <template v-if="day.employee">
                                        <div class="font-medium">
                                            {{ day.employee.first_name }} {{ day.employee.last_name }}
                                        </div>
                                        <div class="text-xs text-muted-foreground">
                                            {{ day.employee.employee_number }}
                                        </div>
                                    </template>
                                    <span v-else class="text-muted-foreground">—</span>
                                </TableCell>

                                <TableCell class="p-4 align-middle">
                                    <span v-if="getLogIn(day)" class="flex items-center gap-1.5 text-emerald-600 dark:text-emerald-400">
                                        <LogIn class="size-3.5 shrink-0" />
                                        {{ formatTime(getLogIn(day)!.log_time) }}
                                    </span>
                                    <span v-else class="text-muted-foreground">—</span>
                                </TableCell>

                                <TableCell class="p-4 align-middle">
                                    <span v-if="getLogOut(day)" class="flex items-center gap-1.5 text-rose-600 dark:text-rose-400">
                                        <LogOut class="size-3.5 shrink-0" />
                                        {{ formatTime(getLogOut(day)!.log_time) }}
                                    </span>
                                    <span v-else class="text-muted-foreground">—</span>
                                </TableCell>

                                <TableCell class="p-4 align-middle">
                                    <span v-if="computeDuration(day)" class="flex items-center gap-1.5 text-muted-foreground">
                                        <Clock class="size-3.5 shrink-0" />
                                        {{ computeDuration(day) }}
                                    </span>
                                    <span v-else class="text-muted-foreground">—</span>
                                </TableCell>

                                <TableCell class="p-4 align-middle">
                                    <Badge variant="secondary">
                                        {{ day.attendance_logs?.length ?? 0 }}
                                    </Badge>
                                </TableCell>

                                <TableCell class="align-middle">
                                    <Button variant="link" @click="editDialog.open(day)">Edit</Button>
                                    <Button
                                        variant="link"
                                        class="text-destructive"
                                        @click="deleteDialog.open(day)"
                                    >Delete</Button>
                                </TableCell>
                            </TableRow>

                            <!-- Expanded logs sub-row -->
                            <TableRow
                                v-if="isExpanded(day.id)"
                                class="border-b bg-muted/20 hover:bg-muted/20"
                            >
                                <TableCell />
                                <TableCell :colspan="8" class="px-4 pb-4 pt-1">
                                    <div class="space-y-1">
                                        <p class="mb-2 text-xs font-medium uppercase tracking-wide text-muted-foreground">
                                            All Logs ({{ day.attendance_logs?.length }})
                                        </p>
                                        <div class="flex flex-wrap gap-2">
                                            <div
                                                v-for="log in day.attendance_logs"
                                                :key="log.id"
                                                class="flex items-center gap-2 rounded-md border bg-background px-3 py-1.5 text-xs"
                                            >
                                                <span
                                                    :class="log.type === 'in'
                                                        ? 'text-emerald-600 dark:text-emerald-400'
                                                        : 'text-rose-600 dark:text-rose-400'"
                                                >
                                                    <LogIn v-if="log.type === 'in'" class="size-3" />
                                                    <LogOut v-else class="size-3" />
                                                </span>
                                                <span class="font-medium capitalize">{{ log.type }}</span>
                                                <span class="text-muted-foreground">{{ formatTime(log.log_time) }}</span>
                                                <Badge variant="outline" class="text-[10px]">
                                                    {{ log.source }}
                                                </Badge>
                                            </div>
                                        </div>
                                        <p v-if="day.remarks" class="mt-2 text-xs text-muted-foreground">
                                            <span class="font-medium">Remarks:</span> {{ day.remarks }}
                                        </p>
                                    </div>
                                </TableCell>
                            </TableRow>
                        </template>

                        <TableEmpty v-if="attendanceDays.length === 0" :colspan="9">
                            No attendance days found.
                        </TableEmpty>
                    </TableBody>
                </Table>
            </div>
        </div>

        <AddAttendanceDayDialog :employees="employees" />
        <EditAttendanceDayDialog :employees="employees" />
        <DeleteAttendanceDayDialog />
    </AppLayout>
</template>

