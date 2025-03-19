<?php

declare(strict_types=1);

namespace Acme\WidgetBasket\Domain\Offer;

use Acme\WidgetBasket\Domain\Basket;

/**
 * Interface for special offer strategies
 */
interface OfferStrategyInterface
{
    /**
     * Apply the offer to the basket and return the discount amount
     *
     * @param Basket $basket The basket to apply the offer to
     * @return float The discount amount in USD
     */
    public function applyOffer(Basket $basket): float;
}
