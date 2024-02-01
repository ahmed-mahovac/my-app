<?php

namespace App\StateMachine;

use App\Models\Variant;
use App\StateMachine\ProductState;
use Illuminate\Support\Facades\Log;

class DraftState extends ProductState{

    public function addVariant($variant)
    {
        Log::info("Adding variant to draft product");
    }
}