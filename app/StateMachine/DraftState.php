<?php

namespace App\StateMachine;

use App\Models\Product;
use App\Models\Variant;
use App\Services\VariantService;
use App\StateMachine\ProductState;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Log;

class DraftState extends ProductState
{

    protected $variantService;

    public function __construct(VariantService $variantService)
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

    public function activateProduct(Product $product, Date $validFrom, Date $validTo)
    {
        parent::moveToState($product, StateEnum::ACTIVE);
        $product->update(['valid_from' => $validFrom, 'valid_to' => $validTo, 'activated_by' => Auth::user()->name]);
    }
}
