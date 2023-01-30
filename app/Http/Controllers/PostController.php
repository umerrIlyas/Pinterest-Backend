<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Services\PostService;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {;
        return response()->json([
            'message' => 'Posts fetched successfully',
            'posts' => PostResource::collection(
                Post::with('user')->paginate(20)
            )->response()->getData(true),
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function favorites()
    {;
        $posts =   Post::with('user')->whereHas('likes', function ($query) {
            return $query->where('user_id', auth()->user()->id);
        })->paginate(20);

        return response()->json([
            'message' => 'Posts fetched successfully',
            'posts' => PostResource::collection($posts)->response()->getData(true),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request, PostService $postService)
    {
        try {
            $post = $postService->create($request);
            $message = 'Post created successfully';
        } catch (\Throwable $th) {
            $message = 'An error occurred ' . $th->getMessage();
        }

        return response()->json([
            'message' => $message,
            'post' => $post ?? new PostResource($post),
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return response()->json([
            'message' => 'Post created successfully',
            'post' => new PostResource($post->load('user')),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post, PostService $postService)
    {
        try {
            $postService->update($request, $post);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'An error occurred, ' . $th->getMessage(),
            ], 409);
        }

        response()->json([
            'message' => 'Post updated successfully',
            'post' => new PostResource($post),
        ], 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        response()->json([
            'message' => 'Post created successfully',
        ], 204);
    }

    /**
     * Display a Image preview.
     *
     * @return \Illuminate\Http\Response
     */
    public function imagePreview($name)
    {
        $path = public_path(Post::PATH) . $name;

        if (!File::exists($path)) {
            abort(404);
        }
        return response()->file($path);
    }
}
