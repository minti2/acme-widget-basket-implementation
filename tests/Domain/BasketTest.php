<?php

declare(strict_types=1);

namespace Acme\WidgetBasket\Tests\Domain;

use Acme\WidgetBasket\Domain\Basket;
use Acme\WidgetBasket\Domain\Delivery\TieredDeliveryStrategy;
use Acme\WidgetBasket\Domain\Offer\RedWidgetHalfPriceStrategy;
use Acme\WidgetBasket\Domain\Product;
use PHPUnit\Framework\TestCase;

class BasketTest extends TestCase
{
    private array $catalog;
    private Basket $basket;

    protected function setUp(): void
    {
        parent::setUp();

        // Initialize product catalog
        $this->catalog = [
            'B01' => new Product('B01', 'Blue Widget', 7.95),
            'G01' => new Product('G01', 'Green Widget', 24.95),
            'R01' => new Product('R01', 'Red Widget', 32.95),
        ];

        // Initialize basket with delivery and offer strategies
        $this->basket = new Basket(
            $this->catalog,
            new TieredDeliveryStrategy(),
            [new RedWidgetHalfPriceStrategy()]
        );
    }

    /**
     * @test
     */
    public function it_calculates_total_for_b01_g01_plus_delivery(): void
    {
        $this->basket->add('B01');
        $this->basket->add('G01');
        // $32.9 + $4.95 delivery
        $this->assertEquals(37.85, $this->basket->total());
    }

    /**
     * @test
     */
    public function it_calculates_total_for_r01_r01_half_price_plus_delivery(): void
    {
        $this->basket->add('R01');
        $this->basket->add('R01');
        // $32.9 + (half price) $16.47 + $4.95 delivery
        $this->assertEquals(54.37, $this->basket->total());
    }

    /**
     * @test
     */
    public function it_calculates_total_for_r01_g01_plus_delivery_discount(): void
    {
        $this->basket->add('R01');
        $this->basket->add('G01');
        // $32.9 + $24.95 + $2.95 delivery
        $this->assertEquals(60.85, $this->basket->total());
    }

    /**
     * @test
     */
    public function it_calculates_total_for_b01_b01_r01_r01_r01_plus_red_widget_half_price_and_delivery_discount(): void
    {
        $this->basket->add('B01');
        $this->basket->add('B01');
        $this->basket->add('R01');
        $this->basket->add('R01');
        $this->basket->add('R01');
        // $7.95 + $7.95 + $32.95 + (half price) $16.47 + $32.95 + free delivery
        $this->assertEquals(98.27, $this->basket->total());
    }

    /**
     * @test
     */
    public function it_throws_exception_for_invalid_product_code(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Product with code 'INVALID' not found in catalog");

        $this->basket->add('INVALID');
    }
}
