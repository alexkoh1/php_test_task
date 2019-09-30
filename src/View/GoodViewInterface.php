<?php


namespace App\View;


use App\Entity\Good;
use App\HttpResponse;

interface GoodViewInterface
{
    /**
     * @param Good[] $goods
     * @return mixed
     */
    public function list(array $goods): HttpResponse;

    public function ok(): HttpResponse;
}