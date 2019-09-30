<?php
declare(strict_types = 1);

namespace App\View;

use App\HttpResponse;

interface OrderViewInterface
{
    /**
     * OrderId View
     *
     * @param int $orderId
     *
     * @return HttpResponse
     */
    public function orderId(int $orderId): HttpResponse;

    /**
     * @return mixed
     */
    public function ok(): HttpResponse;
}