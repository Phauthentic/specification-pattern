<?php

declare(strict_types=1);

namespace Phauthentic\Specification\Test;

use InvalidArgumentException;
use Phauthentic\Specification\CompositeSpecification;
use Phauthentic\Specification\Test\Specifications\ClosureSpecification;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CompositeSpecification::class)]
final class CompositeSpecificationTest extends TestCase
{
    /**
     * * Tests that constructor accepts valid specifications array
     */
    public function testConstructorWithValidSpecifications(): void
    {
        $spec1 = new ClosureSpecification(function ($candidate) {
            return $candidate === 'test';
        });

        $spec2 = new ClosureSpecification(function ($candidate) {
            return is_string($candidate);
        });

        $composite = new CompositeSpecification([$spec1, $spec2]);

        $this->assertInstanceOf(CompositeSpecification::class, $composite);
    }

    /**
     * * Tests that constructor throws InvalidArgumentException for invalid specifications
     */
    public function testConstructorWithInvalidSpecifications(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('is not an instance of');

        new CompositeSpecification(['invalid', 'specification']);
    }

    /**
     * * Tests that constructor throws InvalidArgumentException for mixed array
     */
    public function testConstructorWithMixedArray(): void
    {
        $spec1 = new ClosureSpecification(function ($candidate) {
            return $candidate === 'test';
        });

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('is not an instance of');

        new CompositeSpecification([$spec1, 'invalid']);
    }

    /**
     * * Tests isSatisfiedBy returns true when all specifications are satisfied
     */
    public function testIsSatisfiedByReturnsTrueWhenAllSatisfied(): void
    {
        $spec1 = new ClosureSpecification(function ($candidate) {
            return $candidate === 'test';
        });

        $spec2 = new ClosureSpecification(function ($candidate) {
            return is_string($candidate);
        });

        $composite = new CompositeSpecification([$spec1, $spec2]);

        $this->assertTrue($composite->isSatisfiedBy('test'));
    }

    /**
     * * Tests isSatisfiedBy returns false when any specification is not satisfied
     */
    public function testIsSatisfiedByReturnsFalseWhenAnyNotSatisfied(): void
    {
        $spec1 = new ClosureSpecification(function ($candidate) {
            return $candidate === 'test';
        });

        $spec2 = new ClosureSpecification(function ($candidate) {
            return is_string($candidate);
        });

        $composite = new CompositeSpecification([$spec1, $spec2]);

        $this->assertFalse($composite->isSatisfiedBy('test2'));
        $this->assertFalse($composite->isSatisfiedBy(123));
    }

    /**
     * * Tests isSatisfiedBy with empty array (edge case)
     */
    public function testIsSatisfiedByWithEmptyArray(): void
    {
        $composite = new CompositeSpecification([]);

        // * Empty composite should return true (all zero specifications are satisfied)
        $this->assertTrue($composite->isSatisfiedBy('anything'));
    }

    /**
     * * Tests isSatisfiedBy with single specification
     */
    public function testIsSatisfiedByWithSingleSpecification(): void
    {
        $spec1 = new ClosureSpecification(function ($candidate) {
            return $candidate === 'test';
        });

        $composite = new CompositeSpecification([$spec1]);

        $this->assertTrue($composite->isSatisfiedBy('test'));
        $this->assertFalse($composite->isSatisfiedBy('test2'));
    }

    /**
     * * Tests isSatisfiedBy with multiple specifications - first fails
     */
    public function testIsSatisfiedByWithMultipleSpecificationsFirstFails(): void
    {
        $spec1 = new ClosureSpecification(function ($candidate) {
            return $candidate === 'test';
        });

        $spec2 = new ClosureSpecification(function ($candidate) {
            return is_string($candidate);
        });

        $spec3 = new ClosureSpecification(function ($candidate) {
            return strlen($candidate) > 3;
        });

        $composite = new CompositeSpecification([$spec1, $spec2, $spec3]);

        // * First spec fails
        $this->assertFalse($composite->isSatisfiedBy('test2'));
    }

    /**
     * * Tests isSatisfiedBy with multiple specifications - middle fails
     */
    public function testIsSatisfiedByWithMultipleSpecificationsMiddleFails(): void
    {
        $spec1 = new ClosureSpecification(function ($candidate) {
            return $candidate === 'test';
        });

        $spec2 = new ClosureSpecification(function ($candidate) {
            return is_int($candidate);
        });

        $spec3 = new ClosureSpecification(function ($candidate) {
            return strlen((string)$candidate) > 3;
        });

        $composite = new CompositeSpecification([$spec1, $spec2, $spec3]);

        // * Middle spec fails
        $this->assertFalse($composite->isSatisfiedBy('test'));
    }
}
