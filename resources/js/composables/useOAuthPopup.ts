import { router } from '@inertiajs/vue3';

interface OAuthMessage {
    type: 'oauth';
    provider: string;
    status: 'success' | 'error';
}

export function useOAuthPopup() {
    const open = (provider: string) => {
        const width = 500;
        const height = 600;

        const left = window.screenX + (window.outerWidth - width) / 2;
        const top = window.screenY + (window.outerHeight - height) / 2;

        const popup = window.open(
            `/oauth/${provider}/redirect`,
            'oauthPopup',
            `width=${width},height=${height},left=${left},top=${top}`,
        );

        if (!popup) {
            alert('Popup blocked. Please allow popups.');
            return;
        }

        const listener = (event: MessageEvent<OAuthMessage>) => {
            if (event.origin !== window.location.origin) return;

            if (event.data?.type === 'oauth') {
                window.removeEventListener('message', listener);

                if (event.data.status === 'success') {
                    router.reload({ only: ['auth'] });
                }
            }
        };

        window.addEventListener('message', listener);
    };

    return {
        login: open,
    };
}
