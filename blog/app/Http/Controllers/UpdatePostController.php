<?php

namespace App\Http\Controllers;

use App\DTO\PostsQueueMessage;
use App\DTO\UpdatePostDTO;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Services\PostService;
use App\Services\PostServiceException;
use App\Services\PostsQueueProducer;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Throwable;

class UpdatePostController extends Controller
{
    public function __invoke(
        Post               $post,
        UpdatePostRequest  $request,
        PostService        $postService,
        PostsQueueProducer $postsQueueProducer,
    ): Response
    {
        try {
            $data = new UpdatePostDTO($request->all());
            $postService->updatePost($post, $data);

            $postsQueueProducer->publish(new PostsQueueMessage(
                postId: $post->id,
                action: PostsQueueMessage::ACTION_UPDATE
            ));

            return response("Success", 202);
        } catch (UnknownProperties $e) {
            Log::error($e->getMessage());
            return response("Unknown arguments", 400);
        } catch (PostServiceException $e) {
            Log::error($e->getMessage());
            return response("Failed to update the post, please try again later", 500);
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return response("Unexpected server error, please contact support", 500);
        }
    }
}
