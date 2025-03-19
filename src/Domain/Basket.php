<?php

declare(strict_types=1);

namespace Acme\WidgetBasket\Domain;

use Acme\WidgetBasket\Domain\Delivery\DeliveryStrategyInterface;
use Acme\WidgetBasket\Domain\Offer\OfferStrategyInterface;

/**
 * Represents a shopping basket for Acme Widget Co.
 */
final class Basket
{
    /**
     * @var array<Product>
     */
    private array $products = [];

    /**
     * @param array<string, Product> $catalog The product catalog
     * @param DeliveryStrategyInterface $deliveryStrategy The delivery cost calculation strategy
     * @param OfferStrategyInterface[] $offerStrategies The special offer strategies
     */
    public function __construct(
        private readonly array $catalog,
        private readonly DeliveryStrategyInterface $deliveryStrategy,
        private readonly array $offerStrategies = []
    ) {
    }

    /**
     * Add a product to the basket
     *
     * @param string $productCode The code of the product to add
     * @throws \InvalidArgumentException If the product code is not found in the catalog
     */
    public function add(string $productCode): void
    {
        if (!isset($this->catalog[$productCode])) {
            throw new \InvalidArgumentException("Product with code '{$productCode}' not found in catalog");
        }

        $this->products[] = $this->catalog[$productCode];
    }

    /**
     * Calculate the total cost of the basket including delivery and offers
     *
     * @return float The total cost in USD
     */
    public function total(): float
    {
        $subtotal = $this->calculateSubtotal();
        $discount = $this->calculateDiscount();
        $afterDiscount = $subtotal - $discount;
        $deliveryCost = $this->deliveryStrategy->calculateDeliveryCost($this);

        return round($afterDiscount + $deliveryCost, 2);
    }

    /**
     * Get the subtotal before discounts and delivery
     *
     * @return float The subtotal in USD
     */
    public function getSubtotal(): float
    {
        return $this->calculateSubtotal();
    }

    /**
     * Get the total after discounts but before delivery
     *
     * @return float The discounted total in USD
     */
    public function getDiscountedTotal(): float
    {
        return $this->calculateSubtotal() - $this->calculateDiscount();
    }

    /**
     * Calculate the subtotal of all products in the basket
     *
     * @return float The subtotal in USD
     */
    private function calculateSubtotal(): float
    {
        return array_sum(
            array_map(
                fn (Product $product) => $product->getPrice(),
                $this->products
            )
        );
    }

    /**
     * Calculate the total discount from all offers
     *
     * @return float The total discount in USD
     */
    private function calculateDiscount(): float
    {
        return array_sum(
            array_map(
                fn (OfferStrategyInterface $strategy) => $strategy->applyOffer($this),
                $this->offerStrategies
            )
        );
    }

    /**
     * Get all products in the basket
     *
     * @return array<Product>
     */
    public function getProducts(): array
    {
        return $this->products;
    }
}
