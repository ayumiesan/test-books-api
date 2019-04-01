<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\BookDto;
use App\Entity\Book;
use App\Form\BookType;
use App\Manager\BookManager;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Swift_Mailer;
use Swift_Message;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

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
     * @Rest\Get("/books/{id}")
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

    /**
     * @Rest\POST("/books/{id}/share")
     * @Rest\View(statusCode=200)
     */
    public function shareBook(Book $book, Request $request, Swift_Mailer $mailer): array
    {
        $message = (new Swift_Message('Share a book'))
            ->setFrom('send@example.com')
            ->setTo($request->request->get('email'))
            ->setBody(
                $this->renderView('emails/share-book.html.twig', [
                    'book' => $book
                ]),
                'text/html'
            )
        ;
        $mailer->send($message);

        return ['success' => 'ok'];
    }
}
