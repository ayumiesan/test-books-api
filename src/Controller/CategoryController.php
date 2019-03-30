<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\CategoryDto;
use App\Entity\Category;
use App\Manager\CategoryManager;
use FOS\RestBundle\Controller\Annotations as Rest;

final class CategoryController
{
    private $manager;

    public function __construct(CategoryManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Rest\Get("/categories")
     * @Rest\View()
     *
     * @return CategoryDto[]
     */
    public function getCategories(): array
    {
        return $this->manager->getList();
    }

    /**
     * @Rest\Get("/categories/{id}")
     * @Rest\View()
     *
     * @param Category $category
     * @return CategoryDto
     */
    public function getCategory(Category $category): CategoryDto
    {
        return $this->manager->get($category);
    }
}
