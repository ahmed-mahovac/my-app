<?php

namespace App\Services;

use App\Models\Product;
use App\StateMachine\ActiveState;
use App\StateMachine\DeletedState;
use App\StateMachine\DraftState;
use App\StateMachine\StateEnum;
use Exception;
use Illuminate\Support\Facades\Auth;

class StateMachineService
{
    public function __construct()
    {
        //
    }

    public function activateProduct(Product $product, $inputData)
    {
        $state = $this->createProductState($product->state);
        $state->activateProduct($product, $inputData['valid_from'], $inputData['valid_to']);
    }

    public function addVariant(Product $product, $variantAttributes)
    {
        $state = $this->createProductState($product->state);
        $state->addVariant($product, $variantAttributes);
    }

    public function removeVariant(Product $product, int $variantId)
    {
        $state = $this->createProductState($product->state);
        $state->removeVariant($product, $variantId);
    }

    private static function createProductState(string $state){
        switch ($state) {
            case 'DRAFT':
                return app(DraftState::class);
            case 'ACTIVE':
                return app(ActiveState::class);
            case 'DELETED':
                return app(DeletedState::class);
            default:
                throw new Exception("Unknown state. Unable to create State object");
        }
    }
}
