<?php
declare(strict_types = 1);

namespace App\Controller;


use App\HttpResponse;
use App\Service\OrderService;
use App\View\OrderViewInterface;
use Symfony\Component\HttpFoundation\Request;

class OrderController
{
    /**
     * Order Service
     *
     * @var OrderService
     */
    private $orderService;

    /**
     * Order view
     *
     * @var OrderViewInterface
     */
    private $orderView;

    /**
     * OrderController constructor.
     *
     * @param OrderService $orderService
     * @param OrderViewInterface $orderView
     */
    public function __construct(OrderService $orderService, OrderViewInterface $orderView)
    {
        $this->orderService = $orderService;
        $this->orderView = $orderView;
    }

    /**
     * Create Order
     *
     * @param Request $request
     * @return HttpResponse
     */
    public function create(Request $request)
    {
        $goodIds = json_decode($request->getContent(), true);

        $orderId = $this->orderService->create($goodIds);

        return $this->orderView->orderId($orderId);
    }

    /**
     * Pay for Order
     *
     * @param int $sum
     * @param int $orderId
     *
     * @return HttpResponse
     */
    public function pay(Request $request): HttpResponse
    {
        $array = json_decode($request->getContent(), true);

        $orderId = $array['order_id'];
        $sum     = $array['amount'];

        $this->orderService->pay($sum, $orderId);

        return $this->orderView->ok();
    }
}
