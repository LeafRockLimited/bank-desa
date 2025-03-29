import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path';

export default defineConfig({
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js'),
            '@components': path.resolve(__dirname, 'resources/js/Components'), // Pastikan sesuai dengan casing folder
            '@ui': path.resolve(__dirname, 'resources/js/Components/ui'),
            '@lib': path.resolve(__dirname, 'resources/js/lib'),
            '@hooks': path.resolve(__dirname, 'resources/js/hooks'),
        },
    },
    plugins: [
        laravel({
            input: 'resources/js/app.js',
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
});
