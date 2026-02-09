<?php

declare(strict_types=1);

namespace Phauthentic\Specification;

use InvalidArgumentException;

/**
 *
 */
class CompositeSpecification extends AbstractSpecification
{
    /**
     * @var array<int, \Phauthentic\Specification\SpecificationInterface>
     */
    protected array $specifications = [];

    /**
     * @param array<int, \Phauthentic\Specification\SpecificationInterface> $specifications
     */
    public function __construct(array $specifications)
    {
        $this->assertSpecifications($specifications);
    }

    protected function assertSpecifications(array $specifications): void
    {
        foreach ($specifications as $specification) {
            if (!$specification instanceof SpecificationInterface) {
                throw new InvalidArgumentException(sprintf(
                    '%s is not an instance of %s',
                    get_debug_type($specification),
                    SpecificationInterface::class
                ));
            }

            $this->specifications[] = $specification;
        }
    }

    public function isSatisfiedBy(mixed $candidate): bool
    {
        foreach ($this->specifications as $specification) {
            if (!$specification->isSatisfiedBy($candidate)) {
                return false;
            }
        }

        return true;
    }
}
