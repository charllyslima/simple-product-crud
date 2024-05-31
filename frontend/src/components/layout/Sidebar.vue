<template>
  <div class="w-screen">
    <div class="relative flex min-h-screen">
      <!-- Sidebar -->
      <div
          class="bg-prussian-blue text-white w-64 space-y-6 px-2 py-4 absolute inset-y-0 left-0 md:relative md:-translate-x-0 transform  transition duration-200 ease-in-out shadow-2xl"
          :class="{'relative -translate-x-0': isSidebarOpen, '-translate-x-full' : !isSidebarOpen }">

        <a href="/" class="flex items-center p-3">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
               stroke="currentColor"
               class="size-10">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="m21 7.5-2.25-1.313M21 7.5v2.25m0-2.25-2.25 1.313M3 7.5l2.25-1.313M3 7.5l2.25 1.313M3 7.5v2.25m9 3 2.25-1.313M12 12.75l-2.25-1.313M12 12.75V15m0 6.75 2.25-1.313M12 21.75V19.5m0 2.25-2.25-1.313m0-16.875L12 2.25l2.25 1.313M21 14.25v2.25l-2.25 1.313m-13.5 0L3 16.5v-2.25"/>
          </svg>
          <span class="text-2xl font-extrabold ms-3">Simple CRUD</span>
        </a>
        <nav class="mt-10">
          <LinkSidebar title="Inicio" svg="" :toggle-sidebar="toggleSidebar" to="/">
            <template #icon>
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                   stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
              </svg>
            </template>
          </LinkSidebar>
          <LinkSidebar title="Categorias" svg="" :toggle-sidebar="toggleSidebar" to="/categories">
            <template #icon>
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                   stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z"/>
              </svg>
            </template>
          </LinkSidebar>
          <LinkSidebar title="Produtos" svg="" :toggle-sidebar="toggleSidebar" to="/products">
            <template #icon>
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                   stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M9.75 3.104v5.714a2.25 2.25 0 0 1-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 0 1 4.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0 1 12 15a9.065 9.065 0 0 0-6.23-.693L5 14.5m14.8.8 1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0 1 12 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5"/>
              </svg>
            </template>
          </LinkSidebar>
        </nav>
      </div>
      <!-- Main Content -->
      <div class="flex-1">
        <!-- Header-->
        <div class="bg-white shadow p-4 flex justify-between">
          <button class="prussian-blue  md:hidden" @click="toggleSidebar">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" class="size-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
            </svg>
          </button>
          <h2 class="font-bold text-prussian-blue text-2xl ps-3">
            {{ currentPageName }}
          </h2>
          <button @click="handleLogout">
            Sair
          </button>
        </div>
        <!-- Content-->
        <div class="p-8 w-full min-h-[calc(100vh-64px)] bg-gray-100">
          <router-view/>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import {defineComponent, ref} from 'vue';
import LinkSidebar from "@components/layout/LinkSidebar.vue";
import {logout} from "@/api/auth.ts";
import {useRouter} from "vue-router";
import {useUserStore} from "@/store/userStore.ts";
import {useLoaderStore} from "@/store/loaderStore.ts";

export default defineComponent({
  name: 'Sidebar',
  components: {LinkSidebar},
  setup() {
    const isSidebarOpen = ref(false);
    const router = useRouter()
    const toggleSidebar = () => {
      isSidebarOpen.value = !isSidebarOpen.value;
    };

    const handleLogout = () => {
      useLoaderStore().startLoading()
      logout().then(() => {
        useUserStore().clearUser()
        router.push({name: 'Login'})
      }).catch(() => {
        useUserStore().clearUser()
        router.push({name: 'Login'})
      })
      useLoaderStore().stopLoading()
    }

    return {
      isSidebarOpen,
      toggleSidebar,
      handleLogout
    };
  },
  computed: {
    currentPageName() {
      return this.$route.name;
    }
  }
});
</script>

<style scoped>
/* Custom scroll bar for the sidebar */
::-webkit-scrollbar {
  width: 8px;
}

::-webkit-scrollbar-thumb {
  background-color: #4a5568;
  border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
  background-color: #2d3748;
}
</style>
