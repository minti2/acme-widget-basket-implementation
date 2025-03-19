<?php

declare(strict_types=1);

namespace Acme\WidgetBasket\Domain\Delivery;

use Acme\WidgetBasket\Domain\Basket;

/**
 * Interface for delivery cost calculation strategies
 */
interface DeliveryStrategyInterface
{
    /**
     * Calculate delivery cost for a given basket
     *
     * @param Basket $basket The basket to calculate delivery cost for
     * @return float The delivery cost in USD
     */
    public function calculateDeliveryCost(Basket $basket): float;
}
