<template>
  <div class="bg-white rounded pt-8 pb-16">
    <div class="max-w-6xl mx-auto px-4">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-center mb-8">Gerenciador de produtos</h1>
        <button
            @click="showCreateForm"
            class="bg-green-500 text-white py-2 px-4 rounded-md hover:bg-green-600 transition duration-200"
        >
          Cadastrar produto
        </button>
      </div>
      <ProductForm v-if="showForm"
                   :categories="categories"
                   :isEdit="isEdit"
                   :product="selectedProduct"
                   :isVisible="showForm"
                   @success="fetchProducts"
                   @close="showForm = false"/>
      <ProductList
          :products="products"
          :categories="categories"
          @edit="editProduct"
          @delete="deleteProduct"
          @update:products="updateProducts"
      ></ProductList>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref, onMounted } from 'vue';
import ProductForm from './components/ProductForm.vue';
import ProductList from './components/ProductList.vue';
import { deleteProduct, getProducts } from "@/api/product.ts";
import CategoryList from "@views/category/components/CategoryList.vue";
import { useLoaderStore } from "@/store/loaderStore.ts";
import CategoryForm from "@views/category/components/CategoryForm.vue";
import { searchCategory } from "@/api/category.ts";

export default defineComponent({
  components: { CategoryForm, CategoryList, ProductForm, ProductList },
  setup() {
    const products = ref({} as IListResponse<IProduct>);
    const categories = ref([] as ICategory[]);
    const selectedProduct = ref<IProduct>({} as IProduct);
    const showForm = ref(false);
    const isEdit = ref(false);
    const isLoading = ref(true);

    const fetchProducts = async () => {
      showForm.value = false
      useLoaderStore().startLoading()
      try {
        const response = await getProducts();
        products.value = response.data.data;
      } catch (error) {
        console.error(error);
      }
      useLoaderStore().stopLoading()
    };

    const updateProducts = (newProducts: IListResponse<IProduct>) => {
      products.value = newProducts.data;
    };

    const showCreateForm = () => {
      selectedProduct.value = { id: 0, name: '', situation: false };
      isEdit.value = false;
      showForm.value = true;
    };

    const editProduct = (product: IProduct) => {
      useLoaderStore().startLoading();
      selectedProduct.value = { ...product };
      isEdit.value = true;
      showForm.value = true;
      useLoaderStore().stopLoading();
    };

    const handleDeleteProduct = async (id: number) => {
      useLoaderStore().startLoading();
      try {
        await deleteProduct(id);
        await fetchProducts();
      } catch (error) {
        console.error(error);
      } finally {
        useLoaderStore().stopLoading();
      }
    };

    const fetchCategories = async () => {
      try {
        const response = await searchCategory('all');
        categories.value = response.data.data;
      } catch (error) {
        console.error(error);
      }
    };

    onMounted(async () => {
      useLoaderStore().startLoading();
      await fetchProducts();
      await fetchCategories();
      useLoaderStore().stopLoading();
      isLoading.value = false;
    });

    return {
      products,
      categories,
      showForm,
      isEdit,
      selectedProduct,
      showCreateForm,
      fetchProducts,
      editProduct,
      deleteProduct: handleDeleteProduct,
      updateProducts,
      isLoading,
    };
  },
});
</script>