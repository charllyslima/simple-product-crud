<template>
  <div
      v-if="isVisible"
      class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-30"
  >
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-lg">
      <h2 class="text-xl font-bold mb-6">{{ isEdit ? 'Atualizar Produto' : 'Criar Novo Produto' }}</h2>
      <form @submit.prevent="handleSubmit">
        <div class="mb-4">
          <label for="name" class="block text-gray-700">Nome</label>
          <input
              type="text"
              v-model="product.name"
              id="name"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
          />
        </div>
        <div class="mb-4">
          <label for="category" class="block text-gray-700">Categoria</label>
          <select
              v-model="product.category_id"
              id="category"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
          >
            <option v-for="category in categories" :key="category.id" :value="category.id">
              {{ category.name }}
            </option>
          </select>
        </div>
        <div class="mb-4">
          <label for="price" class="block text-gray-700">Preço</label>
          <input
              type="number"
              v-model="product.price"
              id="price"
              required
              step="0.01"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
          />
        </div>
        <div class="mb-4">
          <label for="picture" class="block text-sm font-medium text-gray-700">Foto</label>
          <input type="file" @change="handleFileUpload" id="picture" class="mt-1 block w-full p-2 border rounded" accept="image/*" />
        </div>
        <div class="mb-4">
          <label for="situation" class="block text-gray-700">Situação</label>
          <div class="flex items-center space-x-4">
            <div>
              <input
                  type="radio"
                  id="situation-active"
                  :value="true"
                  v-model="product.situation"
                  :checked="product.situation"
                  class="mr-2"
              />
              <label for="situation-active">Ativo</label>
            </div>
            <div>
              <input
                  type="radio"
                  id="situation-inactive"
                  :value="false"
                  v-model="product.situation"
                  :checked="!product.situation"
                  class="mr-2"
              />
              <label for="situation-inactive">Inativo</label>
            </div>
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
import {defineComponent, PropType, ref, watch} from 'vue';
import { createProduct, updateProduct } from '@/api/product.ts';
import {useLoaderStore} from "@/store/loaderStore.ts";

export default defineComponent({
  props: {
    categories: {
      type: Object as PropType<[ICategory]>,
      required: true
    },
    product: {
      type: Object,
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
    const product = ref({ ...props.product });
    const categories = ref({...props.categories});

    watch(() => props.product, (newProduct) => {
      product.value = { ...newProduct };
    }, { deep: true, immediate: true });

    const handleFileUpload = (event: Event) => {
      const target = event.target as HTMLInputElement;
      const files = target.files;
      if (files && files[0]) {
        const reader = new FileReader();
        reader.onload = () => {
          product.value.picture = reader.result as string;
        };
        reader.readAsDataURL(files[0]);
      }
    };
    const handleSubmit = async () => {
      useLoaderStore().startLoading()
      try {
        if (props.isEdit) {
          if (product.value.id) {
            await updateProduct(product.value.id, product.value);
          }
        } else {
          await createProduct(product.value);
        }
        emit('success');
      } catch (error) {
        console.error(error);
      }
      useLoaderStore().stopLoading()
    };

    return {
      product,
      categories,
      handleSubmit,
      handleFileUpload
    };
  }
});
</script>

<style scoped>

</style>
