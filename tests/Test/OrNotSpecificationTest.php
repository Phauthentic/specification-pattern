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

use Phauthentic\Specification\OrNotSpecification;
use Phauthentic\Specification\Test\Specifications\ClosureSpecification;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(OrNotSpecification::class)]
final class OrNotSpecificationTest extends TestCase
{
    /**
     *
     */
    public function testOrNotSpecification(): void
    {
        $spec1 = new ClosureSpecification(function ($candidate) {
            return $candidate === 'test';
        });

        $spec2 = new ClosureSpecification(function ($candidate) {
            return $candidate === 'test2';
        });

        $spec = new OrNotSpecification(
            $spec1,
            $spec2
        );

        $this->assertTrue($spec->isSatisfiedBy('test'));
        $this->assertFalse($spec->isSatisfiedBy('test2'));
    }
}
