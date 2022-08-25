<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProductRepository;
use App\Controller\CreateProductController;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['product_read']],
    denormalizationContext: ['groups' => ['write']],
    collectionOperations: [
        'get',
        'post' => [
            'method'     => 'POST',
            'path'       => '/products',
            'controller' => CreateProductController::class,
        ],
    ],
    itemOperations: ['get', 'put', 'delete'],
)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["product_read"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["product_read", "write"])]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'product', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: true)]
    private ?User $owner = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["product_read", "write"])]
    private ?Department $department = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getDepartment(): ?Department
    {
        return $this->department;
    }

    public function setDepartment(?Department $department): self
    {
        $this->department = $department;

        return $this;
    }
}
