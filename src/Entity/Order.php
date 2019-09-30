<?php
declare(strict_types = 1);

namespace App\Entity;

/**
 * Order Entity
 */
class Order
{
    /**
     * Id
     *
     * @var int
     */
    public $id;

    /**
     * Goods
     *
     * @var Good[]
     */
    public $good;

    /**
     * status
     *
     * @var int
     */
    public $status;

    /**
     * Amount
     *
     * @var int
     */
    public $amount;
}
