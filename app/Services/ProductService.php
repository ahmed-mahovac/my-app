<?php

namespace App\Services;

use App\Http\Requests\ProductSearchObject;
use App\Models\Product;
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

        // eager loading of product type
        // reduces number of queries if we want to include product type along with product
        if($searchObject->isIncludeProductType()) {
            $query->with('productType');
        }

        // experiment with paginated method too
        
        return $query->offset($page * $limit)
            ->limit($limit)
            ->get();
    }
}