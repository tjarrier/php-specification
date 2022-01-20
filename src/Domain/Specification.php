<?php

declare(strict_types=1);

namespace Tja\PhpSpecification\Domain;

abstract class Specification implements SpecificationInterface
{
    public function andX(array $specifications = []): AndX
    {
        return new AndX([$this, $specifications]);
    }

    public function orX(array $specifications = []): OrX
    {
        return new OrX([$this, $specifications]);
    }
}
