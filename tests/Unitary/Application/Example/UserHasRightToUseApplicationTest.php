<?php

namespace Tja\PhpSpecification\Application\Example;

use PHPUnit\Framework\TestCase;
use Tja\PhpSpecification\Domain\Example\User;

class UserHasRightToUseApplicationTest extends TestCase
{
    /** @dataProvider getUsersWithRight */
    public function testUserHasRightToUseApplication(User $user): void
    {
        $userHasRightToUseApplication = new UserHasRightToUseApplication($user);
        $this->assertInstanceOf(UserHasRightToUseApplication::class, $userHasRightToUseApplication);
        $this->assertTrue($userHasRightToUseApplication->isSatisfiedBy());
        $this->assertEquals(
            "(is_active = 1 AND first_name IS NOT NULL AND first_name <> '' AND last_name IS NOT NULL AND last_name <> '') AND (:age >= 18)",
            $userHasRightToUseApplication->getRule()
        );
        $this->assertArrayHasKey('age', $userHasRightToUseApplication->getParameters());
    }

    /** @dataProvider getUsersWithoutRight */
    public function testUserHasNotRightToUseApplication(User $user): void
    {
        $userHasRightToUseApplication = new UserHasRightToUseApplication($user);
        $this->assertInstanceOf(UserHasRightToUseApplication::class, $userHasRightToUseApplication);
        $this->assertFalse($userHasRightToUseApplication->isSatisfiedBy());
        $this->assertEquals(
            "(is_active = 1 AND first_name IS NOT NULL AND first_name <> '' AND last_name IS NOT NULL AND last_name <> '') AND (:age >= 18)",
            $userHasRightToUseApplication->getRule()
        );
        $this->assertArrayHasKey('age', $userHasRightToUseApplication->getParameters());
    }

    public function getUsersWithRight(): \Iterator
    {
        yield 'adult and active user 1' => [User::create('Thomas', 'JARRIER', true, 23)];
        yield 'adult and active user 2' => [User::create('Thomas', 'JARRIER', true, 34)];
    }

    public function getUsersWithoutRight(): \Iterator
    {
        yield 'adult and inactive user' => [User::create('Thomas', 'JARRIER', false, 23)];
        yield 'young and active user' => [User::create('Thomas', 'JARRIER', true, 17)];
        yield 'young and inactive user' => [User::create('Thomas', 'JARRIER', false, 16)];
    }
}
