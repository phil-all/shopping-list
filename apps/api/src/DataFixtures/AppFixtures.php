<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Product;
use App\Entity\Department;
use App\Entity\ShoppingList;
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

        $departments = [
            0 => ['inconnu',                    'question',             '#eceff4'],
            1 => ['fruits et légumes',          'carrot',               '#ffa94d'],
            2 => ['produits frais, snack',      'pizza-slice',          '#e64980'],
            3 => ['fromages, crèmerie',         'cheese',               '#fff68f'],
            4 => ['viandes',                    'drumstick-bite',       '#8b2323'],
            5 => ['poissons',                   'fish',                 '#98f5ff'],
            6 => ['surgelé',                    'snowflake',            '#228be6'],
            7 => ['eau, jus, sodas',            'glass-water-droplet',  '#d0ebff'],
            8 => ['conserverie',                'database',             '#b5b69c'],
            9 => ['alcools',                    'beer-mug-empty',       '#7b68ee'],
            10 => ['petit déjeuner',            'mug-hot',              '#b8860b'],
            11 => ['gouter, chocolat, bonbons', 'cookie-bite',          '#ff6eb4'],
            12 => ['riz, pates, cereales',      'bowl-rice',            '#fff85b'],
            13 => ['sauces, épices, huiles',    'bottle-droplet',       '#fa5252'],
            14 => ['oeufs, farine',             'egg',                  '#51cf66'],
            15 => ['boulangerie',               'bread-slice',          '#935529'],
            16 => ['hygiène',                   'toilet-paper',         '#81a1c1'],
            17 => ['bébé',                      'baby-carriage',        '#008b8b'],
            18 => ['pharmacie',                 'briefcase-medical',    '#ff2500'],
            19 => ['animaux',                   'bone',                 '#81a1c1'],
            20 => ['bricolage, auto',           'wrench',               '#8a2be2']
        ];

        $products = [
            0 => 'un produit dont j\'ignore le rayon',
            1 => 'salade',
            2 => 'pate a tarte',
            3 => 'beurre',
            4 => 'cuisses de poulet',
            5 => 'cabillaud',
            6 => 'frites',
            7 => 'jus de pomme',
            8 => 'thon',
            9 => 'vin rouge',
            10 => 'café',
            11 => 'compotes à boire',
            12 => 'spaguetis',
            13 => 'sel',
            14 => 'oeufs x6',
            15 => 'pain de seigle',
            16 => 'papier toilette',
            17 => 'couches',
            18 => 'pancements',
            19 => 'croquettes chats',
            20 => 'piles 9V'
        ];

        for ($i = 0; $i < 2; $i++) {
            $user = new User();
            $user
                ->setEmail($users[$i] . '@example.com')
                ->setRoles(['ROLE_USER'])
                ->setPassword($this->hasher->hashPassword($user, 'pass1234'));
            $manager->persist($user);

            switch ($i) {
                case 0:
                    $listTitle = [
                        0 => 'barbecue dimanche',
                        1 => 'carrouf'
                    ];
                    for ($k = 0; $k < 2; $k++) {
                        $shoppingList = new ShoppingList();
                        $shoppingList
                            ->setOwner($user)
                            ->setName($listTitle[$k]);
                        $manager->persist($shoppingList);
                        $this->addReference('shoppingList_' . $k, $shoppingList);
                    }
                    break;
                case 1:
                    $shoppingList = new ShoppingList();
                    $shoppingList
                        ->setOwner($user)
                        ->setName('dépannage supérette');
                    $manager->persist($shoppingList);
                    $this->addReference('shoppingList_2', $shoppingList);
                    break;
            }

            for ($j = 0; $j < count($departments); $j++) {
                $department = new Department();

                $department
                    ->setName($departments[$j][0])
                    ->setIcon($departments[$j][1])
                    ->setColor($departments[$j][2])
                    ->setOwner($user);
                $manager->persist($department);

                $product = new Product();
                $product
                    ->setName($products[$j])
                    ->setDepartment($department)
                    ->setOwner($user);
                $manager->persist($product);
                $this->addReference('user' . $i . '_product' . $j, $product);
            }
        }
        $manager->flush();
    }
}
