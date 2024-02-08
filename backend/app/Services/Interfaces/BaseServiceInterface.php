<?php

namespace App\Services\Interfaces;

use App\Http\Requests\BaseSearchObject;
use Illuminate\Database\Eloquent\Builder;

interface BaseServiceInterface
{
    public function getPaginatedQuery(BaseSearchObject $searchObject, Builder $query): Builder;
    
    
}