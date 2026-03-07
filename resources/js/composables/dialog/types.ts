import type { Ref, ShallowRef } from 'vue';

export interface DialogInstance<T = any> {
    id: string;
    open: Ref<boolean>;
    data: ShallowRef<T | null>;
    close: () => void;
}
