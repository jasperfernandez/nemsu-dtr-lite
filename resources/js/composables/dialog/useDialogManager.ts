import { registerDialog } from './dialog-store';

export function useDialogManager<T = any>(id: string) {
    const dialog = registerDialog<T>(id);

    function open(payload?: T) {
        if (payload !== undefined) {
            dialog.data.value = payload;
        }
        dialog.open.value = true;
    }

    function close() {
        dialog.close();
    }

    return {
        open,
        close,
        dialog,
        data: dialog.data,
        isOpen: dialog.open,
    };
}
