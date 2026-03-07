export type ToastType = 'success' | 'error' | 'info' | 'warning';

export interface ToastOptions {
    title?: string;
    description?: string;
    type?: ToastType;
    duration?: number;
}
