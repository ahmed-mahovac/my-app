<?php

namespace App\Services;

use App\Http\Requests\ProductTypeSearchObject;
use App\Models\ProductType;
use App\Services\Cache\CacheTags;
use App\Services\Interfaces\ProductTypeServiceInterface;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ProductTypeService extends BaseService implements ProductTypeServiceInterface
{
    public function getAllProductTypes(ProductTypeSearchObject $searchObject)
    {
        $key = $this->getHashedKey($searchObject->all());

        $query = ProductType::query();

        $query = parent::getPaginatedQuery($searchObject, $query);

        if (!Cache::has($key)) {
            Log::info("No cache found for key: " . $key);
            Cache::put($key, $query->get());
        }
        return Cache::get($key);
    }

    public function getProductType(int $id)
    {
        return ProductType::find($id);
    }

    public function createProductType(array $data)
    {
        $newProductType = ProductType::create($data);
        $this->clearCache();
        return $newProductType;
    }

    public function updateProductType(int $id, array $data)
    {
        $productType = ProductType::find($id);
        $productType->update($data);
        $this->clearCache();
        return $productType;
    }

    public function deleteProductType(int $id)
    {
        $productType = ProductType::find($id);
        $productType->delete();
        $this->clearCache();
        return $productType;
    }

    private function getHashedKey(array $params)
    {
        ksort($params);
        return CacheTags::PRODUCT_TYPES . md5(json_encode($params));
    }

    private function clearCache()
    {
        Cache::flush();
    }
}
