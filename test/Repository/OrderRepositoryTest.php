<?php


namespace App\Repository;


use App\Exception\DatabaseException;
use PDO;
use PDOException;
use PDOStatement;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class OrderRepositoryTest extends TestCase
{


    /**
     * @var PDO|MockObject
     */
    private $pdo;

    /**
     * @var OrderRepository
     */
    private $orderRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->pdo             = $this->createMock(PDO::class);
        $this->orderRepository = new OrderRepository($this->pdo);
    }

    public function tearDown(): void
    {
        $this->pdo             = null;
        $this->orderRepository = null;
    }

    public function testCreate()
    {
        $orderId       = 15;
        $orderGoodStmt = $this->createMock(PDOStatement::class);
        $orderStmt     = $this->createMock(PDOStatement::class);

        $this->pdo
            ->expects($this->once())
            ->method('commit');

        $this->pdo
            ->expects($this->once())
            ->method('setAttribute')
            ->with(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->pdo
            ->expects($this->once())
            ->method('lastInsertId')
            ->willReturn($orderId);

        $this->pdo
            ->expects($this->at(1))
            ->method('prepare')
            ->with($this->equalTo('INSERT INTO orders (status) VALUES(DEFAULT)'))
            ->willReturn($orderStmt);

        $this->pdo
            ->expects($this->at(2))
            ->method('prepare')
            ->with($this->equalTo('INSERT INTO order_good (order_id, good_id) VALUES(?, ?)'))
            ->willReturn($orderGoodStmt);

        $orderStmt
            ->expects($this->once())
            ->method('execute');

        $orderGoodStmt
            ->expects($this->at(0))
            ->method('bindParam')
            ->with(1, $orderId);

        $orderGoodStmt
            ->expects($this->at(1))
            ->method('bindParam')
            ->with(2, 1);

        $orderGoodStmt
            ->expects($this->exactly(2))
            ->method('execute');

        $orderGoodStmt
            ->expects($this->at(3))
            ->method('bindParam')
            ->with(1, $orderId);

        $orderGoodStmt
            ->expects($this->at(4))
            ->method('bindParam')
            ->with(2, 2);


        $result = $this->orderRepository->create([1,2]);
        $this->assertEquals($result, 15);
    }

    public function testCreateFail()
    {
        $orderId       = 15;
        $orderGoodStmt = $this->createMock(PDOStatement::class);
        $orderStmt     = $this->createMock(PDOStatement::class);

        $this->pdo
            ->expects($this->once())
            ->method('setAttribute')
            ->with(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->pdo
            ->expects($this->once())
            ->method('lastInsertId')
            ->willReturn($orderId);

        $this->pdo
            ->expects($this->at(1))
            ->method('prepare')
            ->with($this->equalTo('INSERT INTO orders (status) VALUES(DEFAULT)'))
            ->willReturn($orderStmt);

        $this->pdo
            ->expects($this->at(2))
            ->method('prepare')
            ->with($this->equalTo('INSERT INTO order_good (order_id, good_id) VALUES(?, ?)'))
            ->willReturn($orderGoodStmt);

        $orderStmt
            ->expects($this->once())
            ->method('execute');

        $orderGoodStmt
            ->expects($this->at(0))
            ->method('bindParam')
            ->with(1, $orderId);

        $orderGoodStmt
            ->expects($this->at(1))
            ->method('bindParam')
            ->with(2, 3)
            ->willThrowException(new PDOException());

        $this->pdo
            ->expects($this->once())
            ->method($this->equalTo('rollBack'));

        $this->expectException(DatabaseException::class);

        $this->orderRepository->create([3]);
    }
}