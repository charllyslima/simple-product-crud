import apiClient from '@/services/axios.ts'
import {AxiosResponse} from "axios";

export const login = async (email: string, password: string): Promise<AxiosResponse<ResponseLogin>> => {
    return await apiClient.post('/login', {email, password})
}

export const logout = async (): Promise<AxiosResponse<ResponseLogin>> => {
    return await apiClient.post('/logout')
}