<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Variant;

class VariantService
{

    public function addVariant(Product $product, $variantAttributes)
    {
        $product->variants()->create([
            'name' => $variantAttributes['name'],
            'price'=> $variantAttributes['price'],
        ]);

    }

    public function removeVariant(Product $product, int $variantId)
    {
        $product->variants()->where('variant_id', $variantId)->delete();
    }
}