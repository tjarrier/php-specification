<?php

declare(strict_types=1);

namespace Tja\PhpSpecification\Domain;

final class AndX extends Composite
{
    public function __construct(array $specifications = [])
    {
        parent::__construct('AND', $specifications);
    }

    public function isSatisfiedBy(mixed $value): bool
    {
        foreach ($this->specifications as $specification) {
            if (!$specification->isSatisfiedBy($value)) {
                return false;
            }
        }

        return true;
    }
}
