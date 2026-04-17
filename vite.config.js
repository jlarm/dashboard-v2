import {defineConfig} from 'vite';
import laravel, {refreshPaths} from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    server: {
        cors: {
            origin: /^https:\/\/([a-z0-9-]+\.)?dashboard\.test$/,
        },
        host: '0.0.0.0',
        port: 5173,
        strictPort: true,
        watch: {
            usePolling: true,
            interval: 120,
        },
        hmr: {
            host: 'dashboard.test',
            port: 5173,
        },
    },
    plugins: [
        laravel({
            detectTls: 'dashboard.test',
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: [
                ...refreshPaths,
                'app/Http/Livewire/**',
                'app/Forms/Components/**',
            ],
        }),
        tailwindcss(),
    ],
});
