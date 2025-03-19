<?php

declare(strict_types=1);

namespace Acme\WidgetBasket\Domain;

/**
 * Represents a product in the Acme Widget Co. catalog
 */
final class Product
{
    /**
     * @param string $code The unique product code
     * @param string $name The product name
     * @param float $price The product price in USD
     */
    public function __construct(
        private readonly string $code,
        private readonly string $name,
        private readonly float $price
    ) {
    }

    /**
     * Get the product code
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * Get the product name
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the product price
     */
    public function getPrice(): float
    {
        return $this->price;
    }
}
