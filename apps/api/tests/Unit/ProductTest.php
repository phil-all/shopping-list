<?php

namespace App\Tests\Unit;

use App\Entity\User;
use App\Entity\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    private Product $product;

    protected function setUp(): void
    {
        parent::setUp();

        $this->product = new Product();
    }

    public function testGetName(): void
    {
        $value = 'testProduct';
        $response = $this->product->setName($value);

        $this->assertInstanceOf(Product::class, $response);
        $this->assertEquals($value, $this->product->getName());
    }

    public function testGetOwner(): void
    {
        $value = new User();
        $response = $this->product->setOwner($value);

        $this->assertInstanceOf(Product::class, $response);
        $this->assertEquals($value, $this->product->getOwner());
    }
}
