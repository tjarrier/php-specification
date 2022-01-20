<?php

namespace Tja\PhpSpecification\Domain;

use PHPUnit\Framework\TestCase;
use Tja\PhpSpecification\Application\Example\UserIsActive;
use Tja\PhpSpecification\Application\Example\UserIsAdult;
use Tja\PhpSpecification\Domain\Example\User;

class OrXTest extends TestCase
{
    /** @dataProvider getUsers */
    public function testOrXSpecification(User $user): void
    {
        $orXSpecification = new OrX([
            new UserIsActive($user),
            new UserIsAdult($user)
        ]);
        $this->assertInstanceOf(OrX::class, $orXSpecification);
        $this->assertEquals(
            "(is_active = 1 && first_name IS NOT NULL AND first_name <> '' && last_name IS NOT NULL && last_name <> '') OR (:age >= 18)",
            $orXSpecification->getRule()
        );
        $this->assertArrayHasKey('age', $orXSpecification->getParameters());
    }

    public function getUsers(): \Iterator
    {
        yield 'adult and active user' => [User::create('Thomas', 'JARRIER', true, 23)];
        yield 'young and active user' => [User::create('Thomas', 'JARRIER', true, 17)];
    }
}
