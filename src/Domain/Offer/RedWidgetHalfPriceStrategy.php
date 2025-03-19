<?php

declare(strict_types=1);

namespace Acme\WidgetBasket\Domain\Offer;

use Acme\WidgetBasket\Domain\Basket;
use Acme\WidgetBasket\Domain\Product;

/**
 * Implements the "buy one red widget, get the second half price" offer
 */
final class RedWidgetHalfPriceStrategy implements OfferStrategyInterface
{
    private const RED_WIDGET_CODE = 'R01';

    /**
     * Apply the red widget half price offer
     *
     * @param Basket $basket The basket to apply the offer to
     * @return float The discount amount in USD
     */
    public function applyOffer(Basket $basket): float
    {
        $redWidgets = array_values($this->getRedWidgets($basket));
        $redWidgetCount = count($redWidgets);

        if ($redWidgetCount < 2) {
            return 0.0;
        }

        $pairs = floor($redWidgetCount / 2);
        return round($redWidgets[0]->getPrice() * 0.5 * $pairs, 2);
    }

    /**
     * Get all red widgets from the basket
     *
     * @param Basket $basket The basket to get red widgets from
     * @return array<Product>
     */
    private function getRedWidgets(Basket $basket): array
    {
        return array_values(array_filter(
            $basket->getProducts(),
            fn (Product $product) => $product->getCode() === self::RED_WIDGET_CODE
        ));
    }
}
