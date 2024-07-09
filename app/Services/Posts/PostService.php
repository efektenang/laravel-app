<?php

namespace App\Services\Posts;

use App\DataTransferObjects\PostDto;
use App\Http\Resources\PostDetailResource;
use App\Models\Post;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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

        if (!$post) throw new ModelNotFoundException('Post with ID: ' . $id . ' not found!');

        return new PostDetailResource($post);
    }

    public function updatePost(PostDto $data, int $id)
    {
        $post = Post::find($id);

        if (!empty($post)) throw new ModelNotFoundException('Post with ID: ' . $id . ' not found!');

        $post->title = $data->title;
        $post->news_content = $data->news_content;
        $post->save();

        return response()->json($post);
    }

    public function deletePost(int $id)
    {
        $checkPost = Post::where('id', $id)->exists();
        $post = Post::find($id);
        if (!$checkPost) throw new ModelNotFoundException('Post with ID: ' . $id . ' not found!');

        $post->delete();

        return response()->json($post);
    }
}
