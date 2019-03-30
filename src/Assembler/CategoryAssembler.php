<?php

declare(strict_types=1);

namespace App\Assembler;

use App\Dto\CategoryDto;
use App\Entity\Category;
use App\Factory\CategoryFactory;
use Doctrine\ORM\PersistentCollection;

final class CategoryAssembler
{
    public function read(CategoryDto $categoryDto, ?Category $category = null): Category
    {
        if (!$category) {
            $category = CategoryFactory::getNew();
        }

        $category->setLabel($categoryDto->label);

        return $category;
    }

    public function readMultiple(array $categories): array
    {
        return array_map(function (CategoryDto $categoryDto) {
            return $this->read($categoryDto);
        }, $categories);
    }

    public function write(Category $category): CategoryDto
    {
        $categoryDto = new CategoryDto();
        $categoryDto->label = $category->getLabel();

        return $categoryDto;
    }

    public function writeMultiple(array $categories): array
    {
        return array_map(function (Category $category) {
            return $this->write($category);
        }, $categories);
    }
}
