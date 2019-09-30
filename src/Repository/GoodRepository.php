<?php
declare(strict_types = 1);

namespace App\Repository;

use App\Entity\Good;
use PDO;

/**
 * Class GoodRepository
 */
class GoodRepository implements GoodRepositoryInterface
{
    /**
     * PDO
     *
     * @var PDO
     */
    private $pdo;

    /**
     * GoodRepository constructor.
     *
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Create good
     *
     * @param $title
     * @param $description
     * @param $cost
     */
    public function createGood($title, $description, $cost): void
    {
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $this->pdo->prepare('INSERT INTO good(title, description, cost) VALUES(?, ?, ?)');
        $stmt->bindParam(1, $title);
        $stmt->bindParam(2, $description);
        $stmt->bindParam(3, $cost);
        $stmt->execute();
    }

    /**
     * Get all goods
     *
     * @return Good[]
     */
    public function findAll()
    {
        $stmt = $this->pdo->query('SELECT * from good');

        return $stmt->fetchAll(PDO::FETCH_CLASS, Good::class);
    }
}