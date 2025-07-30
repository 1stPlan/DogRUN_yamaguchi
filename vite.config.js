import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue2';
import path from 'path';

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/js/app.js',
        'resources/js/admin.js',
        'resources/sass/app.scss',
        'resources/sass/style.scss',
      ],
      refresh: true,
    }),
    vue(),
  ],
  resolve: {
    alias: {
      '@': path.resolve(__dirname, './resources'),
      '@images': path.resolve(__dirname, './public/images'),
    },
  },
  css: {
    preprocessorOptions: {
      scss: {
        // additionalData: `@import "resources/sass/_variables";`,
      },
    },
  },
});
