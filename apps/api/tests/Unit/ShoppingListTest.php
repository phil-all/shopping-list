<?php

namespace App\Tests\Unit;

use App\Entity\User;
use App\Entity\ShoppingList;
use PHPUnit\Framework\TestCase;

class ShoppingListTest extends TestCase
{
    private ShoppingList $shoppingList;

    protected function setUp(): void
    {
        parent::setUp();

        $this->shoppingList = new ShoppingList();
    }

    public function testGetName(): void
    {
        $value = 'testShoppingList';
        $response = $this->shoppingList->setName($value);

        $this->assertInstanceOf(ShoppingList::class, $response);
        $this->assertEquals($value, $this->shoppingList->getName());
    }

    public function testGetOwner(): void
    {
        $value = new User();
        $response = $this->shoppingList->setOwner($value);

        $this->assertInstanceOf(ShoppingList::class, $response);
        $this->assertEquals($value, $this->shoppingList->getOwner());
    }
}
