<template>
  <div class="mx-auto mt-8">
    <table class="min-w-full bg-white shadow-md rounded-lg" v-if="categories?.data?.length">
      <thead>
      <tr>
        <th class="py-2 px-4 bg-gray-100 text-left text-gray-700">Nome</th>
        <th class="py-2 px-4 bg-gray-100 text-left text-gray-700">Situação</th>
        <th class="py-2 px-4 bg-gray-100 text-left text-gray-700">Ações</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="category in categories?.data" :key="category.id" class="border-t">
        <td class="py-2 px-4">{{ category.name }}</td>
        <td class="py-2 px-4">
            <span :class="{'text-green-500': category.situation, 'text-red-500': !category.situation}">
              {{ category.situation ? 'Ativo' : 'Inativo' }}
            </span>
        </td>
        <td class="py-2 px-4">
          <button
              @click="$emit('edit', category)"
              class="bg-blue-500 text-white py-1 px-3 rounded-md hover:bg-blue-600 transition duration-200 mr-2"
          >
            Editar
          </button>
          <button
              @click="confirmDelete(category.id)"
              class="bg-red-500 text-white py-1 px-3 rounded-md hover:bg-red-600 transition duration-200"
          >
            Apagar
          </button>
        </td>
      </tr>
      </tbody>
    </table>
    <div v-else class="flex items-center bg-blue-500 text-white text-sm font-bold px-4 py-3 mt-4" role="alert">
      <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
        <path
            d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z"/>
      </svg>
      <p>Nenhum dado foi encontrado</p>
    </div>
    <Pagination
        :response="categories"
        @page-changed="fetchPage"
    />
    <ConfirmationModal
        v-if="showModal"
        :isVisible="showModal"
        message="Tem certeza que deseja apagar esta categoria? Os produtos vinculados também serão apagados!"
        @confirm="handleDelete"
        @close="showModal = false"
    />
  </div>
</template>

<script lang="ts">
import {defineComponent, PropType, ref} from 'vue';
import ConfirmationModal from "@components/ConfirmationModal.vue";
import Pagination from "@components/Pagination.vue";
import apiClient from "@/services/axios.ts";
import {useLoaderStore} from "@/store/loaderStore.ts";

export default defineComponent({
  components: {
    Pagination,
    ConfirmationModal
  },
  props: {
    categories: {
      type: Object as PropType<IListResponse<ICategory>>,
      required: true
    }
  },
  setup(_, {emit}) {
    const showModal = ref(false);
    const categoryIdToDelete = ref<number | null>(null);
    const confirmDelete = (id: number) => {
      categoryIdToDelete.value = id;
      showModal.value = true;
    };

    const fetchPage = async (url: string) => {
      useLoaderStore().startLoading()
      try {
        const response = await apiClient.get<IListResponse<ICategory>>(url);
        emit('update:categories', response.data);
      } catch (error) {
        console.error('Error fetching data:', error);
      }
      useLoaderStore().stopLoading()
    };
    const handleDelete = () => {
      if (categoryIdToDelete.value !== null) {
        emit('delete', categoryIdToDelete.value);
        showModal.value = false;
      }
    };

    return {
      showModal,
      confirmDelete,
      handleDelete,
      fetchPage
    };
  }
});
</script>
