import apiClient from "@/services/axios.ts";
import {AxiosResponse} from "axios";

export const getProducts = (): Promise<AxiosResponse<IListResponse<IProduct>>> => {
    return apiClient.get('/products');
}

export const getProduct = (id: number) => {
    return apiClient.get(`/products/${id}`);
}
export const createProduct = (category: any) => {
    return apiClient.post('/products', category);
}
export const updateProduct = (id: number, category: any) => {
    return apiClient.put(`/products/${id}`, category);
}
export const deleteProduct = (id: number) => {
    return apiClient.delete(`/products/${id}`);
}