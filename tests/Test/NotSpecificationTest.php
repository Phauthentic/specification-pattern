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

use Phauthentic\Specification\NotSpecification;
use Phauthentic\Specification\Test\Specifications\ClosureSpecification;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(NotSpecification::class)]
final class NotSpecificationTest extends TestCase
{
    /**
     *
     */
    public function testNotSpecification(): void
    {
        $spec1 = new ClosureSpecification(function ($candidate) {
            return $candidate === 'test';
        });

        $spec = new NotSpecification($spec1);

        $this->assertFalse($spec->isSatisfiedBy('test'));
        $this->assertTrue($spec->isSatisfiedBy('test1'));
    }
}
