<?php

namespace App\Tests\Unit;

use App\Entity\User;
use App\Entity\Product;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = new User();
    }

    public function testGetEmail(): void
    {
        $value    = 'test@example.coml';
        $response = $this->user->setEmail($value);

        $this->assertInstanceOf(User::class, $response);
        $this->assertEquals($value, $this->user->getEmail());
        $this->assertEquals($value, $this->user->getUserIdentifier());
    }

    public function testGetRoles(): void
    {
        $value    = ['ROLE_ADMIN'];
        $response = $this->user->setRoles($value);

        $this->assertInstanceOf(User::class, $response);
        $this->assertContains('ROLE_USER', $this->user->getRoles());
        $this->assertContains('ROLE_ADMIN', $this->user->getRoles());
    }

    public function testGetPassword(): void
    {
        $value    = 'testPassword';
        $response = $this->user->setPassword($value);

        $this->assertInstanceOf(User::class, $response);
        $this->assertEquals($value, $this->user->getPassword());
    }

    public function testGetProducts(): void
    {
        $value    = new Product();
        $response = $this->user->addProduct($value);

        $this->assertInstanceOf(User::class, $response);
        $this->assertCount(1, $this->user->getProducts());
        $this->assertTrue($this->user->getProducts()->contains($value));

        $response = $this->user->removeProduct($value);

        $this->assertInstanceOf(User::class, $response);
        $this->assertCount(0, $this->user->getProducts());
        $this->assertFalse($this->user->getProducts()->contains($value));
    }
}
