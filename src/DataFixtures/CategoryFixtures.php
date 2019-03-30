<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

final class CategoryFixtures extends Fixture
{
    public const NB_CATEGORIES = 5;

    public function load(ObjectManager $manager): void
    {
        for ($categoryNb = 1;$categoryNb <= 5 ; ++$categoryNb) {
            $category = (new Category())
                ->setLabel("Categorie {$categoryNb}")
            ;

            $manager->persist($category);
            $this->setReference("category_{$categoryNb}", $category);
        }

        $manager->flush();
    }
}
