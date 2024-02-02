<?php

namespace App\StateMachine;

use App\Models\Product;
use App\Models\Variant;
use App\StateMachine\ProductState;
use Illuminate\Support\Facades\Date;

class ActiveState extends ProductState
{
    public function addVariant(Product $product, $variantAttributes)
    {
        throw new \Exception("Cannot add variant to active product");
    }

    public function removeVariant(Product $product, int $variantId)
    {
        throw new \Exception("Cannot remove variant from active product");
    }

    public function activateProduct(Product $product, Date $validFrom, Date $validTo)
    {
        throw new \Exception("Cannot activate deleted product");
    }
}
