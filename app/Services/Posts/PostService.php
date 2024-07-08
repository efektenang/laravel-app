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

    public function updatePost(PostDto $data, int $id)
    {
        $post = Post::find($id);

        if (!empty($post)) {
            $post->title = $data->title;
            $post->news_content = $data->news_content;

            $post->save();

            return response()->json([
                'status' => 200,
                'message' => "OK"
            ], 200);
        } else {
            return response()->json([
                "message" => "Post Not Found"
            ], 404);
        }
    }
}
