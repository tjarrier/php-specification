<?php

declare(strict_types=1);

namespace Tja\PhpSpecification\Domain;

interface SpecificationInterface
{
    public function isSatisfiedBy(mixed $value): bool;

    public function getRule(): string;

    public function getParameters(): array;
}
