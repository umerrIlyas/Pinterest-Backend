<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Http\Request;

class PostService
{
    public function create(Request $request)
    {
        /** save image */
        $imageName = $this->saveImage($request);
        $postData  = $request->validated();

        $postData['file'] = $imageName;

        return Post::create($postData);
    }

    public function update(Request $request, $post)
    {
        //
    }

    public function saveImage(Request $request): string
    {
        $image = $request->file('file');
        $imageName = time() . '.' . $image->getClientOriginalExtension();

        $image->move(public_path(Post::PATH), $imageName);

        return $imageName;
    }
}
