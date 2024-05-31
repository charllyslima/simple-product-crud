<script setup lang="ts">
import { defineProps } from 'vue';

const props = defineProps<{
  to: string;
  toggleSidebar: () => void;
  title: string
}>();
</script>

<template>
    <router-link @click="props.toggleSidebar" :to="props.to"
                 class="flex items-center space-x-2 py-3 px-4 transition duration-300 hover:bg-blue-green hover:font-bold rounded">
      <slot name="icon"></slot>
      <span>{{props.title}}</span>
    </router-link>
</template>

<style scoped>

</style>
