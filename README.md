# Acme Widget Co. Basket Implementation

Coding test challenge for ThriveCart
This is a proof of concept implementation of a shopping basket system for Acme Widget Co.

## Features

- Product catalog management
- Tiered delivery cost calculation
- Special offer handling (e.g., "buy one red widget, get the second half price")
- Unit tests for all scenarios
- Docker development environment

## Requirements

- PHP 8.2 or higher
- Docker and Docker Compose
- Composer

## Installation

1. Clone the repository:
```bash
git clone <repository-url>
cd acme-widget-basket
```

2. Install dependencies:
```bash
composer install
```

3. Start the Docker environment:
```bash
docker-compose up -d
```

## Running Tests

```bash
# Using Docker
docker-compose exec app composer test

# Or locally
composer test
```

## Running Static Analysis

```bash
# Using Docker
docker-compose exec app composer analyse

# Or locally
composer analyse
```

## Project Structure

```
src/
├── Domain/
│   ├── Basket.php
│   ├── Product.php
│   ├── Delivery/
│   │   ├── DeliveryStrategyInterface.php
│   │   └── TieredDeliveryStrategy.php
│   └── Offer/
│       ├── OfferStrategyInterface.php
│       └── RedWidgetHalfPriceStrategy.php
tests/
└── Domain/
    └── BasketTest.php
```

## Design Decisions

1. **Domain-Driven Design**: The solution is organized around domain concepts (Basket, Product, Delivery, Offer).
2. **Strategy Pattern**: Used for both delivery cost calculation and special offers, making it easy to add new rules.
3. **Dependency Injection**: The Basket class accepts its dependencies through the constructor.
4. **Immutability**: Product objects are immutable to prevent accidental state changes.
5. **Type Safety**: Strict typing and return type declarations throughout the codebase.

## Assumptions

1. All prices are in USD
2. Product codes are case-sensitive
3. Delivery costs are calculated based on the basket total
4. Special offers are applied before delivery costs
5. The product catalog is fixed and provided at basket initialization

## Example Usage

```php
$catalog = [
    'B01' => new Product('B01', 'Blue Widget', 7.95),
    'G01' => new Product('G01', 'Green Widget', 24.95),
    'R01' => new Product('R01', 'Red Widget', 32.95),
];

$basket = new Basket(
    $catalog,
    new TieredDeliveryStrategy(),
    [new RedWidgetHalfPriceStrategy()]
);

$basket->add('B01');
$basket->add('G01');

$total = $basket->total(); // Returns 37.85
```
