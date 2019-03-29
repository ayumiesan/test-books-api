<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

final class BookDto
{
    public $id;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=255)
     */
    public $title;

    public $resume;

    /**
     * @Assert\NotBlank()
     * @Assert\Type(type="float")
     */
    public $score;

    public $categories;
}
