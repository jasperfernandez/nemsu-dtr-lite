<script setup lang="ts">
import { router, Head, usePage } from '@inertiajs/vue3';
import { CalendarDays, Clock, LogIn, LogOut, TimerOff } from 'lucide-vue-next';
import { computed, onBeforeUnmount, onMounted, ref } from 'vue';
import TimeLogController from '@/actions/App/Http/Controllers/TimeLogController';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { getInitials } from '@/composables/useInitials';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import type { BreadcrumbItem } from '@/types';

type Stats = {
    today_status: 'Present' | 'Late' | null;
    time_in: string | null;
    time_out: string | null;
    log_count: number;
    next_action: 'in' | 'out';
};

const props = defineProps<{ stats: Stats }>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard(),
    },
];

const page = usePage();
const auth = computed(() => page.props.auth);
const user = computed(() => auth.value?.user);
const userName = computed(() => user.value?.name ?? 'Guest');

// Real-time clock
const now = ref(new Date());
let clockInterval: ReturnType<typeof setInterval>;

onMounted(() => {
    clockInterval = setInterval(() => {
        now.value = new Date();
    }, 1000);
});

onBeforeUnmount(() => {
    clearInterval(clockInterval);
});

const formattedTime = computed(() =>
    now.value.toLocaleTimeString('en-PH', {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: true,
    }),
);

const formattedDate = computed(() =>
    now.value.toLocaleDateString('en-PH', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    }),
);

// Time log
const isLogging = ref(false);

function logTime() {
    isLogging.value = true;
    router.post(
        TimeLogController().url,
        {},
        {
            onFinish: () => {
                isLogging.value = false;
            },
        },
    );
}

const statusVariant = computed(() => {
    if (props.stats.today_status === 'Late') return 'destructive';
    if (props.stats.today_status === 'Present') return 'default';
    return 'secondary';
});
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 p-4 md:p-6">

            <!-- Welcome Card -->
            <Card>
                <CardHeader>
                    <div class="flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
                        <!-- User info -->
                        <div class="flex items-center gap-4">
                            <Avatar class="size-14">
                                <AvatarImage
                                    v-if="user?.avatar"
                                    :src="user.avatar!"
                                    :alt="userName"
                                />
                                <AvatarFallback class="text-lg font-semibold">
                                    {{ getInitials(userName) }}
                                </AvatarFallback>
                            </Avatar>
                            <div>
                                <CardTitle class="text-2xl">
                                    Welcome back, {{ userName }}!
                                </CardTitle>
                                <CardDescription>
                                    Here's your attendance overview for today.
                                </CardDescription>
                            </div>
                        </div>

                        <!-- Clock + Log Time button -->
                        <div class="flex flex-col items-start gap-2 sm:items-end">
                            <div class="flex items-center gap-2">
                                <Clock class="size-4 text-muted-foreground" />
                                <span class="font-mono text-2xl font-semibold tabular-nums">
                                    {{ formattedTime }}
                                </span>
                            </div>
                            <div class="flex items-center gap-1.5 text-sm text-muted-foreground">
                                <CalendarDays class="size-4" />
                                <span>{{ formattedDate }}</span>
                            </div>
                            <Button
                                :disabled="isLogging"
                                size="lg"
                                class="mt-1 w-full sm:w-auto"
                                @click="logTime"
                            >
                                <TimerOff v-if="isLogging" class="size-4 animate-pulse" />
                                <LogOut v-else-if="stats.next_action === 'out'" class="size-4" />
                                <LogIn v-else class="size-4" />
                                {{ isLogging ? 'Logging...' : stats.next_action === 'out' ? 'Time Out' : 'Time In' }}
                            </Button>
                        </div>
                    </div>
                </CardHeader>
            </Card>

            <!-- Stats Row -->
            <div class="grid gap-4 md:grid-cols-3">
                <!-- Today's Status -->
                <Card>
                    <CardHeader class="pb-2">
                        <CardDescription>Today's Status</CardDescription>
                        <CardTitle class="text-3xl">
                            <Badge
                                v-if="stats.today_status"
                                :variant="statusVariant"
                                class="text-sm"
                            >
                                {{ stats.today_status }}
                            </Badge>
                            <span v-else class="text-muted-foreground">—</span>
                        </CardTitle>
                    </CardHeader>
                    <CardContent>
                        <p class="text-xs text-muted-foreground">
                            {{ stats.log_count > 0 ? `${stats.log_count} log${stats.log_count > 1 ? 's' : ''} recorded today` : 'No logs yet for today' }}
                        </p>
                    </CardContent>
                </Card>

                <!-- Time In -->
                <Card>
                    <CardHeader class="pb-2">
                        <CardDescription>Time In</CardDescription>
                        <CardTitle class="text-3xl font-mono tabular-nums">
                            <span v-if="stats.time_in" class="flex items-center gap-2">
                                <LogIn class="size-6 text-green-500" />
                                {{ stats.time_in }}
                            </span>
                            <span v-else class="text-muted-foreground">—</span>
                        </CardTitle>
                    </CardHeader>
                    <CardContent>
                        <p class="text-xs text-muted-foreground">First log of the day</p>
                    </CardContent>
                </Card>

                <!-- Time Out -->
                <Card>
                    <CardHeader class="pb-2">
                        <CardDescription>Time Out</CardDescription>
                        <CardTitle class="text-3xl font-mono tabular-nums">
                            <span v-if="stats.time_out" class="flex items-center gap-2">
                                <LogOut class="size-6 text-red-500" />
                                {{ stats.time_out }}
                            </span>
                            <span v-else class="text-muted-foreground">—</span>
                        </CardTitle>
                    </CardHeader>
                    <CardContent>
                        <p class="text-xs text-muted-foreground">Last log of the day</p>
                    </CardContent>
                </Card>
            </div>

        </div>
    </AppLayout>
</template>
