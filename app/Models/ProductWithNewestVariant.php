<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductWithNewestVariant extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $primaryKey = 'product_id';

    public function newestVariant() {
        return $this->hasOne(Variant::class, 'product_id', 'product_id')->latest();
    }

    public function getInfo(int $id)
    {
        return $this
         ->with('newestVariant')
         ->select([
            'products.product_id as product_id',
            'products.name as product_name',
            'newestVariants.variant_id as newest_variant_id',
            'newestVariant.name as newest_variant_name',
            'newestVariant.price as newest_variant_price'
         ])
        ->find($id);
    }

}