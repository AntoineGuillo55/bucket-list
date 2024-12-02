<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Wish;
use App\Repository\CategoryRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $categories = ['Travel & Adventure', 'Sport', 'Entertainment', 'Human Relations', 'Others'];

        foreach($categories as $cat) {
            $category = new Category();
            $category->setName($cat);
            $manager->persist($category);
        }

        $manager->flush();
    }
}
