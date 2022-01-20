<?php

namespace Tja\PhpSpecification\Domain\Example;

use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    /** @dataProvider getUserData */
    public function testCreateUser(
        string $firstName,
        string $lastName,
        bool $isActive,
        int $age
    ): void {
        $user = User::create($firstName, $lastName, $isActive, $age);
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($firstName, $user->firstName());
        $this->assertEquals($lastName, $user->lastName());
        $this->assertEquals($isActive, $user->isActive());
        $this->assertEquals($age, $user->age());
    }

    public function getUserData(): \Iterator
    {
        yield 'adult user and active' => [
            'Thomas',
            'JARRIER',
            true,
            23
        ];

        yield 'adult user and inactive' => [
            'Thomas',
            'JARRIER',
            false,
            24
        ];

        yield 'young user and active' => [
            'Thomas',
            'JARRIER',
            true,
            16
        ];
    }
}
