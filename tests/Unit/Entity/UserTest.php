<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Record;
use App\Entity\User;
use DateTime;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
class UserTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->user = new User();
    }

    public function testGetEmail(): void
    {
        $value = 'unit@test.com';
        $response = $this->user->setEmail($value);

        self::assertInstanceOf(User::class, $response);
        self::assertEquals($value, $this->user->getEmail());
        self::assertEquals($value, $this->user->getUsername());
    }

    public function testGetRole(): void
    {
        $value = ['ROLE_ADMIN'];
        $response = $this->user->setRoles($value);

        self::assertInstanceOf(User::class, $response);
        self::assertContains('ROLE_USER', $this->user->getRoles());
        self::assertContains('ROLE_ADMIN', $this->user->getRoles());
    }

    public function testGetPassword(): void
    {
        $value = 'password';
        $response = $this->user->setPassword($value);

        self::assertInstanceOf(User::class, $response);
        self::assertEquals($value, $this->user->getPassword());
    }

    public function testGetRecord(): void
    {
        $record = new Record();
        $record->setUser($this->user);
        $response = $this->user->setRecord($record);

        self::assertInstanceOf(User::class, $response);
        self::assertInstanceOf(Record::class, $this->user->getRecord());
        self::assertEquals($record, $this->user->getRecord());
        self::assertEquals($this->user, $this->user->getRecord()->getUser());
    }

    public function testGetUpdatedAt(): void
    {
        $updatedAt = new DateTime();
        $response = $this->user->setUpdatedAt($updatedAt);

        self::assertInstanceOf(User::class, $response);
        self::assertEquals($updatedAt, $this->user->getUpdatedAt());
    }
}
