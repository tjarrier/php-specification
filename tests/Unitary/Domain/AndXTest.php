<?php

namespace Tja\PhpSpecification\Domain;

use PHPUnit\Framework\TestCase;
use Tja\PhpSpecification\Application\Example\UserIsActive;
use Tja\PhpSpecification\Application\Example\UserIsAdult;
use Tja\PhpSpecification\Domain\Example\User;

class AndXTest extends TestCase
{
    /** @dataProvider getUsers */
    public function testAndXSpecification(User $user): void
    {
        $andXSpecification = new AndX([
            new UserIsActive($user),
            new UserIsAdult($user)
        ]);
        $this->assertInstanceOf(AndX::class, $andXSpecification);
        $this->assertEquals(
            "(is_active = 1 && first_name IS NOT NULL AND first_name <> '' && last_name IS NOT NULL && last_name <> '') AND (:age >= 18)",
            $andXSpecification->getRule()
        );
        $this->assertArrayHasKey('age', $andXSpecification->getParameters());
    }

    public function getUsers(): \Iterator
    {
        yield 'adult and active user' => [User::create('Thomas', 'JARRIER', true, 23)];
        yield 'young and active user' => [User::create('Thomas', 'JARRIER', true, 17)];
    }
}
