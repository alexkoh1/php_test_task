<?php


namespace App\Service;

use App\Entity\Good;
use App\Repository\GoodRepositoryInterface;
use Faker\Factory;

class GoodService
{
    /**
     * @var GoodRepositoryInterface
     */
    private $goodRepository;

    /**
     * GoodService constructor.
     *
     * @param GoodRepositoryInterface $goodRepository
     */
    public function __construct(GoodRepositoryInterface $goodRepository)
    {
        $this->goodRepository = $goodRepository;
    }

    /**
     * Create goods
     */
    public function createManyGoods()
    {
        $faker = Factory::create();

        for ($i=0; $i<=20; $i++) {
            $title       = $faker->word;
            $description = $faker->sentence($nbWords = 6, $variableNbWords = true);
            $cost        = $faker->numberBetween(1000, $max = 9000);

            $this->goodRepository->createGood($title, $description, $cost);
        }
    }

    /**
     * Возвращает все товары
     *
     * @return Good[]
     */
    public function listAll(): array
    {
        return $this->goodRepository->findAll();
    }
}
