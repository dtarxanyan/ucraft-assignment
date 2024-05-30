<?php

namespace App\Services;

use App\DTO\CreatePostDTO;
use App\DTO\UpdatePostDTO;
use App\Models\Post;
use App\Repositories\PostsRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

readonly class PostService
{
    public function __construct(private PostsRepository $postsRepository)
    {
    }

    /**
     * @throws PostServiceException
     */
    public function createPost(CreatePostDTO $data): Post
    {
        try {
            $data->publicationYear = Carbon::now()->year;
            return $this->postsRepository->createPost($data);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            throw new PostServiceException("Failed to create a post");
        }
    }

    /**
     * @throws PostServiceException
     */
    public function updatePost(Post $post, UpdatePostDTO $data): bool
    {
        try {
            return $this->postsRepository->updatePost($post, $data);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            throw new PostServiceException("Failed to update the post");
        }
    }

    /**
     * @throws PostServiceException
     */
    public function deletePost(Post $post): bool
    {
        try {
            return $this->postsRepository->deletePost($post);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            throw new PostServiceException("Failed to delete the post");
        }
    }
}
