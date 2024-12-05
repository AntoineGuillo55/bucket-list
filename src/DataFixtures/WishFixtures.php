<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\User;
use App\Entity\Wish;
use App\Repository\CategoryRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class WishFixtures extends Fixture implements DependentFixtureInterface
{

    public function __construct(private UserPasswordHasherInterface $hasher) {}

    public function addUsers(ObjectManager $manager) {

        $faker = Factory::create('fr_FR');

        for ($i=0 ; $i < 10 ; $i++) {
            $user = new User();
            $user->setRoles(['USER_ROLE']);
            $user->setEmail($faker->email());
            $user->setPseudo($faker->userName());
            $user->setPassword($this->hasher->hashPassword($user, '1234'));

            $manager->persist($user);
        }

        $manager->flush();
    }
    public function load(ObjectManager $manager): void
    {

        $this->addUsers($manager);

        $users = $manager->getRepository(User::class)->findAll();
        $faker = Factory::create('fr-FR');

        $categories = $manager->getRepository(Category::class)->findAll();

        for ($i = 0; $i<30; $i++) {
            $wish = new Wish();
            $wish->setTitle($faker->word())
                ->setDescription($faker->text())
                ->setUser($faker->randomElement($users))
                ->setCategory($faker->randomElement($categories));
            $manager->persist($wish);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class
        ];
    }
}
