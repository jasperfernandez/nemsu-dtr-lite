import { usePage } from '@inertiajs/vue3';

export function useAuthorization() {
    const { auth } = usePage().props;

    const roles = auth.roles;

    const can = (ability: string) => auth.can?.[ability];

    const isHr = () => auth.roles.includes('hr');
    const isEmployee = () => auth.roles.includes('employee');

    return {
        roles,
        can,
        isHr,
        isEmployee,
    };
}
