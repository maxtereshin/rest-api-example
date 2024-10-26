<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\User\PostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list(PostService $postService): JsonResponse
    {
        return response()->json([
            "success" => true,
            "posts" => $postService->list()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function add(Request $request, PostService $postService): JsonResponse
    {
        return response()->json([
            "success" => $postService->add($request->all()),
            'message' => 'Post created successfully',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function get($id, PostService $postService): JsonResponse
    {
        $result = $postService->get($id);
        if(!$result) {
            return response()->json([
                "success" => false,
                'data' => $postService->getError(),
            ]);
        }
        return response()->json([
            "success" => true,
            'data' => $result,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id, PostService $postService)
    {
        $result = $postService->update($id, $request->all());
        if(!$result) {
            return response()->json([
                "success" => false,
                'data' => $postService->getError(),
            ]);
        }
        return response()->json([
            "success" => $result,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(PostService $postService, $id): JsonResponse
    {
        $result = $postService->delete($id);
        if(!$result) {
            return response()->json([
                "success" => false,
                'data' => $postService->getError(),
            ]);
        }
        return response()->json([
            "success" => $result,
        ]);
    }
}
