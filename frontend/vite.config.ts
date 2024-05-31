import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import path from 'path'
// https://vitejs.dev/config/
export default defineConfig({
  plugins: [vue()],
  server: {
    host: '0.0.0.0', // Ouça em todas as interfaces de rede
    watch: {
      usePolling: true, // Use polling para detectar mudanças
    },
    port: 5173
  },
  resolve: {
    alias: {
      '@': path.resolve('./src'),
      '@components': path.resolve('./src/components'),
      '@views': path.resolve('./src/views'),
      '@assets': path.resolve('./src/assets'),
      // Adicione mais alias conforme necessário
    },
  },
})
