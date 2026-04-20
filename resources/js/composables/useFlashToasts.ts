import { router } from '@inertiajs/vue3';
import { onBeforeUnmount } from 'vue';
import { toast } from 'vue-sonner';

type FlashShape = {
    message?: string;
    success?: string;
    error?: string;
    warning?: string;
    info?: string;
};

export function useFlashToasts(): void {
    const stop = router.on('flash', (event) => {
        const flash = event.detail.flash as FlashShape;

        if (flash.success) {
            toast.success(flash.success);
        }
        if (flash.error) {
            toast.error(flash.error);
        }
        if (flash.warning) {
            toast.warning(flash.warning);
        }
        if (flash.info) {
            toast.info(flash.info);
        }
        if (flash.message) {
            toast.success(flash.message);
        }
    });

    onBeforeUnmount(() => {
        stop();
    });
}
