<?php

namespace App\Services\Posts;

use App\DataTransferObjects\PostDto;
use App\Http\Resources\PostDetailResource;
use App\Models\Post;

class PostService
{
    public function createPost(PostDto $data)
    {
        return Post::create([
            'title' => $data->title,
            'news_content' => $data->news_content,
            'author' => $data->author
        ]);
    }

    public function getPosts()
    {
        return Post::latest()->paginate(10);
    }

    public function getPost(int $id)
    {
        $post = Post::with('writer:id,username')->find($id);

        if (empty($post)) {
            return response()->json([
                'message' => "Post not found!"
            ], 404);
        }

        return new PostDetailResource($post);
    }

    public function updatePost(int $id)
    {
    }
}
