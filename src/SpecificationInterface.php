<?php

declare(strict_types=1);

namespace Phauthentic\Specification;

/**
 * Specification Interface
 *
 * @author Florian Krämer
 * @link https://en.wikipedia.org/wiki/Specification_pattern
 * @link http://www.martinfowler.com/apsupp/spec.pdf
 */
interface SpecificationInterface
{
    /**
     * @param mixed $candidate
     * @return bool
     */
    public function isSatisfiedBy(mixed $candidate): bool;
    public function and(SpecificationInterface $other): SpecificationInterface;
    public function andNot(SpecificationInterface $other): SpecificationInterface;
    public function or(SpecificationInterface $other): SpecificationInterface;
    public function orNot(SpecificationInterface $other): SpecificationInterface;

    /**
     * Not operator
     */
    public function not(SpecificationInterface $other): SpecificationInterface;
}
