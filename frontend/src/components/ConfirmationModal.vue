<template>
  <div
      v-if="isVisible"
      class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50"
  >
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
      <h2 class="text-xl font-bold mb-4">Confirmar Ação</h2>
      <p class="mb-6">{{ message }}</p>
      <div class="flex justify-end space-x-4">
        <button
            class="bg-gray-500 text-white py-2 px-4 rounded-md hover:bg-gray-600 transition duration-200"
            @click="$emit('close')"
        >
          Cancelar
        </button>
        <button
            class="bg-red-500 text-white py-2 px-4 rounded-md hover:bg-red-600 transition duration-200"
            @click="$emit('confirm')"
        >
          Confirmar
        </button>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
  props: {
    isVisible: {
      type: Boolean,
      required: true
    },
    message: {
      type: String,
      default: 'Tem certeza que deseja realizar esta ação?'
    }
  }
});
</script>
