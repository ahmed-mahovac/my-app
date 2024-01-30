<?php

namespace App\Services;

use App\Http\Requests\ProductSearchObject;
use App\Models\Product;
use App\Models\ProductWithNewestVariant;
use Illuminate\Support\Facades\Log;

class ProductService
{
    public function getAllProducts(ProductSearchObject $searchObject)
    {
        
        $limit = $searchObject->getLimit() ? $searchObject->getLimit() : 10;
        $page = $searchObject->getPage() ? $searchObject->getPage() : 0;
        $name = $searchObject->getName();
        
        // pagination and filtering

        $query = Product::query();
        if ($name) {
            // full text search on name column
            // by using match against syntax
            $query->whereRaw("MATCH(name) AGAINST(? IN BOOLEAN MODE)", [$name]);
        }


        if($searchObject->isIncludeProductType()) {
            $query->with('productType');
        }

   
        if ($searchObject->getFromVariantPrice()) {
            $query->whereHas('variants', function ($query) use ($searchObject) {
                $query->where('price', '>=', $searchObject->getFromVariantPrice());
            });


            //$query->with('variants');
        }

        if ($searchObject->getToVariantPrice()) {
            $query->whereHas('variants', function ($query) use ($searchObject) {
                $query->where('price', '<=', $searchObject->getToVariantPrice());
            });
        }

        // experiment with paginated method too
        
        return $query->offset($page * $limit)
            ->limit($limit)
            ->get();
    }

    public function getProduct(int $id)
    {
        $product = Product::find($id);
        $product->load('productType');
        return $product;
    }

    public function getProductWithNewestVariant(int $id)
    {
        /*
        return ProductWithNewestVariant::with('newestVariant')
         ->select([
            'products.product_id as product_id',
            'products.name as product_name',
            'newestVariants.variant_id as newest_variant_id',
            'newestVariant.name as newest_variant_name',
            'newestVariant.price as newest_variant_price'
         ])
        ->find($id);
        */
        return ProductWithNewestVariant::find($id)->getInfo();
    }
}