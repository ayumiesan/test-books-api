<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker\Factory as Faker;

final class UserFixtures extends Fixture implements DependentFixtureInterface
{
    private $passwordEncoder;
    private $faker;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->faker = Faker::create();
    }

    public function load(ObjectManager $manager): void
    {
        $this->setAdminUser($manager);
        $this->setOtherUsers($manager);

        $manager->flush();
    }

    private function setAdminUser(ObjectManager $manager): void
    {
        $user = (new User())
            ->setEmail('admin@admin.fr')
            ->setFullName('Administrator')
            ->setIsAdmin(true)
        ;

        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'admin'
        ));

        $manager->persist($user);
    }

    private function setOtherUsers(ObjectManager $manager): void
    {
        $bookList = $this->getBooks();

        for ($userNb = 1;$userNb <= 10; ++$userNb) {
            $books = $this->faker->randomElements($bookList, $this->faker->numberBetween(1, BookFixtures::NB_BOOKS));

            $user = (new User())
                ->setEmail("user_{$userNb}@user.fr")
                ->setFullName("user_{$userNb}")
                ->setBooks($books)
            ;

            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'user'
            ));

            $manager->persist($user);
        }
    }

    private function getBooks(): array
    {
        $books = [];

        for ($bookNb = 1; $bookNb <= BookFixtures::NB_BOOKS; ++$bookNb) {
            $books[] = $this->getReference("book_{$bookNb}");
        }

        return $books;
    }

    public function getDependencies(): array
    {
        return [
            BookFixtures::class,
        ];
    }
}
