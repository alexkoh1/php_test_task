<?php


namespace App\View;


use App\HttpResponse;

class JsonOrderView implements OrderViewInterface
{
    public function orderId(int $orderId): HttpResponse
    {
        $result = ['order_id' => $orderId];

        $response = new HttpResponse();
        $response->setBody(json_encode($result))
            ->setContentType('application/json');

        return $response;
    }

    public function ok(): HttpResponse
    {
        $response = new HttpResponse();
        $response->setBody(json_encode(['success' => 'true']))
            ->setContentType('application/json');

        return $response;
    }
}