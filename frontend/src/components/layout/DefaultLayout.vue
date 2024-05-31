<template>
  <div class="flex h-screen">
    <Sidebar />
    <Loader />
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import Sidebar from '@/components/layout/Sidebar.vue';
import Loader from "@components/Loader.vue";

export default defineComponent({
  name: 'DefaultLayout',
  components: {
    Loader,
    Sidebar
  }
});
</script>

<style scoped>
</style>
