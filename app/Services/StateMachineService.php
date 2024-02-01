<?php

namespace App\Services;

use App\Models\Product;
use App\StateMachine\ActiveState;
use Illuminate\Support\Facades\Auth;

class StateMachineService
{
    public function __construct()
    {
        //
    }

    public function activateProduct(int $id, $attributes) {
        $product = Product::find($id);
        // extract logic to transitionTo method?
        $product->state->transitionTo(ActiveState::class);
        $product->update(['valid_from' => $attributes['valid_from'], 'valid_to' => $attributes['valid_to'], 'activated_by' => Auth::user()->name]);
    }

    public function addVariant(int $id, $variantAttributes)
    {
        $product = Product::find($id);
        $product->state->addVariant($variantAttributes);
    }

}