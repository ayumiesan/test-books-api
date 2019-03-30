<?php

declare(strict_types=1);

namespace App\Assembler;

use App\Dto\CategoryDto;
use App\Entity\Category;
use App\Factory\CategoryFactory;
use App\Repository\CategoryRepository;

final class CategoryAssembler
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function read(CategoryDto $categoryDto): Category
    {
        $category = $categoryDto->id ? $this->categoryRepository->find($categoryDto->id) : CategoryFactory::getNew();
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
        $categoryDto->id = $category->getId();
        $categoryDto->label = $category->getLabel();

        return $categoryDto;
    }

    /**
     * @param Category[]
     * @return CategoryDto[]
     */
    public function writeMultiple(array $categories): array
    {
        return array_map(function (Category $category) {
            return $this->write($category);
        }, $categories);
    }
}
