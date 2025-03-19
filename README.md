# Acme Widget Co. Basket Implementation

Coding test challenge for ThriveCart
This is a proof of concept implementation of a shopping basket system for Acme Widget Co.

## Features

- Product catalog management with predefined products
- Tiered delivery cost calculation based on order total
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
git clone https://github.com/minti2/acme-widget-basket-implementation.git
cd acme-widget-basket-implementation
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
│   ├── Basket.php              # Main basket implementation
│   ├── Product.php             # Product value object
│   ├── Delivery/
│   │   ├── DeliveryStrategyInterface.php
│   │   └── TieredDeliveryStrategy.php
│   └── Offer/
│       ├── OfferStrategyInterface.php
│       └── RedWidgetHalfPriceStrategy.php
tests/
└── Domain/
    └── BasketTest.php          # Test cases for basket functionality
```

## Design Decisions

1. **Domain-Driven Design**: The solution is organized around domain concepts (Basket, Product, Delivery, Offer).
2. **Strategy Pattern**: Used for both delivery cost calculation and special offers, making it easy to add new rules.
3. **Dependency Injection**: The Basket class accepts its dependencies through the constructor.
4. **Immutability**: Product objects are immutable to prevent accidental state changes.
5. **Type Safety**: Strict typing and return type declarations throughout the codebase.

## Business Rules

1. **Delivery Costs**:
   - Orders under $50: $4.95
   - Orders under $90: $2.95
   - Orders $90 and over: Free delivery

2. **Special Offers**:
   - Red Widget Offer: Buy one red widget, get the second half price

3. **Product Catalog**:
   - B01: Blue Widget - $7.95
   - G01: Green Widget - $24.95
   - R01: Red Widget - $32.95

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
