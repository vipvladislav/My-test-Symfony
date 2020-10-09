<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use App\Factory\ArticleFactory;
use App\Factory\CategoryFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        CategoryFactory::new()->createMany(10);
        ArticleFactory::new()->createMany(20, function () {
            return[
                'categories' => CategoryFactory::random(),
            ];
        });

        $manager->flush();
    }
}
