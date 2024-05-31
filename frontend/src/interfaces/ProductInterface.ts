interface IProduct {
    id: number;
    category_id: number;
    name: string;
    price: number;
    picture?: string;
    situation: boolean;
    created_at: string;
    updated_at: string;
}

interface IProductErrorResponse {
    category_id: [string]
    name: [string]
    price: [string]
    picture: [string]
    situation: [string]
}
