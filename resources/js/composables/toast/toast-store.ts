import { toast as sonnerToast } from 'vue-sonner';
import type { ToastOptions } from './types';

export function showToast(options: ToastOptions) {
    const { type = 'info', title, description, duration } = options;

    sonnerToast[type](title ?? '', {
        description,
        duration,
    });
}

export function success(message: string) {
    showToast({
        type: 'success',
        title: message,
    });
}

export function error(message: string) {
    showToast({
        type: 'error',
        title: message,
    });
}

export function info(message: string) {
    showToast({
        type: 'info',
        title: message,
    });
}

export function warning(message: string) {
    showToast({
        type: 'warning',
        title: message,
    });
}
