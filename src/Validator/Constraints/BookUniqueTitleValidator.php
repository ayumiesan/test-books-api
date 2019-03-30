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
        $form = $this->context->getRoot();

        if (!$form instanceof Form) {
            return;
        }

        /** @var BookDto $bookDto */
        $bookDto = $form->getData();

        if (!$value) {
            return;
        }

        $books = $this->bookManager->findBooksWithTitleButThis($value, $bookDto->id);

        if ($books) {
            $this->context
                ->buildViolation($constraint->message)
                ->addViolation()
            ;
        }
    }
}
