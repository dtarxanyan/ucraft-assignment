<?php

namespace App\Http\Controllers;

use App\DTO\CreatePostDTO;
use App\DTO\PostsQueueMessage;
use App\Http\Requests\CreatePostRequest;
use App\Services\PostServiceException;
use App\Services\PostsQueueProducer;
use App\Services\PostService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Throwable;

class CreatePostController extends Controller
{
    public function __invoke(
        CreatePostRequest  $request,
        PostService        $postService,
        PostsQueueProducer $postsQueueProducer,
    ): Response
    {
        try {
            $data = new CreatePostDTO($request->all());
            $post = $postService->createPost($data);

            $postsQueueProducer->publish(new PostsQueueMessage(
                postId: $post->id,
                action: PostsQueueMessage::ACTION_CREATE
            ));

            return response("Success", 201);
        } catch (UnknownProperties $e) {
            Log::error($e->getMessage());
            return response("Unknown arguments", 400);
        } catch (PostServiceException $e) {
            Log::error($e->getMessage());
            return response("Failed to create a post, please try again later", 500);
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return response("Unexpected server error, please contact support", 500);
        }
    }
}
