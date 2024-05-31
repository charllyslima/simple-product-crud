import axios from 'axios'
import {useUserStore} from "@/store/userStore.ts";

const apiClient = axios.create({
    baseURL: import.meta.env.VITE_API_BASE_URL,
    headers: {
        'Content-Type': 'application/json',
    },
})

// Adiciona um interceptor para adicionar o token às requisições
apiClient.interceptors.request.use(
    (config) => {
        if (config.url !== '/login') {
            const userStore = useUserStore()
            const token = userStore.token
            if (token) {
                config.headers.Authorization = `Bearer ${token}`
            }
        }
        return config
    },
    (error) => {
        return Promise.reject(error)
    }
)

apiClient.interceptors.response.use(
    (response) => {
        return response;
    },
    (error) => {
        return Promise.reject({
            status: error.response?.status,
            response: error.response?.data,
        });
    }
);
export default apiClient
