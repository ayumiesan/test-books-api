<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use App\Manager\BookManager;
use Symfony\Component\Form\Form;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class ValidScoreValidator extends ConstraintValidator
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

        if (!$value) {
            return;
        }

        $decimal = $value - floor($value);

        if ($value < 0 || $value > 10 || ($decimal <> 0 && $decimal <> 0.5)) {
            $this->context
                ->buildViolation($constraint->message)
                ->addViolation()
            ;
        }
    }
}
