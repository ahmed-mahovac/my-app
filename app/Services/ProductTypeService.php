<?php

namespace App\Services;

use App\Models\ProductType;
use Illuminate\Support\Facades\Cache;

class ProductTypeService
{
    public function getAllProductTypes()
    {
        if(!Cache::has("product_types")){
            Cache::put("product_types", ProductType::all());
        }
        return Cache::get("product_types");
    }

    public function getProductType(int $id)
    {
        return ProductType::find($id);
    }

    public function createProductType(array $data){
        $newProductType = ProductType::create($data);
        Cache::forget("product_types");
        return $newProductType;
    }

    public function updateProductType(int $id, array $data){
        $productType = ProductType::find($id);
        $productType->update($data);
        Cache::forget("product_types");
        return $productType;
    }

    public function deleteProductType(int $id){
        $productType = ProductType::find($id);
        $productType->delete();
        Cache::forget("product_types");
        return $productType;
    }
}