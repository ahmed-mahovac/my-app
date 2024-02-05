<?php

namespace App\Services;

use App\Http\Requests\BaseSearchObject;
use App\Services\Interfaces\BaseServiceInterface;
use Illuminate\Database\Eloquent\Builder;

abstract class BaseService implements BaseServiceInterface
{
    public function getPaginatedQuery(BaseSearchObject $searchObject, Builder $query): Builder
    {
        $limit = $searchObject->getLimit() ? $searchObject->getLimit() : 10;
        $page = $searchObject->getPage() ? $searchObject->getPage() : 0;

        return $query->offset($page * $limit)
            ->limit($limit);
    }
}
