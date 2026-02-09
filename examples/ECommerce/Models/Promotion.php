<?php

declare(strict_types=1);

namespace Phauthentic\Specification\Examples\ECommerce\Models;

use Phauthentic\Specification\SpecificationInterface;

/**
 * Promotion entity representing a promotional campaign
 */
readonly class Promotion
{
    public function __construct(
        public string $id,
        public string $name,
        public string $description,
        public int $discountPercentage,
        public SpecificationInterface $eligibilitySpecification
    ) {
    }

    public function isEligible(mixed $candidate): bool
    {
        return $this->eligibilitySpecification->isSatisfiedBy($candidate);
    }

    public function calculateDiscount(float $originalAmount): float
    {
        return $originalAmount * ($this->discountPercentage / 100);
    }

    public function calculateFinalPrice(float $originalAmount): float
    {
        return $originalAmount - $this->calculateDiscount($originalAmount);
    }
}