<?php

namespace App\Services;

use App\Exceptions\UserException;
use App\Http\Requests\ProductSearchObject;
use App\Models\Product;
use App\Models\ProductWithNewestVariant;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
            $query->whereRaw("MATCH(name) AGAINST(? IN BOOLEAN MODE)", [$name]);
        }


        if ($searchObject->isIncludeProductType()) {
            $query->with('productType');
        }


        if ($searchObject->getFromVariantPrice()) {
            $query->whereHas('variants', function ($query) use ($searchObject) {
                $query->where('price', '>=', $searchObject->getFromVariantPrice());
            });
        }

        if ($searchObject->getToVariantPrice()) {
            $query->whereHas('variants', function ($query) use ($searchObject) {
                $query->where('price', '<=', $searchObject->getToVariantPrice());
            });
        }

        if ($searchObject->getValidFrom()) {
            $query->where('valid_from', '>=', $searchObject->getValidFrom());
        }

        if ($searchObject->getValidTo()) {
            $query->where('valid_to', '<=', $searchObject->getValidTo());
        }

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

    public function activateProduct(int $id, $inputData)
    {
        $product = Product::find($id);

        if (!$product) {
            throw new NotFoundHttpException('Product not found');
        }

        $this->stateMachineService->activateProduct($product, $inputData);
    }

    public function addVariant(int $id, $attributes)
    {
        $product = Product::find($id);

        if (!$product) {
            throw new NotFoundHttpException('Product not found');
        }

        $this->stateMachineService->addVariant($product, $attributes);
    }

    public function removeVariant(int $productId, int $variantId)
    {
        $product = Product::find($productId);

        if (!$product) {
            throw new NotFoundHttpException('Product not found');
        }

        $this->stateMachineService->removeVariant($product, $variantId);
    }
}
