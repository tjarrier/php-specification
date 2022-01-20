<?php

namespace Tja\PhpSpecification\Application\Example;

use PHPUnit\Framework\TestCase;
use Tja\PhpSpecification\Domain\Example\User;

class UserIsActiveTest extends TestCase
{
    /** @dataProvider getActiveUsers */
    public function testUserIsActiveWithActiveUser(User $user): void
    {
        $userIsActive = new UserIsActive($user);
        $this->assertTrue($userIsActive->isSatisfiedBy());
        $this->assertEquals(
            "is_active = 1 && first_name IS NOT NULL AND first_name <> '' && last_name IS NOT NULL && last_name <> ''",
            $userIsActive->getRule()
        );
    }

    /** @dataProvider getInactiveUsers */
    public function testUserIsActiveWithInactiveUser(User $user): void
    {
        $userIsActive = new UserIsActive($user);
        $this->assertFalse($userIsActive->isSatisfiedBy());
        $this->assertEquals(
            "is_active = 1 && first_name IS NOT NULL AND first_name <> '' && last_name IS NOT NULL && last_name <> ''",
            $userIsActive->getRule()
        );
    }

    public function getActiveUsers(): \Iterator
    {
        yield 'adult and active user' => [User::create('Thomas', 'JARRIER', true, 23)];
        yield 'young and active user' => [User::create('Thomas', 'JARRIER', true, 17)];
    }

    public function getInactiveUsers(): \Iterator
    {
        yield 'adult and inactive user' => [User::create('Thomas', 'JARRIER', false, 23)];
        yield 'young and inactive user' => [User::create('Thomas', 'JARRIER', false, 17)];
    }
}
