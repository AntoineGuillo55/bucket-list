<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Wish;
use App\Repository\CategoryRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class WishFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr-FR');

        $categories = $manager->getRepository(Category::class)->findAll();

        for ($i = 0; $i<30; $i++) {
            $wish = new Wish();
            $wish->setTitle($faker->word())
                ->setDescription($faker->text())
                ->setAuthor($faker->word())
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
