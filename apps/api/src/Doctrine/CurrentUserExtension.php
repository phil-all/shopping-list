<?php

namespace App\Doctrine;

use App\Entity\User;
use App\Entity\Product;
use App\Entity\ItemList;
use App\Entity\Department;
use App\Entity\ShoppingList;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\Security;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;

/**
 * CurrentUserExtension class, used to filter owned user datas on ressources
 */
final class CurrentUserExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function applyToCollection(
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass,
        string $operationName = null
    ): void {
        $this->addWhere($queryBuilder, $resourceClass);
    }

    public function applyToItem(
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass,
        array $identifiers,
        string $operationName = null,
        array $context = []
    ): void {
        $this->addWhere($queryBuilder, $resourceClass);
    }

    private function addWhere(QueryBuilder $queryBuilder, string $resourceClass): void
    {
        $tempUser = $this->security->getUser();

        $protectedRessources = [
            Product::class,
            ItemList::class,
            Department::class,
            ShoppingList::class,
        ];

        if (!in_array($resourceClass, $protectedRessources) || null === $tempUser) {
            return;
        }

        /** @var User $user */
        $user = $tempUser;

        $rootAlias = $queryBuilder->getRootAliases()[0];
        $queryBuilder->andWhere("$rootAlias.owner = :current_user");
        $queryBuilder->setParameter('current_user', $user->getId());
    }
}
