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
use Phauthentic\Specification\Examples\ECommerce\Specifications\Customer\IsVipCustomerSpecification;
use Phauthentic\Specification\Examples\ECommerce\Specifications\Customer\AccountAgeSpecification;
use Phauthentic\Specification\Examples\ECommerce\Specifications\Order\MinimumOrderValueSpecification;
use Phauthentic\Specification\Examples\ECommerce\Specifications\Order\ContainsProductCategorySpecification;
use Phauthentic\Specification\Examples\ECommerce\Specifications\Time\DateRangeSpecification;

/**
 * Black Friday VIP Campaign Specification
 *
 * Business Rules:
 * - Customer must be VIP (gold/platinum tier)
 * - Order total must be at least $100
 * - Must include products from electronics OR fashion categories
 * - Customer account must be older than 6 months
 * - Promotion valid only during November 20-30
 */
class BlackFridayVipCampaign extends AbstractSpecification
{
    private AbstractSpecification $specification;

    public function __construct()
    {
        // Customer must be VIP
        $vipSpec = new IsVipCustomerSpecification(['gold', 'platinum']);

        // Order minimum value
        $minValueSpec = new MinimumOrderValueSpecification(100.0);

        // Contains electronics or fashion products
        $electronicsSpec = new ContainsProductCategorySpecification(['electronics']);
        $fashionSpec = new ContainsProductCategorySpecification(['fashion']);
        $categorySpec = $electronicsSpec->or($fashionSpec);

        // Account older than 6 months (180 days)
        $accountAgeSpec = new AccountAgeSpecification(180, 'min');

        // Valid during Black Friday period
        $dateRangeSpec = new DateRangeSpecification('2025-11-20', '2025-11-30');

        // Combine all specifications for the order
        $this->specification = $vipSpec
            ->and($minValueSpec)
            ->and($categorySpec)
            ->and($accountAgeSpec)
            ->and($dateRangeSpec);
    }

    public function isSatisfiedBy(mixed $candidate): bool
    {
        if (!$candidate instanceof Order) {
            return false;
        }

        // Check individual specifications for debugging
        $vipSpec = new IsVipCustomerSpecification(['gold', 'platinum']);
        $minValueSpec = new MinimumOrderValueSpecification(100.0);
        $electronicsSpec = new ContainsProductCategorySpecification(['electronics']);
        $fashionSpec = new ContainsProductCategorySpecification(['fashion']);
        $categorySpec = $electronicsSpec->or($fashionSpec);
        $accountAgeSpec = new AccountAgeSpecification(180, 'min');
        $dateSpec = new DateRangeSpecification('2025-11-20', '2025-11-30');

        // All specifications checked individually for clarity

        return $vipSpec->isSatisfiedBy($candidate) &&
               $minValueSpec->isSatisfiedBy($candidate) &&
               $categorySpec->isSatisfiedBy($candidate) &&
               $accountAgeSpec->isSatisfiedBy($candidate) &&
               $dateSpec->isSatisfiedBy($candidate->createdAt);
    }
}