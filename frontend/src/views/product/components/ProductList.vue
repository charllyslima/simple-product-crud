<template>
  <div class="mx-auto mt-8">
    <div class="mb-4">
      <select v-model="selectedCategoryId" @change="filterProducts" class="block w-full px-4 py-2 border border-gray-300 rounded shadow-lg">
        <option value="">Todas as Categorias</option>
        <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
      </select>
    </div>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4"  v-if="products?.data?.length">
        <div v-for="product in products?.data" :key="product.id">
          <div class="flex flex-col lg:flex-row max-w-md lg:max-w-full bg-white rounded-lg border border-gray-400 overflow-hidden">
            <div
                class="h-48 lg:h-auto lg:w-48 flex-none bg-cover rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden"
                :style="`background-image: url('${product.picture ? `${imageProccess(product.picture)}` : defaultImage}');`"
                title="Product Image">
            </div>
            <div class="p-4 flex flex-col justify-between leading-normal">
              <div>
                <p class="text-sm text-gray-600 flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 text-yellow-300">
                    <path fill-rule="evenodd" d="M5.25 2.25a3 3 0 0 0-3 3v4.318a3 3 0 0 0 .879 2.121l9.58 9.581c.92.92 2.39 1.186 3.548.428a18.849 18.849 0 0 0 5.441-5.44c.758-1.16.492-2.629-.428-3.548l-9.58-9.581a3 3 0 0 0-2.122-.879H5.25ZM6.375 7.5a1.125 1.125 0 1 0 0-2.25 1.125 1.125 0 0 0 0 2.25Z" clip-rule="evenodd" />
                  </svg>

                  <span class="ps-3">{{ categories.find(item => item.id === product.category_id)?.name }}</span>
                </p>
                <div class="text-gray-900 font-bold text-xl mb-2">{{ product.name }}</div>
              </div>
              <div>
                <div class="text-sm">
              <span :class="{'text-green-500': product.situation, 'text-red-500': !product.situation}">
                {{ product.situation ? 'Ativo' : 'Inativo' }}
              </span>
                  <p class="text-gray-900 leading-none flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 text-green-500 me-2">
                      <path d="M12 7.5a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5Z" />
                      <path fill-rule="evenodd" d="M1.5 4.875C1.5 3.839 2.34 3 3.375 3h17.25c1.035 0 1.875.84 1.875 1.875v9.75c0 1.036-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 0 1 1.5 14.625v-9.75ZM8.25 9.75a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0ZM18.75 9a.75.75 0 0 0-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 0 0 .75-.75V9.75a.75.75 0 0 0-.75-.75h-.008ZM4.5 9.75A.75.75 0 0 1 5.25 9h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H5.25a.75.75 0 0 1-.75-.75V9.75Z" clip-rule="evenodd" />
                      <path d="M2.25 18a.75.75 0 0 0 0 1.5c5.4 0 10.63.722 15.6 2.075 1.19.324 2.4-.558 2.4-1.82V18.75a.75.75 0 0 0-.75-.75H2.25Z" />
                    </svg>

                    R$ {{ product.price }}</p>
                </div>
                <div class="mt-3 flex space-x-2">
                  <button
                      @click="$emit('edit', product)"
                      class="bg-blue-500 text-white py-1 px-3 rounded-md hover:bg-blue-600 transition duration-200"
                  >
                    Editar
                  </button>
                  <button
                      @click="confirmDelete(product.id)"
                      class="bg-red-500 text-white py-1 px-3 rounded-md hover:bg-red-600 transition duration-200"
                  >
                    Apagar
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>


    <div v-else class="flex items-center bg-blue-500 text-white text-sm font-bold px-4 py-3 mt-4" role="alert">
      <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
        <path
            d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z"/>
      </svg>
      <p>Nenhum dado foi encontrado</p>
    </div>
    <Pagination
        :response="products"
        @page-changed="fetchPage"
    />
    <ConfirmationModal
        v-if="showModal"
        :isVisible="showModal"
        message="Tem certeza que deseja apagar este produto?"
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
import defaultImage from "@/assets/box_1524855.png"
import {imageProcess} from "@/utils/imageProcess.ts";

export default defineComponent({
  components: {
    Pagination,
    ConfirmationModal
  },
  props: {
    products: {
      type: Object as PropType<IListResponse<IProduct>>,
      required: true
    },
    categories: {
      type: Object as PropType<[ICategory]>,
      required: true
    },
  },
  setup(_, {emit}) {
    const showModal = ref(false);
    const productIdToDelete = ref<number | null>(null);
    const selectedCategoryId = ref('');
    const confirmDelete = (id: number) => {
      productIdToDelete.value = id;
      showModal.value = true;
    };

    const fetchPage = async (url: string) => {
      useLoaderStore().startLoading()
      try {
        const response = await apiClient.get<IListResponse<IProduct>>(url);
        emit('update:products', response.data);
      } catch (error) {
        console.error('Error fetching data:', error);
      }
      useLoaderStore().stopLoading()
    };
    const handleDelete = () => {
      if (productIdToDelete.value !== null) {
        emit('delete', productIdToDelete.value);
        showModal.value = false;
      }
    };

    const filterProducts = () => {
      emit('filter', selectedCategoryId)
    }

    return {
      showModal,
      confirmDelete,
      handleDelete,
      fetchPage,
      defaultImage,
      imageProccess: imageProcess,
      selectedCategoryId,
      filterProducts
    };
  }
});
</script>
