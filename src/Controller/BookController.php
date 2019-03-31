<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\BookDto;
use App\Entity\Book;
use App\Form\BookType;
use App\Manager\BookManager;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class BookController extends AbstractFOSRestController
{
    private $manager;

    public function __construct(BookManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Rest\Post("/books")
     * @Rest\View(statusCode=201)
     *
     * @return FormInterface|BookDto
     */
    public function postBook(Request $request)
    {
        $bookDto = new BookDto();
        $form = $this->createForm(BookType::class, $bookDto);

        $form->submit($request->request->all());

        if ($form->isValid()) {
            return $this->manager->save($bookDto);
        }

        return $form;
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
     * @Route("/books/{id}", name="book_get")
     * @Rest\View(statusCode=200)
     */
    public function getBook(Book $book): BookDto
    {
        return $this->manager->get($book);
    }

    /**
     * @Rest\Put("/books/{id}")
     * @Rest\View(statusCode=200)
     *
     * @return FormInterface|BookDto
     */
    public function putBook(Request $request, BookDto $bookDto)
    {
        $form = $this->createForm(BookType::class, $bookDto);

        $form->submit($request->request->all());

        if ($form->isValid()) {
            return $this->manager->save($bookDto);
        }

        return $form;
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
