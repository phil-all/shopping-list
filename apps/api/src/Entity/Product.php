<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProductRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use App\Controller\CreateProductController;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['product_read', 'itemList_read']],
    denormalizationContext: ['groups' => ['product_write']],
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
    #[Groups(['product_read', 'itemList_read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['product_read', 'product_write', 'itemList_read'])]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'product', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: true)]
    private ?User $owner = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['product_read', 'product_write', 'itemList_read'])]
    private ?Department $department = null;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: ItemList::class, orphanRemoval: true)]
    private Collection $itemLists;

    public function __construct()
    {
        $this->itemLists = new ArrayCollection();
    }

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
