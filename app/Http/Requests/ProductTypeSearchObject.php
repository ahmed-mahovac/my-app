<?php

namespace App\Http\Requests;

use DateTime;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Log;

class ProductTypeSearchObject extends BaseSearchObject
{

    public function __construct(array $queryParameters)
    {
        parent::__construct($queryParameters);
    }
}
