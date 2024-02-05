<?php

namespace App\Services\Interfaces;

use App\Http\Requests\ProductSearchObject;
use App\Models\Product;

interface ProductServiceInterface extends BaseServiceInterface
{
    public function getAllProducts(ProductSearchObject $searchObject);

    public function getProduct(int $id);

    public function getProductWithNewestVariant(int $id);

    public function activateProduct(int $id, $inputData): Product;

    public function draftProduct(int $id, $inputData): Product;

    public function deleteProduct(int $id, $inputData): Product;

    public function addVariant(int $id, $attributes);

    public function removeVariant(int $productId, int $variantId);

    
}