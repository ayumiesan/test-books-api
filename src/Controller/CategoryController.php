<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\CategoryDto;
use App\Entity\Category;
use App\Manager\CategoryManager;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationList;

final class CategoryController extends AbstractFOSRestController
{
    private $manager;

    public function __construct(CategoryManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Rest\Post("/categories")
     * @ParamConverter("categoryDto", converter="fos_rest.request_body")
     * @Rest\View(statusCode=201)
     *
     * @return CategoryDto|View
     */
    public function postCategory(CategoryDto $categoryDto, ConstraintViolationList $violationList)
    {
        if (count($violationList)) {
            return $this->view($violationList, Response::HTTP_BAD_REQUEST);
        }

        return $this->manager->save($categoryDto);
    }
    
    /**
     * @Rest\Get("/categories")
     * @Rest\View(statusCode=200)
     *
     * @return CategoryDto[]
     */
    public function getCategories()
    {
        return $this->manager->getList();
    }

    /**
     * @Rest\Get("/categories/{id}")
     * @Rest\View(statusCode=200)
     */
    public function getCategory(Category $category): CategoryDto
    {
        return $this->manager->get($category);
    }

    /**
     * @Rest\Put("/categories/{id}")
     * @ParamConverter("categoryDto", converter="fos_rest.request_body")
     * @Rest\View(statusCode=200)
     *
     * @return CategoryDto|View
     */
    public function putCategory(CategoryDto $categoryDto, Category $category, ConstraintViolationList $violationList)
    {
        if (count($violationList)) {
            return $this->view($violationList, Response::HTTP_BAD_REQUEST);
        }

        return $this->manager->save($categoryDto, $category);
    }

    /**
     * @Rest\Delete("/categories/{id}")
     * @Rest\View(statusCode=204)
     */
    public function deleteCategory(int $id): void
    {
        $this->manager->remove($id);
    }
}
