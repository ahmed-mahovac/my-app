<?php

namespace App\Services;

use App\Exceptions\UserException;
use App\Http\Requests\ProductSearchObject;
use App\Models\Product;
use App\Models\ProductWithNewestVariant;
use Illuminate\Support\Facades\Log;

class ProductService
{

    protected $stateMachineService;

    public function __construct(StateMachineService $stateMachineService)
    {
        $this->stateMachineService = $stateMachineService;
    }

    public function getAllProducts(ProductSearchObject $searchObject)
    {
        
        $limit = $searchObject->getLimit() ? $searchObject->getLimit() : 10;
        $page = $searchObject->getPage() ? $searchObject->getPage() : 0;
        $name = $searchObject->getName();
        

        $query = Product::query();
        if ($name) {
            // full text search on name column
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
        return ProductWithNewestVariant::find($id)->getInfo();
    }

    public function activateProduct(int $id, $attributes){
        $this->stateMachineService->activateProduct($id, $attributes);
    }

    public function addVariant(int $id, $attributes){
        $this->stateMachineService->addVariant($id, $attributes);
    }
}