<?php

declare(strict_types=1);

namespace Phauthentic\Specification\Examples\ECommerce\Specifications\Customer;

use Phauthentic\Specification\AbstractSpecification;
use Phauthentic\Specification\Examples\ECommerce\Models\Customer;
use Phauthentic\Specification\Examples\ECommerce\Models\Order;

/**
 * Specification for checking if a customer hasn't used flash sale recently
 */
class HasNotUsedFlashSaleRecentlySpecification extends AbstractSpecification
{
    public function __construct(
        private int $cooldownDays = 7
    ) {
    }

    public function isSatisfiedBy(mixed $candidate): bool
    {
        $customer = $this->getCustomerFromCandidate($candidate);
        if (!$customer) {
            return false;
        }

        $daysSinceLastFlashSale = $customer->daysSinceLastFlashSale();

        // If never used flash sale, it's okay
        if ($daysSinceLastFlashSale === null) {
            return true;
        }

        return $daysSinceLastFlashSale >= $this->cooldownDays;
    }

    private function getCustomerFromCandidate(mixed $candidate): ?Customer
    {
        if ($candidate instanceof Customer) {
            return $candidate;
        }

        if ($candidate instanceof Order) {
            return $candidate->customer;
        }

        return null;
    }
}