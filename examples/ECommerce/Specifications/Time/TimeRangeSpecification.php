<?php

declare(strict_types=1);

namespace Phauthentic\Specification\Examples\ECommerce\Specifications\Time;

use Phauthentic\Specification\AbstractSpecification;

/**
 * Specification for checking if a time is within a specific range (flash sale hours)
 */
class TimeRangeSpecification extends AbstractSpecification
{
    public function __construct(
        private string $startTime, // H:i format (e.g., "09:00")
        private string $endTime    // H:i format (e.g., "17:00")
    ) {
    }

    public function isSatisfiedBy(mixed $candidate): bool
    {
        if (!$candidate instanceof \DateTimeImmutable) {
            return false;
        }

        $currentTime = $candidate->format('H:i');
        $startTime = $this->startTime;
        $endTime = $this->endTime;

        // Handle time ranges that span midnight (e.g., 22:00 to 02:00)
        if ($startTime > $endTime) {
            return $currentTime >= $startTime || $currentTime <= $endTime;
        }

        return $currentTime >= $startTime && $currentTime <= $endTime;
    }
}