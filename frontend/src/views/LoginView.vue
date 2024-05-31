<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="max-w-md w-full bg-white rounded-lg shadow-md p-8 space-y-6">
      <h2 class="text-2xl font-bold text-center text-gray-900">Bem-vindo</h2>
      <form @submit.prevent="handleLogin">
        <div class="space-y-4">
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" id="email" v-model="email"
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            <span class="text-sm text-red-600" v-for="error in errors.email" :key="error">
                {{ error }}
              </span>
          </div>
          <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Senha</label>
            <input type="password" id="password" v-model="password"
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            <span class="text-sm text-red-600" v-for="error in errors.password" :key="error">
                {{ error }}
              </span>
          </div>
          <div>
            <button type="submit"
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              Entrar
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script lang="ts">
import {defineComponent, ref} from 'vue'
import {login} from "@/api/auth.ts";
import {AxiosError} from "axios";
import {useUserStore} from "@/store/userStore.ts";
import {useRouter} from "vue-router";

export default defineComponent({
  setup() {
    const email = ref('')
    const password = ref('')
    const rememberMe = ref(false)
    const errors = ref<FormLoginResponseError>({email: [], password: []})
    const router = useRouter()
    const handleLogin = async () => {
      login(email.value, password.value).then((success) => {
        if ("name" in success.data.data && "token" in success.data.data) {
          const userStore = useUserStore()
          const name = success.data.data.name
          const token = success.data.data.token
          userStore.setUser(name, token)
          router.push({ name: 'Home' })
        }
      }).catch((err) => {
        const error = err as AxiosError<FormLoginResponseError>;
        if (error.response && error.response.data) {
          errors.value.email = error.response.data.email || []
          errors.value.password = error.response.data.password || []
        } else {
          console.error('Unexpected error', error)
        }
      })

    }

    return {
      email,
      password,
      rememberMe,
      handleLogin,
      errors
    }
  }
})
</script>

<style scoped>
/* Você pode adicionar estilos adicionais aqui */
</style>
