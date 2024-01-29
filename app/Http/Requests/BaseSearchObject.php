<?php

namespace App\Http\Requests;

class BaseSearchObject
{
    protected ?int $page;
    protected ?int $limit;

    public function __construct($page, $limit)
    {
        $this->page = $page;
        $this->limit = $limit;
    }

    public function getLimit()
    {
        return $this->limit;
    }

    public function getPage()
    {
        return $this->page;
    }
}