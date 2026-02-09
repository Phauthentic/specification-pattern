<?php

declare(strict_types=1);

namespace Phauthentic\Specification\Examples\ECommerce\Specifications\Order;

use Phauthentic\Specification\AbstractSpecification;
use Phauthentic\Specification\Examples\ECommerce\Models\Order;

/**
 * Specification for checking if this is the customer's first order
 */
class IsFirstOrderSpecification extends AbstractSpecification
{
    public function isSatisfiedBy(mixed $candidate): bool
    {
        if (!$candidate instanceof Order) {
            return false;
        }

        return $candidate->isFirstOrder;
    }
}