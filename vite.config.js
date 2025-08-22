import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue2';
import { fileURLToPath, URL } from 'node:url';

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/js/app.js',
        'resources/js/admin.js',
        'resources/sass/app.scss',
        'resources/sass/style.scss',
        'resources/js/components/dogRun.js',
        'resources/js/components/locationSearch.js',
        'resources/js/components/googleMaps.js',
        'resources/js/components/dogFood.js',
      ],
      refresh: true,
    }),
    vue(),
  ],
  build: {
    rollupOptions: {
      output: {
        entryFileNames: 'js/[name].js',        // ハッシュなし
        chunkFileNames: 'js/[name].js',        // ハッシュなし
        assetFileNames: 'js/[name].[ext]'      // ハッシュなし
      }
    }
  },
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./resources', import.meta.url)),
      '@images': fileURLToPath(new URL('./public/images', import.meta.url)),
    },
  },
  css: {
    preprocessorOptions: {
      scss: {
        // additionalData: `@import "resources/sass/_variables";`,
        quietDeps: true, // Bootstrapの非推奨警告を抑制
        silenceDeprecations: ['import', 'global-builtin', 'color-functions', 'slash-div', 'mixed-decls'],
      },
    },
  },
});
