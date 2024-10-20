import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            ssr: 'resources/js/ssr.js',
            refresh: true,
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
        // respond to all network requests (same as '0.0.0.0')
        host: true,
        // we need a strict port to match on PHP side
        strictPort: true,
        port: 5173,
        hmr: {
            // Force the Vite client to connect via SSL
            // This will also force a "https://" URL in the hot file
            protocol: 'wss',
            // The host where the Vite dev server can be accessed
            // This will also force this host to be written to the hot file
            host: `${process.env.DDEV_HOSTNAME}`,
        }
    },
});
