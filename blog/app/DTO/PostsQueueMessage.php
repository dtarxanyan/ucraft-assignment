<?php

namespace App\DTO;

use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Attributes\Strict;

#[Strict]
class PostsQueueMessage extends DataTransferObject
{
    const ACTION_CREATE = "create";
    const ACTION_UPDATE = "update";
    const ACTION_DELETE = "delete";

    public int $postId;
    public string $action;
}
