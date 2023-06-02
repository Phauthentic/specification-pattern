<?php

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
