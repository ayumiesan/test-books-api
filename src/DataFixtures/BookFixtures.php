<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory as Faker;

final class BookFixtures extends Fixture implements DependentFixtureInterface
{
    private $faker;

    public function __construct()
    {
        $this->faker = Faker::create();
    }

    public function load(ObjectManager $manager): void
    {
        $categoryList = $this->getCategories();

        for ($bookNb = 0;$bookNb < 10; ++$bookNb) {
            $categories = $this->faker->randomElements($categoryList, $this->faker->numberBetween(1, CategoryFixtures::NB_CATEGORIES));

            $book = new Book();
            $book->updateBook($this->faker->word, $this->faker->sentence, $this->faker->numberBetween(0, 10), $categories);
            $manager->persist($book);
        }

        $manager->flush();
    }

    private function getCategories(): array
    {
        $categories = [];

        for ($categoryNb = 1; $categoryNb <= CategoryFixtures::NB_CATEGORIES; ++$categoryNb) {
            $categories[] = $this->getReference("category_{$categoryNb}");
        }

        return $categories;
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
        ];
    }
}
