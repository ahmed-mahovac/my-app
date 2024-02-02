<?php

namespace App\Services;

use App\Models\Variant;

class VariantService
{

    public function addVariant($product, $variantAttributes)
    {
        $product->variants()->create([
            'name' => $variantAttributes['name'],
            'price'=> $variantAttributes['price'],
        ]);

    }

    public function removeVariant($product, $variantAttributes)
    {
        
    }
}