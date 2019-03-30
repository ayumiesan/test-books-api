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
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\ConstraintViolationList;

final class BookController extends AbstractFOSRestController
{
    private $manager;

    public function __construct(BookManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Route("/books", name="book_post", methods={"POST"})
     * @ParamConverter("bookDto", converter="fos_rest.request_body")
     * @Rest\View(statusCode=201)
     *
     * @param BookDto $bookDto
     * @param ConstraintViolationList $violationList
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
     * @Route("/books", name="book_get_list", methods={"GET"})
     * @Rest\View(statusCode=200)
     *
     * @return BookDto[]
     */
    public function getBooks(): array
    {
        return $this->manager->getList();
    }

    /**
     * @Route("/books/{id}", name="book_get", methods={"GET"})
     * @Rest\View(statusCode=200)
     *
     * @param Book $book
     * @return BookDto
     */
    public function getBook(Book $book): BookDto
    {
        return $this->manager->get($book);
    }

    /**
     * @Route("/books/{id}", name="book_put", methods={"PUT"})
     * @ParamConverter("bookDTO", converter="fos_rest.request_body")
     * @Rest\View(statusCode=200)
     *
     * @param BookDto $bookDto
     * @param Book $book
     * @param ConstraintViolationList $violationList
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
     * @Route("/books/{id}", name="book_delete", methods={"DELETE"})
     * @Rest\View(statusCode=204)
     *
     * @param int $id
     */
    public function deleteBook(int $id): void
    {
        $this->manager->remove($id);
    }
}
