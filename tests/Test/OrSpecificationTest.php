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

use Phauthentic\Specification\OrSpecification;
use Phauthentic\Specification\Test\Specifications\ClosureSpecification;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(OrSpecification::class)]
final class OrSpecificationTest extends TestCase
{
    public function testOrSpecification(): void
    {
        $is2000 = new ClosureSpecification(function ($candidate) {
            return $candidate === '2000';
        });

        $is2022 = new ClosureSpecification(function ($candidate) {
            return $candidate === '2022';
        });

        $spec = new OrSpecification($is2000, $is2022);
        $this->assertTrue($spec->isSatisfiedBy('2000'));
        $this->assertTrue($spec->isSatisfiedBy('2022'));
        $this->assertFalse($spec->isSatisfiedBy('2030'));
    }
}
