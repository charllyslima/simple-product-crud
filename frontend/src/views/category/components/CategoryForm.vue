<template>
  <div
      v-if="isVisible"
      class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50"
  >
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-lg">
      <h2 class="text-xl font-bold mb-6">{{ isEdit ? 'Atualizar categoria' : 'Criar nova categoria' }}</h2>
      <form @submit.prevent="handleSubmit">
        <div class="mb-4">
          <label for="name" class="block text-gray-700">Nome</label>
          <input
              type="text"
              v-model="category.name"
              id="name"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
          >
        </div>
        <div class="mb-4">
          <label class="block text-gray-700">Situação</label>
          <div class="flex items-center space-x-4">
            <label class="flex items-center">
              <input
                  type="radio"
                  v-model="category.situation"
                  :value="true"
                  :checked="category.situation"
                  class="form-radio"
              >
              <span class="ml-2">Ativo</span>
            </label>
            <label class="flex items-center">
              <input
                  type="radio"
                  v-model="category.situation"
                  :checked="!category.situation"
                  :value="false"
                  class="form-radio"
              >
              <span class="ml-2">Inativo</span>
            </label>
          </div>
        </div>
        <div class="flex justify-between space-x-2">
          <button
              type="submit"
              class="w-full bg-indigo-500 text-white py-2 px-4 rounded-md hover:bg-indigo-600 transition duration-200"
          >
            {{ isEdit ? 'Atualizar' : 'Criar' }}
          </button>
          <button
              type="button"
              class="w-full bg-gray-500 text-white py-2 px-4 rounded-md hover:bg-gray-600 transition duration-200"
              @click="$emit('close')"
          >
            Cancelar
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref, watch, PropType } from 'vue';
import { createCategory, updateCategory } from "@/api/category.ts";
import { useLoaderStore } from "@/store/loaderStore.ts";

export default defineComponent({
  props: {
    category: {
      type: Object as PropType<ICategory>,
      required: true
    },
    isEdit: {
      type: Boolean,
      default: false
    },
    isVisible: {
      type: Boolean,
      required: true
    }
  },
  setup(props, { emit }) {
    const category = ref({ ...props.category });

    watch(() => props.category, (newCategory) => {
      category.value = { ...newCategory };
    }, { deep: true, immediate: true });

    const handleSubmit = async () => {
      useLoaderStore().startLoading();
      try {
        if (props.isEdit) {
          if (category.value.id) {
            await updateCategory(category.value.id, category.value);
          }
        } else {
          await createCategory(category.value);
        }
        emit('success');
      } catch (error) {
        console.error(error);
      } finally {
        useLoaderStore().stopLoading();
      }
    };

    return {
      category,
      handleSubmit
    };
  }
});
</script>

<style scoped>
.form-radio {
  transition: background-color 0.2s;
}
</style>
