<?php
declare(strict_types = 1);

namespace App\Entity;

use DateTime;

/**
 * Good entity
 */
class Good
{
    /**
     * Id
     *
     * @var int
     */
    public $id;

    /**
     * Title
     *
     * @var string
     */
    public $title;

    /**
     * Cost
     *
     * @var int
     */
    public $cost;

    /**
     * Description
     *
     * @var string
     */
    public $description;

    /**
     * @var DateTime
     */
    public $createdAt;
}