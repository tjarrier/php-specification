<?php

declare(strict_types=1);

namespace Tja\PhpSpecification\Application\Example;

use Tja\PhpSpecification\Domain\ComposedSpecification;
use Tja\PhpSpecification\Domain\Example\User;
use Tja\PhpSpecification\Domain\SpecificationInterface;

final class UserHasRightToUseApplication extends ComposedSpecification
{
    public function __construct(
        private User $user
    ) {
    }

    protected function getSpecification(): SpecificationInterface
    {
        return (new UserIsActive($this->user))->andX([new UserIsAdult($this->user)]);
    }
}
