<?php
declare(strict_types = 1);

namespace App\Controller;

use App\HttpResponse;
use App\Service\GoodService;
use App\View\GoodViewInterface;

/**
 * Class GoodsController
 */
class GoodsController
{
    /**
     * Good service
     *
     * @var GoodService
     */
    private $goodService;

    /**
     *  Good view
     *
     * @var GoodViewInterface
     */
    private $goodView;

    /**
     * GoodsController constructor.
     *
     * @param GoodService $goodService
     * @param GoodViewInterface $goodView
     */
    public function __construct(GoodService $goodService, GoodViewInterface $goodView)
    {
        $this->goodService = $goodService;
        $this->goodView    = $goodView;
    }

    /**
     * List all goods
     *
     * @return HttpResponse
     */
    public function listAll(): HttpResponse
    {
        $goods = $this->goodService->listAll();

        return $this->goodView->list($goods);
    }

    /**
     * Create many goods
     *
     * @return HttpResponse
     */
    public function createManyGoods(): HttpResponse
    {
        $this->goodService->createManyGoods();

        return $this->goodView->ok();
    }
}
