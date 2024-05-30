<?php

namespace App\DTO;

use Spatie\DataTransferObject\Attributes\Strict;
use Spatie\DataTransferObject\DataTransferObject;

#[Strict]
class UpdatePostDTO extends DataTransferObject
{
    public ?string $title;
    public ?string $author;
}
