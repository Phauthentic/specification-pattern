<?php

declare(strict_types=1);

namespace Phauthentic\Specification\Examples\ECommerce\Specifications\Order;

use Phauthentic\Specification\AbstractSpecification;
use Phauthentic\Specification\Examples\ECommerce\Models\Order;

/**
 * Specification for checking if an order has minimum number of items
 */
class MinimumItemCountSpecification extends AbstractSpecification
{
    public function __construct(
        private int $minimumCount
    ) {
    }

    public function isSatisfiedBy(mixed $candidate): bool
    {
        if (!$candidate instanceof Order) {
            return false;
        }

        return $candidate->itemCount >= $this->minimumCount;
    }
}