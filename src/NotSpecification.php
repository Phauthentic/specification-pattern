<?php

declare(strict_types=1);

namespace Phauthentic\Specification;

class NotSpecification extends AbstractSpecification
{
    protected SpecificationInterface $wrapped;

    public function __construct(SpecificationInterface $x)
    {
        $this->wrapped = $x;
    }

    public function isSatisfiedBy($candidate): bool
    {
        return !$this->wrapped->isSatisfiedBy($candidate);
    }
}
