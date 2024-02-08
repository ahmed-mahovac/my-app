<?php

namespace App\StateMachine;

use App\Models\Product;
use App\Models\Variant;
use App\StateMachine\ProductState;
use DateTime;
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

    public function activateProduct(Product $product, DateTime $validFrom, DateTime $validTo)
    {
        throw new \Exception("Cannot activate product which is already active");
    }

    public function draftProduct(Product $product)
    {
        parent::moveToState($product, StateEnum::DRAFT);
        return $product;
    }

    public function deleteProduct(Product $product)
    {
        parent::moveToState($product, StateEnum::DELETED);
        return $product;
    }
}
