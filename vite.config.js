import { defineConfig } from 'vite';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [tailwindcss()],
    build: {
        cssMinify: true,
        emptyOutDir: true,
        outDir: 'dist',
        rollupOptions: {
            input: {
                theme: 'resources/theme.js',
                styles: 'resources/theme.css',
            },
            output: {
                entryFileNames: 'theme.js',
                assetFileNames: (asset) => asset.name?.endsWith('.css') ? 'theme.css' : '[name][extname]',
            },
        },
    },
});
