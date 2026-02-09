<?php

declare(strict_types=1);

namespace Phauthentic\Specification\Examples\ECommerce\Specifications\Time;

use Phauthentic\Specification\AbstractSpecification;

/**
 * Specification for checking if a date is within a specific range
 */
class DateRangeSpecification extends AbstractSpecification
{
    public function __construct(
        private string $startDate, // Y-m-d format
        private string $endDate    // Y-m-d format
    ) {
    }

    public function isSatisfiedBy(mixed $candidate): bool
    {
        if (!$candidate instanceof \DateTimeImmutable) {
            return false;
        }

        $start = \DateTimeImmutable::createFromFormat('Y-m-d', $this->startDate);
        $end = \DateTimeImmutable::createFromFormat('Y-m-d', $this->endDate);

        if (!$start || !$end) {
            return false;
        }

        // Set end date to end of day
        $end = $end->setTime(23, 59, 59);

        return $candidate >= $start && $candidate <= $end;
    }
}