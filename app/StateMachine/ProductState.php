<?php

namespace App\StateMachine;

use App\Models\Variant;
use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

abstract class ProductState extends State
{

    abstract public function addVariant($variant);
    
    public static function config(): StateConfig
    {
        return parent::config()
            ->default(DraftState::class)
            ->allowTransition(DraftState::class, ActiveState::class)
            ->allowTransition(ActiveState::class, DraftState::class)
            ->allowTransition(ActiveState::class, DeletedState::class)
            ->allowTransition(DraftState::class, DeletedState::class)
        ;
    }
}