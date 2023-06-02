<?php

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
