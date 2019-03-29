<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Category;
use App\Manager\CategoryManager;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

final class CategoryController
{
    private $manager;

    public function __construct(CategoryManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Rest\Get("/categories")
     */
    public function getCategories(): View
    {
        $categories = $this->manager->getList();

        return View::create($categories, Response::HTTP_OK);
    }

    /**
     * @Rest\Get("/categories/{id}")
     */
    public function getCategory(Category $category): View
    {
        $categoryDto = $this->manager->get($category);

        return View::create($categoryDto, Response::HTTP_OK);
    }
}
