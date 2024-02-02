<?php

namespace App\StateMachine;

use App\Models\Product;
use App\Models\Variant;
use DateTime;
use Illuminate\Support\Facades\Date;
use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

abstract class ProductState
{

    abstract public function addVariant(Product $product, $variantAttributes);

    abstract public function removeVariant(Product $product, int $variantId);

    abstract public function activateProduct(Product $product, DateTime $validFrom, DateTime $validTo);

    public function moveToState(Product $product, string $state): void
    {
        $product->state = $state;
    }

}
