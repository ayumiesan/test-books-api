<?php

declare(strict_types=1);

namespace App\Assembler;

use App\Dto\BookDto;
use App\Entity\Book;
use App\Factory\BookFactory;
use App\Repository\BookRepository;

final class BookAssembler
{
    private $categoryAssembler;
    private $bookRepository;

    public function __construct(CategoryAssembler $categoryAssembler, BookRepository $bookRepository)
    {
        $this->categoryAssembler = $categoryAssembler;
        $this->bookRepository = $bookRepository;
    }

    public function read(BookDto $bookDto): Book
    {
        $book = $bookDto->id ? $this->bookRepository->find($bookDto->id) : BookFactory::getNew();
        $book->updateBook($bookDto->title, $bookDto->resume, $bookDto->score, $this->categoryAssembler->readMultiple($bookDto->categories));

        return $book;
    }

    public function write(Book $book): BookDto
    {
        $bookDto = new BookDto();
        $bookDto->id = $book->getId();
        $bookDto->title = $book->getTitle();
        $bookDto->resume = $book->getResume();
        $bookDto->score = $book->getScore();
        $bookDto->categories = $this->categoryAssembler->writeMultiple($book->getCategories()->toArray());

        return $bookDto;
    }

    public function writeMultiple(array $books): array
    {
        return array_map(function (Book $book) {
            return $this->write($book);
        }, $books);
    }
}
