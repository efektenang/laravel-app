<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\PostDTO;
use App\Requests\PostRequest;
use App\Services\Posts\PostService;
use Exception;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function __construct(
        protected PostService $service
    ) {
    }

    public function index()
    {
        $posts = $this->service->getPosts();

        return response()->json($posts, 200);
    }

    public function show($id)
    {
        try {
            $post = $this->service->getPost($id);

            return response()->json([
                'success' => true,
                'message' => "OK",
                'data' => $post
            ], 200);
        } catch (Exception $error) {
            return response()->json([
                'success' => false,
                'message' => $error->getMessage(),
            ], 400);
        }
    }

    public function create(PostRequest $request)
    {
        try {
            $validator = $request->validated();
            $validator['author'] = Auth::user()->id;
            $postDTO = new PostDTO($validator);
            $createPost = $this->service->createPost($postDTO);

            return response()->json([
                'success' => true,
                'message' => "OK",
                'data' => $createPost
            ], 200);
        } catch (Exception $error) {
            return response()->json([
                'success' => false,
                'message' => $error->getMessage(),
            ], 400);
        }
    }

    public function update(PostRequest $request, int $id)
    {
        try {
            $validator = $request->validated();
            $validator['author'] = Auth::user()->id;
            $postDTO = new PostDTO($validator);
            $updatePost = $this->service->updatePost($postDTO, $id);

            return response()->json([
                'success' => true,
                'message' => "OK",
                'data' => $updatePost
            ], 200);
        } catch (Exception $error) {
            return response()->json([
                'success' => false,
                'message' => $error->getMessage(),
            ], 400);
        }
    }

    public function delete(int $id)
    {
        try {
            $deletePost = $this->service->deletePost($id);

            return response()->json([
                'success' => true,
                'message' => "OK",
                'data' => $deletePost
            ], 200);
        } catch (Exception $error) {
            return response()->json([
                'success' => false,
                'message' => $error->getMessage(),
            ], 400);
        }
    }
}
