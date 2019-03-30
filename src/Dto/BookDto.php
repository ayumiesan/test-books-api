<?php

declare(strict_types=1);

namespace App\Dto;

use App\Validator\Constraints as CustomAssert;
use Symfony\Component\Validator\Constraints as Assert;

final class BookDto
{
    public $id;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=255)
     * @CustomAssert\BookUniqueTitle()
     */
    public $title;

    public $resume;

    /**
     * @Assert\NotBlank()
     * @Assert\Type(type="float").
     * @CustomAssert\ValidScore()
     */
    public $score;

    public $categories;
}
