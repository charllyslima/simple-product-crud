<template>
  <div v-if="loading" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75">
    <div class="loader ease-linear rounded-full border-8 border-t-8 border-gray-200 h-32 w-32"></div>
  </div>
</template>

<script lang="ts" setup>
import { computed } from 'vue';
import {useLoaderStore} from "@/store/loaderStore.js";

const loaderStore = useLoaderStore();
const loading = computed(() => loaderStore.loading);
</script>

<style scoped>
.loader {
  border-top-color: #3498db;
  animation: spinner 1.5s linear infinite;
  z-index: 99;
}

@keyframes spinner {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
</style>
