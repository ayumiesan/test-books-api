<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
final class BookUniqueTitle extends Constraint
{
    public $message = 'Ce titre existe déjà';
}
