<?php

namespace App\Services\Interfaces;

use App\Models\Product;

interface VariantServiceInterface extends BaseServiceInterface
{
    public function addVariant(Product $product, $variantAttributes);
    public function removeVariant(Product $product, int $variantId);
}