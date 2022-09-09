<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\ItemList;
use App\Entity\ShoppingList;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ItemListFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($j = 0; $j < 21; $j++) {
            $itemList = new ItemList();

            /** @var ShoppingList $shoppingList */
            $shoppingList = $this->getReference('shoppingList_' . rand(0, 2));

            /** @var User $user */
            $user = $shoppingList->getOwner();

            $referenceId   = strval($user->getId() - 1);
            $userReference = 'user' . $referenceId;

            $itemList
                ->setShoppingList($shoppingList)
                ->setProduct($this->getReference($userReference . '_product' . $j))
                ->setQuantity(rand(1, 5))
                ->setOwner($user);

            $manager->persist($itemList);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            AppFixtures::class
        ];
    }
}
