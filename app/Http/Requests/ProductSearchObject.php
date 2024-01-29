<?php

namespace App\Http\Requests;

class ProductSearchObject extends BaseSearchObject
{
    private ?string $name;

    public function __construct($page, $limit, $name)
    {
        parent::__construct($page, $limit);
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }
}