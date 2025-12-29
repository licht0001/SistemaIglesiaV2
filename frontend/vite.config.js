import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        vue(),
        tailwindcss(),
    ],
    server: {
        port: 5173,
        cors: true,
        proxy: {
            '/api': {
                target: 'http://127.0.0.1:8000',
                changeOrigin: true,
                headers: {
                    Accept: 'application/json',
                    "Content-Type": "application/json",
                },
            },
        },
    },
});
