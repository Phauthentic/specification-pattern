<?php

declare(strict_types=1);

namespace Phauthentic\Specification\Examples\ECommerce\Specifications\Product;

use Phauthentic\Specification\AbstractSpecification;
use Phauthentic\Specification\Examples\ECommerce\Models\Product;

/**
 * Specification for checking if a product belongs to specific categories
 */
class ProductCategorySpecification extends AbstractSpecification
{
    /**
     * @param array<string> $allowedCategories
     */
    public function __construct(
        private array $allowedCategories
    ) {
    }

    public function isSatisfiedBy(mixed $candidate): bool
    {
        if (!$candidate instanceof Product) {
            return false;
        }

        return in_array($candidate->category, $this->allowedCategories, true);
    }
}