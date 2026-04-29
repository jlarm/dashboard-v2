import { router } from '@inertiajs/vue3';
import { onBeforeUnmount } from 'vue';
import { toast } from 'vue-sonner';

type FlashShape = {
    message?: string | null;
    success?: string | null;
    error?: string | null;
    warning?: string | null;
    info?: string | null;
};

export function useFlashToasts(): void {
    let lastFlashSignature: string | null = null;

    const stop = router.on('success', (event) => {
        const flash = (event.detail.page.props as { flash?: FlashShape }).flash;

        if (!flash) {
            return;
        }

        const signature = JSON.stringify([
            flash.success ?? null,
            flash.error ?? null,
            flash.warning ?? null,
            flash.info ?? null,
            flash.message ?? null,
        ]);

        if (signature === lastFlashSignature) {
            return;
        }
        lastFlashSignature = signature;

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
