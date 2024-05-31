<template>
  <div class="bg-white rounded pt-8 pb-16">
    <div class="max-w-6xl mx-auto px-4">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-center mb-8">Gerenciador de categorias</h1>
        <button
            @click="showCreateForm"
            class="bg-green-500 text-white py-2 px-4 rounded-md hover:bg-green-600 transition duration-200"
        >
          Criar nova categoria
        </button>
      </div>
      <CategoryForm
          v-if="showForm"
          :category="selectedCategory"
          :isEdit="isEdit"
          :isVisible="showForm"
          @success="fetchCategories"
          @close="showForm = false"
      ></CategoryForm>
      <CategoryList
          :categories="categories"
          @edit="editCategory"
          @delete="deleteCategory"
          @update:categories="updateCategories"
      ></CategoryList>
    </div>
  </div>
</template>

<script lang="ts">
import {defineComponent, ref, onMounted} from 'vue'
import CategoryForm from "@views/category/components/CategoryForm.vue"
import CategoryList from "@views/category/components/CategoryList.vue"
import {deleteCategory, getCategories} from "@/api/category.ts"
import {useLoaderStore} from "@/store/loaderStore.ts"

export default defineComponent({
  components: {
    CategoryForm,
    CategoryList
  },
  setup() {
    const categories = ref({} as IListResponse<ICategory>)
    const selectedCategory = ref<ICategory>({} as ICategory)
    const showForm = ref(false)
    const isEdit = ref(false)

    const updateCategories = (newCategories: IListResponse<ICategory>) => {
      categories.value = newCategories.data
    }
    const fetchCategories = async () => {
      showForm.value = false
      useLoaderStore().startLoading()
      try {
        const response = await getCategories()
        categories.value = response.data.data
      } catch (error) {
        console.error(error)
      }
      useLoaderStore().stopLoading()
    }

    const showCreateForm = () => {
      selectedCategory.value = {id: 0, name: '', situation: false}
      isEdit.value = false
      showForm.value = true
    }

    const editCategory = (category: ICategory) => {
      useLoaderStore().startLoading()
      selectedCategory.value = {...category}
      isEdit.value = true
      showForm.value = true
      useLoaderStore().stopLoading()
    }

    const handleDeleteCategory = async (id: number) => {
      useLoaderStore().startLoading()
      try {
        await deleteCategory(id)
        await fetchCategories()
      } catch (error) {
        console.error(error)
      }
      useLoaderStore().stopLoading()
    }

    onMounted(fetchCategories)

    return {
      categories,
      selectedCategory,
      showForm,
      isEdit,
      fetchCategories,
      showCreateForm,
      editCategory,
      deleteCategory: handleDeleteCategory,
      updateCategories
    }
  }
})
</script>
