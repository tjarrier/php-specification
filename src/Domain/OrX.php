<?php

declare(strict_types=1);

namespace Tja\PhpSpecification\Domain;

final class OrX extends Composite
{
    public function __construct(array $specifications = [])
    {
        parent::__construct('OR', $specifications);
    }

    public function isSatisfiedBy(mixed $value = null): bool
    {
        foreach ($this->specifications as $specification) {
            if ($specification->isSatisfiedBy($value)) {
                return true;
            }
        }

        return false;
    }
}
