import attachTokenInterceptor from "../middleware/tokenInterceptor";
import { axiosInstance } from "./config";

attachTokenInterceptor(axiosInstance);


export interface ProductTypeResponse {
    product_type_id: number;
    name: string;
    description: string;
}

export interface ProductResponse {
    product_id: number;
    name: string;
    description: string;
    price: number;
    product_type: ProductTypeResponse;
};

export interface SearchParams {
    name?: string;
    include_product_type?: boolean;
    page?: number;
    limit?: number;
}

export const getProducts = async (searchParams: SearchParams): Promise<Array<ProductResponse>> => {
    try {
      const response = await axiosInstance.get("/products", {params: {...searchParams, include_product_type: true}});
      return response.data;
    } catch (error) {
      console.error("Get products error: ", error);
      throw error;
    }
  }