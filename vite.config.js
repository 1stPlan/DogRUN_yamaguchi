import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
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
  ],
  build: {
    rollupOptions: {
      output: {
        entryFileNames: 'js/[name].js',        // JavaScriptファイル
        chunkFileNames: 'js/[name].js',        // JavaScriptチャンク
        assetFileNames: (assetInfo) => {
          const info = assetInfo.name.split('.');
          const ext = info[info.length - 1];
          if (/\.(css)$/.test(assetInfo.name)) {
            return 'css/[name].[ext]';         // CSSファイル
          }
          if (/\.(png|jpe?g|svg|gif|tiff|bmp|ico)$/i.test(assetInfo.name)) {
            return 'images/[name].[ext]';      // 画像ファイル
          }
          if (/\.(woff|woff2|eot|ttf|otf)$/i.test(assetInfo.name)) {
            return 'fonts/[name].[ext]';       // フォントファイル
          }
          return 'assets/[name].[ext]';        // その他のアセット
        }
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
