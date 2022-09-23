<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ShoppingListRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Controller\CreateShoppingListController;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ShoppingListRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['shopping_list_read']],
    denormalizationContext: ['groups' => ['shopping_list_write']],
    collectionOperations: [
        'get',
        'post' => [
            'method'     => 'POST',
            'path'       => '/shopping_lists',
            'controller' => CreateShoppingListController::class,
        ],
    ],
    itemOperations: ['get', 'delete', 'put'],
)]
class ShoppingList
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["shopping_list_read"])]
    private ?int $id = null;

    #[ORM\Column(length: 120)]
    #[Groups(["shopping_list_read", "shopping_list_write"])]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'shoppingList', targetEntity: ItemList::class, orphanRemoval: true)]
    #[ApiSubresource]
    private Collection $itemLists;

    #[ORM\ManyToOne(inversedBy: 'shoppingLists', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $owner = null;

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

    /**
     * @return Collection<int, ItemList>
     */
    public function getItemLists(): Collection
    {
        return $this->itemLists;
    }

    public function addItemList(ItemList $itemList): self
    {
        if (!$this->itemLists->contains($itemList)) {
            $this->itemLists->add($itemList);
            $itemList->setShoppingList($this);
        }

        return $this;
    }

    public function removeItemList(ItemList $itemList): self
    {
        if ($this->itemLists->removeElement($itemList)) {
            // set the owning side to null (unless already changed)
            if ($itemList->getShoppingList() === $this) {
                $itemList->setShoppingList(null);
            }
        }

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
}
