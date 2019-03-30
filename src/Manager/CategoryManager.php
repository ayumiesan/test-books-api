<?php

declare(strict_types=1);

namespace App\Manager;

use App\Assembler\CategoryAssembler;
use App\Dto\CategoryDto;
use App\Entity\Category;
use App\Repository\CategoryRepository;

final class CategoryManager
{
    private $repository;
    private $assembler;

    public function __construct(CategoryRepository $repository, CategoryAssembler $assembler)
    {
        $this->repository = $repository;
        $this->assembler = $assembler;
    }

    public function get(Category $category): CategoryDTO
    {
        return $this->assembler->write($category);
    }

    /**
     * @return CategoryDto[]
     */
    public function getList(): array
    {
        return $this->assembler->writeMultiple($this->repository->findAll());
    }
}
