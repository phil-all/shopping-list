<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsController]
class CreateProductController extends AbstractController
{
    protected Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function __invoke(Product $data): Product
    {
        /** @phpstan-ignore-next-line */
        $data->setOwner($this->security->getUser());
        return $data;
    }
}
