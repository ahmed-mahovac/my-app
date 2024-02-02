<?php

namespace App\Http\Requests;

use DateTime;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Log;

class ProductSearchObject extends BaseSearchObject
{
    private ?string $name;
    private ?float $fromVariantPrice;
    private ?float $toVariantPrice;
    private bool $includeProductType;

    private ?DateTime $validFrom;
    private ?DateTime $validTo;

    public function __construct(array $queryParameters)
    {
        parent::__construct($queryParameters);
        $this->name = $queryParameters['name'] ?? null;
        $this->fromVariantPrice = $queryParameters['from_variant_price'] ?? null;
        $this->toVariantPrice = $queryParameters['to_variant_price'] ?? null;
        $this->validFrom = isset($queryParameters['valid_from']) ? new DateTime($queryParameters['valid_from']) : null;
        $this->validTo = isset($queryParameters['valid_to']) ? new DateTime($queryParameters['valid_to']) : null;
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

    public function getValidFrom()
    {
        return $this->validFrom;
    }

    public function getValidTo()
    {
        return $this->validTo;
    }
}
