<?php

namespace App\Services;

use App\DTO\PostsQueueMessage;
use App\DTO\DeletePostMessage;
use App\DTO\UpdatePostMessage;
use Illuminate\Support\Facades\Queue;

class PostsQueueProducer
{
    public function publish(PostsQueueMessage | UpdatePostMessage | DeletePostMessage $message): mixed {
        $messageRaw = json_encode($message);
        return Queue::connection("rabbitmq")->pushRaw($messageRaw,"posts");
    }
}
