<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Log;

class ProductSearchObject extends BaseSearchObject
{
    private ?string $name;
    private ?float $fromVariantPrice;
    private ?float $toVariantPrice;
    private bool $includeProductType;

    public function __construct(array $queryParameters)
    {
        parent::__construct($queryParameters);
        $this->name = $queryParameters['name'] ?? null;
        $this->fromVariantPrice = $queryParameters['from_variant_price'] ?? null;
        $this->toVariantPrice = $queryParameters['to_variant_price'] ?? null;
        $this->includeProductType = array_key_exists('include_product_type', $queryParameters) ? true : false;
    }

    public function getName()
    {
        return $this->name;
    }

    public function isIncludeProductType()
    {
        return $this->includeProductType;
    }

    public function getFromVariantPrice()
    {
        return $this->fromVariantPrice;
    }

    public function getToVariantPrice()
    {
        return $this->toVariantPrice;
    }
}
