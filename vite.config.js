import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    server: {
        host: true,
        origin: 'http://192.168.1.127:5173'
    },
    /*server: {
        host: true,
        origin: 'https://9895202e409c.ngrok-free.app' // Reemplaza esto con tu URL real
    }*/
});