<?php

namespace App\Controller;

use App\Entity\ShoppingList;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsController]
class CreateShoppingListController extends AbstractController
{
    protected Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function __invoke(ShoppingList $data): ShoppingList
    {
        /** @phpstan-ignore-next-line */
        $data->setOwner($this->security->getUser());
        return $data;
    }
}
