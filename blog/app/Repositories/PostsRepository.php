<?php

namespace App\Repositories;

use App\DTO\CreatePostDTO;
use App\DTO\UpdatePostDTO;
use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\QueryException;
use Throwable;

class PostsRepository
{
    /**
     * @throws QueryException
     */
    public function createPost(CreatePostDTO $data): Post|Builder
    {
        return Post::query()->create([
            "title" => $data->title,
            "author" => $data->author,
            "publication_year" => $data->publicationYear,
        ]);
    }

    /**
     * @throws Throwable
     */
    public function updatePost(Post $post, UpdatePostDTO $data): bool
    {
        $data->title && $post->title = $data->title;
        $data->author && $post->author = $data->author;

        return $post->saveOrFail();
    }

    /**
     * @throws Throwable
     */
    public function deletePost(Post $post): bool|null
    {
        return $post->deleteOrFail();
    }
}
