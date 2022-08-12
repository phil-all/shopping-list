<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Product;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $users = [
            0 => 'user1',
            1 => 'user2',
        ];

        $products = [
            0 => 'carottes',
            1 => 'limonade',
            2 => 'fromage de chèvre',
            3 => 'camembert',
            4 => 'jambon',
            5 => 'papier toilette'
        ];

        for ($i = 0; $i < 2; $i++) {
            $user = new User();

            $user
                ->setEmail($users[$i] . '@example.com')
                ->setRoles(['ROLE_USER'])
                ->setPassword($this->hasher->hashPassword($user, 'pass1234'));

            $manager->persist($user);

            for ($j = 0; $j < rand(3, 6); $j++) {
                $product = new Product();
                $product
                    ->setName($products[$j])
                    ->setOwner($user);

                $manager->persist($product);
            }
        }

        $manager->flush();
    }
}
