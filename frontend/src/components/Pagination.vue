<template>
  <div class="flex items-center justify-between py-4">
    <div class="flex space-x-2">
      <button
          v-for="link in response.links"
          :key="link.label"
          @click="goToPage(link.url)"
          :class="[
          'px-4 py-2 rounded-md',
          link.active ? 'bg-prussian-blue text-white' : 'bg-gray-300 text-gray-700 hover:bg-gray-400'
        ]"
          :disabled="!link.url"
          class="disabled:opacity-50 disabled:cursor-not-allowed"
      >
        <span>{{ link.label }}</span>
      </button>
    </div>
  </div>
</template>

<script lang="ts">
import {defineComponent, PropType} from 'vue';

export default defineComponent({
  props: {
    response: {
      type: Object as PropType<IListResponse<any>>,
      required: true
    }
  },
  setup(props: any, {emit}) {
    const goToPage = (url: string | null) => {
      if (url) {
        emit('page-changed', url);
      }
    };

    return {
      goToPage
    };
  }
});
</script>

<style scoped>
.disabled {
  opacity: 0.5;
  cursor: not-allowed;
}
</style>
