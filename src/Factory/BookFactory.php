<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Book;

final class BookFactory
{
    public static function getNew(): Book
    {
        return new Book();
    }
}
