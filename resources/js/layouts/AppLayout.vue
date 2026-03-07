<script setup lang="ts">
import { Toaster } from 'vue-sonner';
import { useToastManager } from '@/composables/toast/useToastManager';
import 'vue-sonner/style.css';
import AppLayout from '@/layouts/app/AppHeaderLayout.vue';
import type { BreadcrumbItem } from '@/types';

type Props = {
    breadcrumbs?: BreadcrumbItem[];
};

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});

useToastManager();
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <slot />
        <Toaster position="top-center" richColors />
    </AppLayout>
</template>
