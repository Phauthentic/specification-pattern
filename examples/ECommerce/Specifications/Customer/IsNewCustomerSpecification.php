<?php

declare(strict_types=1);

namespace Phauthentic\Specification\Examples\ECommerce\Specifications\Customer;

use Phauthentic\Specification\AbstractSpecification;
use Phauthentic\Specification\Examples\ECommerce\Models\Customer;
use Phauthentic\Specification\Examples\ECommerce\Models\Order;

/**
 * Specification for checking if a customer is new (account created recently)
 */
class IsNewCustomerSpecification extends AbstractSpecification
{
    public function __construct(
        private int $maxAgeInDays = 30
    ) {
    }

    public function isSatisfiedBy(mixed $candidate): bool
    {
        $customer = $this->getCustomerFromCandidate($candidate);
        if (!$customer) {
            return false;
        }

        return $customer->getAccountAgeInDays() <= $this->maxAgeInDays;
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