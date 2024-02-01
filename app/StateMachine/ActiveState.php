<?php

namespace App\StateMachine;

use App\Models\Variant;
use App\StateMachine\ProductState;

class ActiveState extends ProductState{
    public function addVariant($variant){
        throw new \Exception("Cannot add variant to active product");
    }
}