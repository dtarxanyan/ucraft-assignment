<?php

namespace App\Http\Controllers;

use App\DTO\PostsQueueMessage;
use App\Models\Post;
use App\Services\PostService;
use App\Services\PostServiceException;
use App\Services\PostsQueueProducer;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Throwable;

class DeletePostController extends Controller
{
    public function __invoke(
        Post               $post,
        PostService        $postService,
        PostsQueueProducer $postsQueueProducer,
    ): Response
    {
        try {
            $postService->deletePost($post);

            $postsQueueProducer->publish(new PostsQueueMessage(
                postId: $post->id,
                action: PostsQueueMessage::ACTION_DELETE
            ));

            return response("Success", 202);
        } catch (PostServiceException $e) {
            Log::error($e->getMessage());
            return response("Failed to delete the post, please try again later", 500);
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return response("Unexpected server error, please contact support", 500);
        }
    }
}
