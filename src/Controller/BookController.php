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
     */
    public function postBook(BookDto $bookDto, ConstraintViolationList $violationList): View
    {
        if (count($violationList)) {
            return $this->view($violationList, Response::HTTP_BAD_REQUEST);
        }

        $book = $this->manager->save($bookDto);

        return View::create($book, Response::HTTP_CREATED);
    }

    /**
     * @Route("/books", name="book_get_list", methods={"GET"})
     * @Rest\View(statusCode=200)
     */
    public function getBooks(): View
    {
        $books = $this->manager->getList();

        return View::create($books, Response::HTTP_OK);
    }

    /**
     * @Route("/books/{id}", name="book_get", methods={"GET"})
     * @Rest\View(statusCode=200)
     */
    public function getBook(Book $book): View
    {
        $bookDto = $this->manager->get($book);

        return View::create($bookDto, Response::HTTP_OK);
    }

    /**
     * @Route("/books/{id}", name="book_put", methods={"PUT"})
     * @ParamConverter("bookDTO", converter="fos_rest.request_body")
     * @Rest\View(statusCode=200)
     */
    public function putBook(BookDto $bookDto, Book $book, ConstraintViolationList $violationList): View
    {
        if (count($violationList)) {
            return $this->view($violationList, Response::HTTP_BAD_REQUEST);
        }

        $book = $this->manager->save($bookDto, $book);

        return View::create($book, Response::HTTP_OK);
    }

    /**
     * @Route("/books/{id}", name="book_delete", methods={"DELETE"})
     * @Rest\View(statusCode=204)
     */
    public function deleteBook(int $id)
    {
        $this->manager->remove($id);

        return View::create([], Response::HTTP_NO_CONTENT);
    }
}
