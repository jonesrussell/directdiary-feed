import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            ssr: 'resources/js/ssr.js',
            refresh: true,
            publicDirectory: 'public',
            buildDirectory: 'build',
            base: process.env.ASSET_URL || '/',
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    server: {
        host: true,
        strictPort: true,
        port: 5173,
        hmr: {
            protocol: 'wss',
            host: 'directdiary-feed.ddev.site',
            clientPort: 5173
        }
    },
});
