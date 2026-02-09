<?php

/**
 * Copyright (c) Florian Krämer (https://florian-kraemer.net)
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE file
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Florian Krämer (https://florian-kraemer.net)
 * @author    Florian Krämer
 * @link      https://github.com/Phauthentic
 * @license   https://opensource.org/licenses/MIT MIT License
 */

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
