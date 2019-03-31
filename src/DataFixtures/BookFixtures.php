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
    public const NB_BOOKS = 10;
    private $faker;

    public function __construct()
    {
        $this->faker = Faker::create();
    }

    public function load(ObjectManager $manager): void
    {
        $categoryList = $this->getCategories();

        for ($bookNb = 1;$bookNb <= 10; ++$bookNb) {
            $categories = $this->faker->randomElements($categoryList, $this->faker->numberBetween(1, CategoryFixtures::NB_CATEGORIES));

            $book = new Book();
            $book->updateBook("titre_{$bookNb}", $this->faker->sentence, $this->faker->numberBetween(0, 10), $categories);
            $manager->persist($book);
            $this->setReference("book_{$bookNb}", $book);
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
