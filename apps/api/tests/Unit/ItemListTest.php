<?php

namespace App\Tests\Unit;

use App\Entity\User;
use App\Entity\Product;
use App\Entity\ItemList;
use App\Entity\ShoppingList;
use PHPUnit\Framework\TestCase;

class ItemListTest extends TestCase
{
    private ItemList $itemList;

    protected function setUp(): void
    {
        parent::setUp();

        $this->itemList = new ItemList();
    }

    public function testGetQuantity(): void
    {
        $value = 3;
        $response = $this->itemList->setQuantity(3);

        $this->assertInstanceOf(ItemList::class, $response);
        $this->assertEquals($value, $this->itemList->getQuantity());
    }

    public function testGetProduct(): void
    {
        $value = new Product();
        $response = $this->itemList->setProduct($value);

        $this->assertInstanceOf(ItemList::class, $response);
        $this->assertEquals($value, $this->itemList->getProduct());
    }

    public function testGetShoppingList(): void
    {
        $value = new ShoppingList();
        $response = $this->itemList->setShoppingList($value);

        $this->assertInstanceOf(ItemList::class, $response);
        $this->assertEquals($value, $this->itemList->getShoppingList());
    }

    public function testGetOwner(): void
    {
        $value = new User();
        $response = $this->itemList->setOwner($value);

        $this->assertInstanceOf(ItemList::class, $response);
        $this->assertEquals($value, $this->itemList->getOwner());
    }
}
