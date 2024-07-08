<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Requests\PostRequest;
use App\Services\Posts\PostService;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function __construct(
        protected PostService $service
    ) {}

    public function index() {
        $posts = $this->service->getPosts();
        
        return response()->json($posts, 200);
    }

    public function show($id) {
        $post = $this->service->getPost($id);
        
        return response()->json([
            'message' => "OK",
            'data' => $post
        ], 200);
    }

    public function create(PostRequest $request) {
        $createPost = $this->service->createPost(
            $request->validated('title'),
            $request->validated('news_content'),
            Auth::user()->id
        );

        return response()->json([
            'success' => true,
            'message' => "OK",
            'data' => $createPost
        ], 200);
    }

    public function update(Request $request, $id) {
        $post = Post::find($id);

        if(empty($post)) {
            return response()->json([
                'message' => "Post not found!"
            ], 404);
        }


    }
}
