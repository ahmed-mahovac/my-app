<?php

namespace App\StateMachine;

use App\Models\Product;
use App\Models\Variant;
use App\Services\Interfaces\VariantServiceInterface;
use App\Services\VariantService;
use App\StateMachine\ProductState;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Log;

class DraftState extends ProductState
{

    protected $variantService;

    public function __construct(VariantServiceInterface $variantService)
    {
        $this->variantService = $variantService;
    }


    public function addVariant(Product $product, $variantAttributes)
    {
        $this->variantService->addVariant($product, $variantAttributes);
    }

    public function removeVariant(Product $product, int $variantId)
    {
        $this->variantService->removeVariant($product, $variantId);
    }

    public function activateProduct(Product $product, DateTime $validFrom, DateTime $validTo)
    {
        parent::moveToState($product, StateEnum::ACTIVE);
        $product->update(['valid_from' => $validFrom, 'valid_to' => $validTo, 'activated_by' => Auth::user()->name]);
        return $product;
    }

    public function draftProduct(Product $product)
    {
        throw new \Exception("Product is already in draft state");
    }

    public function deleteProduct(Product $product)
    {
        parent::moveToState($product, StateEnum::DELETED);
        return $product;
    }
}
