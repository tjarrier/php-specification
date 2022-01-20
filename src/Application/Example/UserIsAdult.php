<?php

declare(strict_types=1);

namespace Tja\PhpSpecification\Application\Example;

use Tja\PhpSpecification\Domain\Example\User;
use Tja\PhpSpecification\Domain\Specification;

final class UserIsAdult extends Specification
{
    /**
     * @var int
     */
    public const EUROPEAN_ADULT_AGE = 18;

    public function __construct(private User $user)
    {
    }

    public function isSatisfiedBy(mixed $value = null): bool
    {
        return $this->user->age() >= $value;
    }

    public function getRule(): string
    {
        return ':age >= ' . self::EUROPEAN_ADULT_AGE;
    }

    /**
     * @return array<string, int>
     */
    public function getParameters(): array
    {
        return [
            'age' => $this->user->age()
        ];
    }
}
