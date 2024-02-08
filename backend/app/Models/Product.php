<?php

namespace App\Models;

use App\StateMachine\ActiveState;
use App\StateMachine\DeletedState;
use App\StateMachine\DraftState;
use App\StateMachine\ProductState;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'product_id';

    protected $fillable = [
        'product_name',
        'product_type_id',
        'state',
        'valid_from',
        'valid_to',
        'activated_by',
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
