<?php

declare(strict_types=1);

namespace Tja\PhpSpecification\Domain\Example;

final class User
{
    private function __construct(
        private string $firstName,
        private string $lastName,
        private bool $isActive,
        private int $age
    ) {
    }

    public static function create(
        string $firstName,
        string $lastName,
        bool $isActive,
        int $age
    ): self {
        return new self($firstName, $lastName, $isActive, $age);
    }

    public function firstName(): string
    {
        return $this->firstName;
    }

    public function lastName(): string
    {
        return $this->lastName;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function age(): int
    {
        return $this->age;
    }
}
