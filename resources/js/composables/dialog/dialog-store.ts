import { ref, shallowRef } from 'vue';
import type { DialogInstance } from './types';

const dialogs = new Map<string, DialogInstance<any>>();

export function registerDialog<T>(id: string) {
    if (dialogs.has(id)) {
        return dialogs.get(id) as DialogInstance<T>;
    }

    const open = ref(false);
    const data = shallowRef<T | null>(null);

    const instance: DialogInstance<T> = {
        id,
        open,
        data,
        close: () => {
            open.value = false;
            data.value = null;
        },
    };

    dialogs.set(id, instance);

    return instance;
}

export function getDialog<T>(id: string) {
    return dialogs.get(id) as DialogInstance<T> | undefined;
}

