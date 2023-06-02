<?php

declare(strict_types=1);

namespace Phauthentic\Specification\Test\Specifications;

use Closure;
use Phauthentic\Specification\AbstractSpecification;

class ClosureSpecification extends AbstractSpecification
{
    public function __construct(
        protected Closure $callable
    ) {
    }

    public function isSatisfiedBy($candidate): bool
    {
        $callable = $this->callable;

        return $callable($candidate);
    }
}
