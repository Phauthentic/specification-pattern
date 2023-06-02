<?php

declare(strict_types=1);

namespace Phauthentic\Specification;

class AndSpecification extends AbstractSpecification
{
    protected SpecificationInterface $leftCondition;
    protected SpecificationInterface $rightCondition;

    public function __construct(
        SpecificationInterface $left,
        SpecificationInterface $right
    ) {
        $this->leftCondition = $left;
        $this->rightCondition = $right;
    }

    public function isSatisfiedBy($candidate): bool
    {
        return $this->leftCondition->isSatisfiedBy($candidate) && $this->rightCondition->isSatisfiedBy($candidate);
    }
}
