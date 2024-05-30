<?php

namespace App\DTO;

use Spatie\DataTransferObject\DataTransferObject;
use \Spatie\DataTransferObject\Attributes\Strict;

#[Strict]
class CreatePostDTO extends DataTransferObject
{
    public string $title;
    public string $author;
    public ?int $publicationYear;
}
