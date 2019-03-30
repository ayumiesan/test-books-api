<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\BookDto;
use App\Entity\Book;
use App\Manager\BookManager;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationList;

final class BookController extends AbstractFOSRestController
{
    private $manager;

    public function __construct(BookManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Rest\Post("/books")
     * @ParamConverter("bookDto", converter="fos_rest.request_body")
     * @Rest\View(statusCode=201)
     *
     * @return BookDto|View
     */
    public function postBook(BookDto $bookDto, ConstraintViolationList $violationList)
    {
        if (count($violationList)) {
            return $this->view($violationList, Response::HTTP_BAD_REQUEST);
        }

        return $this->manager->save($bookDto);
    }

    /**
     * @Rest\Get("/books")
     * @Rest\View(statusCode=200)
     *
     * @return BookDto[]
     */
    public function getBooks()
    {
        return $this->manager->getList();
    }

    /**
     * @Rest\Get("/books/{id}")
     * @Rest\View(statusCode=200)
     */
    public function getBook(Book $book): BookDto
    {
        return $this->manager->get($book);
    }

    /**
     * @Rest\Put("/books/{id}")
     * @ParamConverter("bookDTO", converter="fos_rest.request_body")
     * @Rest\View(statusCode=200)
     *
     * @return BookDto|View
     */
    public function putBook(BookDto $bookDto, Book $book, ConstraintViolationList $violationList)
    {
        if (count($violationList)) {
            return $this->view($violationList, Response::HTTP_BAD_REQUEST);
        }

        return $this->manager->save($bookDto, $book);
    }

    /**
     * @Rest\Delete("/books/{id}")
     * @Rest\View(statusCode=204)
     */
    public function deleteBook(int $id): void
    {
        $this->manager->remove($id);
    }
}
