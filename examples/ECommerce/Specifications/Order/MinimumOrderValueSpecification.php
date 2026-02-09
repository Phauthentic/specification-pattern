<?php

declare(strict_types=1);

namespace Phauthentic\Specification\Examples\ECommerce\Specifications\Order;

use Phauthentic\Specification\AbstractSpecification;
use Phauthentic\Specification\Examples\ECommerce\Models\Order;

/**
 * Specification for checking if an order meets minimum value requirement
 */
class MinimumOrderValueSpecification extends AbstractSpecification
{
    public function __construct(
        private float $minimumValue
    ) {
    }

    public function isSatisfiedBy(mixed $candidate): bool
    {
        if (!$candidate instanceof Order) {
            return false;
        }

        return $candidate->totalAmount >= $this->minimumValue;
    }
}