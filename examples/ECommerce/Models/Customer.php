<?php

declare(strict_types=1);

namespace Phauthentic\Specification\Examples\ECommerce\Models;

/**
 * Customer entity representing a customer in the e-commerce system
 */
readonly class Customer
{
    public function __construct(
        public string $id,
        public string $name,
        public string $email,
        public string $tier, // bronze, silver, gold, platinum
        public int $loyaltyPoints,
        public \DateTimeImmutable $accountCreatedAt,
        public ?\DateTimeImmutable $lastFlashSaleUsed,
        public bool $isNewsletterSubscriber
    ) {
    }

    public function getAccountAgeInDays(): int
    {
        return $this->accountCreatedAt->diff(new \DateTimeImmutable())->days;
    }

    public function daysSinceLastFlashSale(): ?int
    {
        if ($this->lastFlashSaleUsed === null) {
            return null;
        }

        return $this->lastFlashSaleUsed->diff(new \DateTimeImmutable())->days;
    }
}