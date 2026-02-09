<?php

declare(strict_types=1);

namespace Phauthentic\Specification\Examples\ECommerce\Specifications\Product;

use Phauthentic\Specification\AbstractSpecification;
use Phauthentic\Specification\Examples\ECommerce\Models\Product;

/**
 * Specification for checking if a product price is within a range
 */
class PriceRangeSpecification extends AbstractSpecification
{
    public function __construct(
        private ?float $minPrice = null,
        private ?float $maxPrice = null
    ) {
    }

    public function isSatisfiedBy(mixed $candidate): bool
    {
        if (!$candidate instanceof Product) {
            return false;
        }

        if ($this->minPrice !== null && $candidate->price < $this->minPrice) {
            return false;
        }

        if ($this->maxPrice !== null && $candidate->price > $this->maxPrice) {
            return false;
        }

        return true;
    }
}