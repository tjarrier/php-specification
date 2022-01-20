<?php

namespace Tja\PhpSpecification\Application\Example;

use PHPUnit\Framework\TestCase;
use Tja\PhpSpecification\Domain\Example\User;

class UserIsAdultTest extends TestCase
{
    /** @dataProvider getAdultUsers */
    public function testUserIsAdultWithAdultUser(User $user): void
    {
        $userIdAdult = new UserIsAdult($user);
        $this->assertTrue($userIdAdult->isSatisfiedBy());
        $this->assertEquals(
            ":age >= 18",
            $userIdAdult->getRule()
        );
        $this->assertArrayHasKey('age', $userIdAdult->getParameters());
        $this->assertEquals($user->age(), $userIdAdult->getParameters()['age']);
    }

    /** @dataProvider getYoungUsers */
    public function testUserIsAdultWithYoungUser(User $user): void
    {
        $userIdAdult = new UserIsAdult($user);
        $this->assertFalse($userIdAdult->isSatisfiedBy());
        $this->assertEquals(
            ":age >= 18",
            $userIdAdult->getRule()
        );
        $this->assertArrayHasKey('age', $userIdAdult->getParameters());
        $this->assertEquals($user->age(), $userIdAdult->getParameters()['age']);
    }

    public function getAdultUsers(): \Iterator
    {
        yield 'adult and active user' => [User::create('Thomas', 'JARRIER', true, 23)];
        yield 'adult and inactive user' => [User::create('Thomas', 'JARRIER', false, 24)];
    }

    public function getYoungUsers(): \Iterator
    {
        yield 'young and active user' => [User::create('Thomas', 'JARRIER', true, 17)];
        yield 'young and inactive user' => [User::create('Thomas', 'JARRIER', false, 15)];
    }
}
