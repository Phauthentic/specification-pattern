<?php

declare(strict_types=1);

namespace Phauthentic\Specification\Examples\ECommerce\Specifications\Campaigns;

use Phauthentic\Specification\AbstractSpecification;
use Phauthentic\Specification\Examples\ECommerce\Models\Order;
use Phauthentic\Specification\Examples\ECommerce\Specifications\Customer\HasNotUsedFlashSaleRecentlySpecification;
use Phauthentic\Specification\Examples\ECommerce\Specifications\Order\ContainsProductCategorySpecification;
use Phauthentic\Specification\Examples\ECommerce\Specifications\Time\TimeRangeSpecification;

/**
 * Flash Sale Campaign Specification
 *
 * Business Rules:
 * - Time-sensitive (valid for specific hours, e.g., 12:00-14:00)
 * - Limited to specific product categories (electronics, fashion)
 * - Customer must not have used flash sale in last 7 days
 */
class FlashSaleCampaign extends AbstractSpecification
{
    private AbstractSpecification $specification;

    public function __construct()
    {
        // Customer hasn't used flash sale recently
        $flashSaleCooldownSpec = new HasNotUsedFlashSaleRecentlySpecification(7);

        // Limited to electronics and fashion categories
        $categorySpec = new ContainsProductCategorySpecification(['electronics', 'fashion']);

        // Time range (e.g., noon to 2 PM)
        $timeRangeSpec = new TimeRangeSpecification('12:00', '14:00');

        // Combine specifications
        $this->specification = $flashSaleCooldownSpec
            ->and($categorySpec)
            ->and($timeRangeSpec);
    }

    public function isSatisfiedBy(mixed $candidate): bool
    {
        if (!$candidate instanceof Order) {
            return false;
        }

        // Check customer and product specifications
        $customerProductSpec = (new HasNotUsedFlashSaleRecentlySpecification(7))
            ->and(new ContainsProductCategorySpecification(['electronics', 'fashion']));

        // Check time range against order creation time
        $timeSpec = new TimeRangeSpecification('12:00', '14:00');

        return $customerProductSpec->isSatisfiedBy($candidate) &&
               $timeSpec->isSatisfiedBy($candidate->createdAt);
    }
}