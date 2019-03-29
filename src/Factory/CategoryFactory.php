<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Category;

final class CategoryFactory
{
    public static function getNew(): Category
    {
        return new Category();
    }
}
