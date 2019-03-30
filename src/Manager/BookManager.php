<?php

declare(strict_types=1);

namespace App\Manager;

use App\Assembler\BookAssembler;
use App\Dto\BookDto;
use App\Entity\Book;
use App\Repository\BookRepository;

final class BookManager
{
    private $repository;
    private $assembler;

    public function __construct(BookRepository $repository, BookAssembler $assembler)
    {
        $this->repository = $repository;
        $this->assembler = $assembler;
    }

    public function get(Book $book): BookDTO
    {
        return $this->assembler->write($book);
    }

    /**
     * @return BookDto[]
     */
    public function getList(): array
    {
        return $this->assembler->writeMultiple($this->repository->findAll());
    }

    public function findBooksWithTitleButThis(string $title, ?int $id): array
    {
        return $this->repository->findBooksWithTitleButThis($title, $id);
    }

    public function save(BookDto $bookDTO, ?Book $book = null): BookDto
    {
        $book = $this->assembler->read($bookDTO, $book);

        $this->repository->save($book);

        return $this->assembler->write($book);
    }

    public function remove(int $id): void
    {
        $book = $this->repository->find($id);

        if ($book) {
            $this->repository->remove($book);
        }
    }
}
