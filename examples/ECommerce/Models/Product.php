<?php

declare(strict_types=1);

namespace Phauthentic\Specification\Examples\ECommerce\Models;

/**
 * Product entity representing a product in the e-commerce system
 */
readonly class Product
{
    public function __construct(
        public string $id,
        public string $name,
        public string $category, // electronics, fashion, home, books, etc.
        public float $price,
        public bool $isClearance,
        public bool $isDigital,
        public int $stockQuantity
    ) {
    }

    public function isInStock(): bool
    {
        return $this->stockQuantity > 0;
    }

    public function isGiftCard(): bool
    {
        return str_contains(strtolower($this->name), 'gift card') ||
               str_contains(strtolower($this->category), 'gift');
    }
}