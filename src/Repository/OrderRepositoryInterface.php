<?php


namespace App\Repository;


interface OrderRepositoryInterface
{
    public function create(array $goodIds): int;

    public function findBySumIdStatus(int $sum, int $orderId, int $status = 1);

    public function changeStatus(int $orderId, int $status);
}