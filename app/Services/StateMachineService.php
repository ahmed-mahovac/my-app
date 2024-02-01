<?php

namespace App\Services;

use App\Models\Product;

class StateMachineService
{
    public function __construct()
    {
        //
    }

    public function addVariant(int $id, $variantAttributes)
    {
        $product = Product::find($id);
        $product->state->addVariant($variantAttributes);
    }

}