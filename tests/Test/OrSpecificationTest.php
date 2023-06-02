<?php

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
