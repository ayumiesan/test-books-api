<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use App\Dto\BookDto;
use App\Manager\BookManager;
use Symfony\Component\Form\Form;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class BookUniqueTitleValidator extends ConstraintValidator
{
    private $bookManager;

    public function __construct(BookManager $bookManager)
    {
        $this->bookManager = $bookManager;
    }

    public function validate($value, Constraint $constraint): void
    {
        $bookDto = $this->context->getRoot();

        if (!$bookDto instanceof BookDto) {
            return;
        }

        if (!$value) {
            return;
        }

        $bookId = $bookDto ? $bookDto->id : null;
        $books = $this->bookManager->findBooksWithTitleButThis($value, $bookId);

        if ($books) {
            $this->context
                ->buildViolation($constraint->message)
                ->addViolation()
            ;
        }
    }
}
