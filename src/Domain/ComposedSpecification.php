<?php

declare(strict_types=1);

namespace Tja\PhpSpecification\Domain;

abstract class ComposedSpecification extends Specification
{
    private ?SpecificationInterface $specification = null;

    abstract protected function getSpecification(): SpecificationInterface;

    public function isSatisfiedBy(mixed $value = null): bool
    {
        return $this->initializeSpecification()->isSatisfiedBy();
    }

    public function getRule(): string
    {
        return $this->initializeSpecification()->getRule();
    }

    public function getParameters(): array
    {
        return $this->initializeSpecification()->getParameters();
    }

    private function initializeSpecification(): SpecificationInterface
    {
        if ($this->specification === null) {
            $this->specification = $this->getSpecification();
        }

        return $this->specification;
    }
}
