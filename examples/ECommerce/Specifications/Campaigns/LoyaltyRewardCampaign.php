<?php

/**
 * Copyright (c) Florian Krämer (https://florian-kraemer.net)
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE file
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Florian Krämer (https://florian-kraemer.net)
 * @author    Florian Krämer
 * @link      https://github.com/Phauthentic
 * @license   https://opensource.org/licenses/MIT MIT License
 */

declare(strict_types=1);

namespace Phauthentic\Specification\Examples\ECommerce\Specifications\Campaigns;

use Phauthentic\Specification\AbstractSpecification;
use Phauthentic\Specification\Examples\ECommerce\Models\Order;
use Phauthentic\Specification\Examples\ECommerce\Specifications\Customer\HasLoyaltyPointsSpecification;
use Phauthentic\Specification\Examples\ECommerce\Specifications\Customer\AccountAgeSpecification;
use Phauthentic\Specification\Examples\ECommerce\Specifications\Order\MinimumItemCountSpecification;
use Phauthentic\Specification\Examples\ECommerce\Specifications\Product\IsNotClearanceSpecification;

/**
 * Loyalty Reward Campaign Specification
 *
 * Business Rules:
 * - Customer has 1000+ loyalty points
 * - Not a new customer (account > 30 days)
 * - Order contains at least 3 items
 * - Excludes clearance products
 */
class LoyaltyRewardCampaign extends AbstractSpecification
{
    private AbstractSpecification $specification;

    public function __construct()
    {
        // Customer has sufficient loyalty points
        $loyaltySpec = new HasLoyaltyPointsSpecification(1000);

        // Not a new customer (account older than 30 days)
        $accountAgeSpec = new AccountAgeSpecification(30, 'min');

        // Order has at least 3 items
        $itemCountSpec = new MinimumItemCountSpecification(3);

        // No clearance products (this will be checked via Order->hasClearanceItems)
        $notClearanceSpec = new IsNotClearanceSpecification();

        // Combine specifications - note: clearance check is handled in Order level
        $this->specification = $loyaltySpec
            ->and($accountAgeSpec)
            ->and($itemCountSpec);
    }

    public function isSatisfiedBy(mixed $candidate): bool
    {
        if (!$candidate instanceof Order) {
            return false;
        }

        // Check if order has clearance items
        if ($candidate->hasClearanceItems()) {
            return false;
        }

        return $this->specification->isSatisfiedBy($candidate);
    }
}