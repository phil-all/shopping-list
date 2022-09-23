<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\DepartmentRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: DepartmentRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['department_read']],
    denormalizationContext: ['groups' => ['department_write']],
    collectionOperations: ['get'],
    itemOperations: ['get'],
)]
class Department
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["department_read", 'itemList_read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["department_read", 'itemList_read'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(["department_read", 'itemList_read'])]
    private ?string $color = null;

    #[ORM\Column(length: 255)]
    #[Groups(["department_read", 'itemList_read'])]
    private ?string $icon = null;

    #[ORM\ManyToOne(inversedBy: 'departments')]
    private ?User $owner = null;

    #[ORM\OneToMany(mappedBy: 'department', targetEntity: Product::class, orphanRemoval: true)]
    #[Groups(["department_read"])]
    private Collection $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
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

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(string $icon): self
    {
        $this->icon = $icon;

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

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->setDepartment($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getDepartment() === $this) {
                $product->setDepartment(null);
            }
        }

        return $this;
    }
}
