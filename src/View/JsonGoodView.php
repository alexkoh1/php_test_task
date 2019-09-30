<?php


namespace App\View;


use App\HttpResponse;

class JsonGoodView implements GoodViewInterface
{
    public function list(array $goods): HttpResponse
    {
        $response = new HttpResponse();
        $response->setBody(json_encode($goods))
            ->setContentType('application/json');

        return $response;
    }

    public function ok(): HttpResponse
    {
        $response = new HttpResponse();
        $response->setBody(['success' => 'true'])
            ->setContentType('application/json');

        return $response;
    }
}