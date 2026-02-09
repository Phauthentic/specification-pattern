<?php

declare(strict_types=1);

namespace Phauthentic\Specification\Examples\ECommerce\Specifications\Product;

use Phauthentic\Specification\AbstractSpecification;
use Phauthentic\Specification\Examples\ECommerce\Models\Product;

/**
 * Specification for checking if a product is not on clearance
 */
class IsNotClearanceSpecification extends AbstractSpecification
{
    public function isSatisfiedBy(mixed $candidate): bool
    {
        if (!$candidate instanceof Product) {
            return false;
        }

        return !$candidate->isClearance;
    }
}