<?php

declare(strict_types=1);

namespace Phauthentic\Specification\Test;

use Phauthentic\Specification\AndSpecification;
use Phauthentic\Specification\Test\Specifications\ClosureSpecification;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(AndSpecification::class)]
final class AndSpecificationTest extends TestCase
{
    /**
     *
     */
    public function testAndSpecification(): void
    {
        $spec1 = new ClosureSpecification(function ($candidate) {
            return $candidate === 'test';
        });

        $spec2 = new ClosureSpecification(function ($candidate) {
            return is_string($candidate);
        });

        $spec = new AndSpecification(
            $spec1,
            $spec2
        );

        $this->assertTrue($spec->isSatisfiedBy('test'));
        $this->assertFalse($spec->isSatisfiedBy('test2'));
    }
}
