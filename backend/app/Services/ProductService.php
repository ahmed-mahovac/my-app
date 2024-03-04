<?php

namespace App\Services;

use App\Exceptions\UserException;
use App\Http\Requests\ProductSearchObject;
use App\Jobs\StoreProductsChunk;
use App\Models\Product;
use App\Models\ProductWithNewestVariant;
use App\Services\Interfaces\ProductServiceInterface;
use GuzzleHttp\Psr7\UploadedFile;
use Illuminate\Http\UploadedFile as HttpUploadedFile;
use Illuminate\Support\Facades\Log;
use Spatie\SimpleExcel\SimpleExcelReader;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductService extends BaseService implements ProductServiceInterface
{

    protected $stateMachineService;

    public function __construct(StateMachineService $stateMachineService)
    {
        $this->stateMachineService = $stateMachineService;
    }

    public function getAllProducts(ProductSearchObject $searchObject)
    {

        $query =  parent::getPaginatedQuery($searchObject, Product::query());

        $query = $this->additionalFilters($searchObject, $query);

        return $query->get();
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

    public function activateProduct(int $id, $inputData): Product
    {
        $product = Product::find($id);

        if (!$product) {
            throw new NotFoundHttpException('Product not found');
        }

        return $this->stateMachineService->activateProduct($product, $inputData);
    }

    public function draftProduct(int $id, $inputData): Product
    {
        $product = Product::find($id);

        if (!$product) {
            throw new NotFoundHttpException('Product not found');
        }

        return $this->stateMachineService->draftProduct($product, $inputData);
    }

    public function deleteProduct(int $id, $inputData): Product
    {
        $product = Product::find($id);

        if (!$product) {
            throw new NotFoundHttpException('Product not found');
        }

        return $this->stateMachineService->deleteProduct($product, $inputData);
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

    public function processProducts(HttpUploadedFile $file){
        Log::info('Processing file', ['file' => $file]);
        $rows = SimpleExcelReader::create($file->getPath())
        ->useDelimiter(',')
        ->useHeaders(['ID', 'title', 'description']) // modify
        ->getRows();

        $chunks = $rows->chunk(10);

        $chunks->each(function ($chunk) {
            // create a job and dispatch it
            StoreProductsChunk::dispatch($chunk);
        });
    }

    private function additionalFilters(ProductSearchObject $searchObject, $query)
    {
        $name = $searchObject->getName();

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


        return $query;
    }
}
