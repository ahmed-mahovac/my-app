<?php

namespace App\Services\Interfaces;

use App\Http\Requests\ProductTypeSearchObject;

interface ProductTypeServiceInterface extends BaseServiceInterface
{
    public function getAllProductTypes(ProductTypeSearchObject $searchObject);
    public function getProductType(int $id);

    public function createProductType(array $data);
    public function updateProductType(int $id, array $data);
    public function deleteProductType(int $id);

}