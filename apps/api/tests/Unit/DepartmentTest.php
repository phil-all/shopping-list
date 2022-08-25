<?php

namespace App\Tests\Unit;

use App\Entity\User;
use App\Entity\Department;
use PHPUnit\Framework\TestCase;

class DepartmentTest extends TestCase
{
    private Department $department;

    protected function setUp(): void
    {
        parent::setUp();

        $this->department = new Department();
    }

    public function testGetName(): void
    {
        $value = 'testDepartment';
        $response = $this->department->setName($value);

        $this->assertInstanceOf(Department::class, $response);
        $this->assertEquals($value, $this->department->getName());
    }

    public function testGetColor(): void
    {
        $value = 'testDepartment';
        $response = $this->department->setColor($value);

        $this->assertInstanceOf(Department::class, $response);
        $this->assertEquals($value, $this->department->getColor());
    }

    public function testGetIcon(): void
    {
        $value = 'testDepartment';
        $response = $this->department->setIcon($value);

        $this->assertInstanceOf(Department::class, $response);
        $this->assertEquals($value, $this->department->getIcon());
    }

    public function testGetOwner(): void
    {
        $value = new User();
        $response = $this->department->setOwner($value);

        $this->assertInstanceOf(Department::class, $response);
        $this->assertEquals($value, $this->department->getOwner());
    }
}
