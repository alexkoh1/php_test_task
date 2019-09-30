<?php
declare(strict_types = 1);

namespace App\Repository;

use App\Entity\Good;

/**
 * Interface GoodRepositoryInterface
 */
interface GoodRepositoryInterface
{
    /**
     * Find all goods
     *
     * @return Good[]
     */
    public function findAll();

    /**
     * Create good
     *
     * @param $title
     * @param $description
     * @param $cost
     */
    public function createGood($title, $description, $cost): void;
}
