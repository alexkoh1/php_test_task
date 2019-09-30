<?php

namespace App\View;

use App\HttpResponse;
use PHPUnit\Framework\TestCase;

class JsonGoodViewTest extends TestCase
{
    /**
     * @var JsonGoodView
     */
    private $jsonGoodView;

    public function setUp(): void
    {
        parent::setUp();

        $this->jsonGoodView = new JsonGoodView();
    }

    public function tearDown(): void
    {
        parent::tearDown();

        $this->jsonGoodView = null;
    }

    public function testView()
    {
        $json = [
            'a' => 1,
            'b' => 2,
        ];

        $result = $this->jsonGoodView->list($json);

        $this->assertInstanceOf(HttpResponse::class, $result);
        $this->assertEquals($result->getContentType(), 'application/json');
        $this->assertEquals($result->getBody(), "{\"a\":1,\"b\":2}");
    }
}