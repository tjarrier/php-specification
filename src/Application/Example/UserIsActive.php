<?php

declare(strict_types=1);

namespace Tja\PhpSpecification\Application\Example;

use Tja\PhpSpecification\Domain\Example\User;
use Tja\PhpSpecification\Domain\Specification;

final class UserIsActive extends Specification
{
    public function __construct(private User $user)
    {
    }

    public function isSatisfiedBy(mixed $value): bool
    {
        return $this->user->isActive()
            && !empty($this->user->firstName())
            && !empty($this->user->lastName())
        ;
    }

    public function getRule(): string
    {
        return "is_active = 1 && first_name IS NOT NULL AND first_name <> '' && last_name IS NOT NULL && last_name <> ''";
    }

    /**
     * @return mixed[]
     */
    public function getParameters(): array
    {
        return [];
    }
}
