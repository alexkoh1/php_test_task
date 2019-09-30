<?php
declare(strict_types = 1);

namespace App\Repository;

use App\Entity\Order;
use App\Exception\DatabaseException;
use Exception;
use PDO;

class OrderRepository implements OrderRepositoryInterface
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
     * @param array $goodIds
     * @return int
     */
    public function create(array $goodIds): int
    {
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $orderStmt     = $this->pdo->prepare("INSERT INTO orders (status) VALUES(DEFAULT)");
        $orderGoodStmt = $this->pdo->prepare("INSERT INTO order_good (order_id, good_id) VALUES(?, ?)");

        try {
            $this->pdo->beginTransaction();

            $orderStmt->execute();
            $orderId = $this->pdo->lastInsertId();

            foreach ($goodIds as $goodId) {
                $orderGoodStmt->bindParam(1, $orderId);
                $orderGoodStmt->bindParam(2, $goodId);
                $orderGoodStmt->execute();
            }

            $this->pdo->commit();

            return (int) $orderId;

        } catch (Exception $e) {
            $this->pdo->rollBack();

            throw new DatabaseException('Error writing to database.');
        }
    }

    /**
     * Find good
     *
     * @param int $sum
     * @param int $orderId
     * @param int $status
     * @return mixed
     */
    public function findBySumIdStatus(int $sum, int $orderId, int $status = 1)
    {
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $this->pdo->prepare('SELECT * FROM orders WHERE id = ? and amount = ? and status = ?');
        $stmt->bindParam(1, $orderId);
        $stmt->bindParam(2, $sum);
        $stmt->bindParam(3, $status);

        return $stmt->fetchObject(Order::class);
    }

    /**
     * @param int $orderId
     * @param int $status
     */
    public function changeStatus(int $orderId, int $status): void
    {
        $stmt = $this->pdo->prepare('UPDATE orders SET status = ? WHERE id = ?');
        $stmt->bindParam(1, $status);
        $stmt->bindParam(2, $orderId);

        $stmt->execute();
    }
}
