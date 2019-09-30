<?php

namespace App\Repository;

use App\Entity\Good;
use PDO;
use PDOStatement;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class GoodRepositoryTest extends TestCase
{
    /**
     * @var PDO|MockObject
     */
    private $pdo;

    /**
     * @var GoodRepository
     */
    private $goodRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->pdo = $this->createMock(PDO::class);
        $this->goodRepository = new GoodRepository($this->pdo);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->pdo            = null;
        $this->goodRepository = null;
    }

    public function testFindAll()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt
            ->expects($this->once())
            ->method('fetchAll')
            ->with(PDO::FETCH_CLASS, Good::class);

        $this->pdo
            ->expects($this->once())
            ->method('query')
            ->with('SELECT * from good')
            ->willReturn($stmt);

        $this->goodRepository->findAll();
    }
}