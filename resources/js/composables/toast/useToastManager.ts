import { usePage } from '@inertiajs/vue3';
import { watch } from 'vue';
import { success, error } from './toast-store';

export function useToastManager() {
    const page = usePage();

    watch(
        () => page.props.flash,
        (flash) => {
            if (!flash) return;

            if (flash.success) success(flash.success);
            if (flash.error) error(flash.error);
        },
        { immediate: true },
    );
}
