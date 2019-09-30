<?php


namespace App\Service;


use App\Entity\Order;
use App\Exception\OrderNotFoundException;
use App\Repository\OrderRepositoryInterface;

class OrderService
{
    CONST PAIDSTATUSID = 2;

    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepository;

    /**
     * @var SendRequestServiceInterface
     */
    private $requestService;

    public function __construct(OrderRepositoryInterface $orderRepository, SendRequestServiceInterface $requestService)
    {
        $this->orderRepository = $orderRepository;
        $this->requestService = $requestService;
    }

    public function create(array $goodIds)
    {
        return $this->orderRepository->create($goodIds);
    }

    public function pay(int $sum, int $orderId)
    {
        $order = $this->orderRepository->findBySumIdStatus($sum, $orderId);

        if ($order === null) {
            throw new OrderNotFoundException(
                sprintf('Order with id = %d and sum = %d not found.', $orderId, $sum)
            );
        }

        $code = $this->requestService->sendRequest();

        if ($code === 200) {
            $this->orderRepository->changeStatus($order->getId(), self::PAIDSTATUSID);
        }
    }
}
