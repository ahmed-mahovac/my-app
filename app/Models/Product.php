<?php

namespace App\Models;

use App\StateMachine\ActiveState;
use App\StateMachine\DeletedState;
use App\StateMachine\DraftState;
use App\StateMachine\ProductState;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\ModelStates\HasStates;

class Product extends Model
{
    use HasFactory, HasStates;
    
    protected $primaryKey = 'product_id';

    protected $states = [
        'DRAFT' => DraftState::class,
        'ACTIVE' => ActiveState::class,
        'DELETED' => DeletedState::class,
    ];

    protected $casts = [
        'state' => ProductState::class,
    ];

    public function productType()
    {
        return $this->belongsTo(ProductType::class, 'product_type_id', 'product_type_id');
    }


    public function variants()
    {
        return $this->hasMany(Variant::class, 'product_id', 'product_id');
    }

}
