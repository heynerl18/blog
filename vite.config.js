import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/css/app.css',
        'resources/css/home.css',
        'resources/js/app.js',
        'resources/js/main.js',
      ],
      refresh: true,
    }),
  ],
  /*server: {
    host: '0.0.0.0',
    port: 5173,
    hmr: {
      host: 'http://localhost:8000'
    }
  }*/
});