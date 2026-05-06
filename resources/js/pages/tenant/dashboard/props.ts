import { usePage } from '@inertiajs/vue3';
import { computed, type ComputedRef } from 'vue';

/**
 * Read a top-level Inertia page prop with a typed fallback when the prop is
 * missing or undefined.
 */
export const usePageProp = <T>(key: string, fallback: T): ComputedRef<T> => {
    const page = usePage();
    return computed<T>(() => ((page.props as Record<string, unknown>)[key] as T | undefined) ?? fallback);
};

/**
 * Read a top-level Inertia page prop that may be explicitly null.
 * Useful for cards that hide entirely when the controller returns null.
 */
export const useNullablePageProp = <T>(key: string): ComputedRef<T | null> => {
    const page = usePage();
    return computed<T | null>(() => ((page.props as Record<string, unknown>)[key] as T | null | undefined) ?? null);
};
