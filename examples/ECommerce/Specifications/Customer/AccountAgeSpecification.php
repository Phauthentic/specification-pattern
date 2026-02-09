<?php

declare(strict_types=1);

namespace Phauthentic\Specification\Examples\ECommerce\Specifications\Customer;

use Phauthentic\Specification\AbstractSpecification;
use Phauthentic\Specification\Examples\ECommerce\Models\Customer;
use Phauthentic\Specification\Examples\ECommerce\Models\Order;

/**
 * Specification for checking customer account age
 */
class AccountAgeSpecification extends AbstractSpecification
{
    /**
     * @param int $thresholdDays Number of days for the threshold
     * @param 'min'|'max' $type Whether to check minimum or maximum age
     */
    public function __construct(
        private int $thresholdDays,
        private string $type = 'min'
    ) {
    }

    public function isSatisfiedBy(mixed $candidate): bool
    {
        $customer = $this->getCustomerFromCandidate($candidate);
        if (!$customer) {
            return false;
        }

        $accountAge = $customer->getAccountAgeInDays();

        return match ($this->type) {
            'min' => $accountAge >= $this->thresholdDays,
            'max' => $accountAge <= $this->thresholdDays,
            default => false,
        };
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