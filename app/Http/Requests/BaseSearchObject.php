<?php

namespace App\Http\Requests;

class BaseSearchObject
{
    protected ?int $page;
    protected ?int $limit;

    public function __construct(array $queryParameters)
    {
        $this->page = $queryParameters['page'] ?? null;
        $this->limit = $queryParameters['limit'] ?? null;
    }

    public function getLimit()
    {
        return $this->limit;
    }

    public function getPage()
    {
        return $this->page;
    }

    public function all() {
        return get_object_vars($this);
    }
}
