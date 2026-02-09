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

namespace Phauthentic\Specification\Test;

use Phauthentic\Specification\AndNotSpecification;
use Phauthentic\Specification\Test\Specifications\ClosureSpecification;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(AndNotSpecification::class)]
final class AndNotSpecificationTest extends TestCase
{
    /**
     *
     */
    public function testAndNotSpecification(): void
    {
        $spec1 = new ClosureSpecification(function ($candidate) {
            return $candidate === 'test';
        });

        $spec2 = new ClosureSpecification(function ($candidate) {
            return $candidate === 'test2';
        });

        $andNotSpecification = new AndNotSpecification(
            $spec1,
            $spec2
        );

        $this->assertTrue($andNotSpecification->isSatisfiedBy('test'));

        $andNotSpecification = new AndNotSpecification(
            $spec1,
            $spec2
        );

        $this->assertFalse($andNotSpecification->isSatisfiedBy('test2'));
    }
}
