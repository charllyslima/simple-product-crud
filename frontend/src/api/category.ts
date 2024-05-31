import apiClient from "@/services/axios.ts";
import {AxiosResponse} from "axios";

export const getCategories = async (): Promise<AxiosResponse<IListResponse<ICategory>>> => {
    return await apiClient.get('/categories');
}

export const searchCategory = async (keyword: string): Promise<AxiosResponse<[ICategory]>> => {
    return await apiClient.get(`/categories/search/${keyword}`);
}

export const getCategory = (id: number) => {
    return apiClient.get(`/categories/${id}`);
}
export const createCategory = (category: any) => {
    return apiClient.post('/categories', category);
}
export const updateCategory = (id: number, category: any) => {
    return apiClient.put(`/categories/${id}`, category);
}
export const deleteCategory = (id: number) => {
    return apiClient.delete(`/categories/${id}`);
}
