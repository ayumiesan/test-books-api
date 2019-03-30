<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
final class ValidScore extends Constraint
{
    public $message = 'Un chiffre après la virgule autorisé, multiple de 0.5';
}
