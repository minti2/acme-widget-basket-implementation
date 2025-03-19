<?php

declare(strict_types=1);

namespace Acme\WidgetBasket\Domain\Delivery;

use Acme\WidgetBasket\Domain\Basket;

/**
 * Implements tiered delivery costs based on basket total
 */
final class TieredDeliveryStrategy implements DeliveryStrategyInterface
{
    private const FREE_DELIVERY_THRESHOLD = 90.00;
    private const MEDIUM_DELIVERY_THRESHOLD = 50.00;
    private const HIGH_DELIVERY_COST = 4.95;
    private const MEDIUM_DELIVERY_COST = 2.95;
    private const FREE_DELIVERY_COST = 0.00;

    /**
     * Calculate delivery cost based on basket total
     *
     * @param Basket $basket The basket to calculate delivery cost for
     * @return float The delivery cost in USD
     */
    public function calculateDeliveryCost(Basket $basket): float
    {
        $total = $basket->getDiscountedTotal();

        if ($total >= self::FREE_DELIVERY_THRESHOLD) {
            return self::FREE_DELIVERY_COST;
        }

        if ($total >= self::MEDIUM_DELIVERY_THRESHOLD) {
            return self::MEDIUM_DELIVERY_COST;
        }

        return self::HIGH_DELIVERY_COST;
    }

    /**
     * Calculate the total after discounts
     *
     * @param Basket $basket The basket to calculate total for
     * @return float The total in USD
     */
    private function calculateTotal(Basket $basket): float
    {
        return $basket->getSubtotal();
    }
}
