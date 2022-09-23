<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ItemListRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\CreateItemListController;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ItemListRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['itemList_read']],
    denormalizationContext: ['groups' => ['itemList_write']],
    collectionOperations: [
        'get',
        'post' => [
            'method'     => 'POST',
            'path'       => '/item_lists',
            'controller' => CreateItemListController::class,
        ],
    ],
    itemOperations: ['get', 'delete', 'put'],
)]
class ItemList
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['itemList_read'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['itemList_read', 'itemList_write'])]
    private ?int $quantity = null;

    #[ORM\ManyToOne(inversedBy: 'itemLists')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['itemList_write'])]
    private ?ShoppingList $shoppingList = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['itemList_read', 'itemList_write'])]
    private ?Product $product = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $owner = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getShoppingList(): ?ShoppingList
    {
        return $this->shoppingList;
    }

    public function setShoppingList(?ShoppingList $shoppingList): self
    {
        $this->shoppingList = $shoppingList;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

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
