<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Post;
use App\Models\Website;


class PostController extends Controller
{
    public function store(Request $request, $website_id) {
      $validator = Validator::make($request->all(), [
            'title' => 'required|unique:posts|max:255',
            'description' => 'required',
            'body' => 'required',
      ]);

      if($validator->fails()) {
        return response()->json([
          'error' => true,
          'messages' => $validator->errors(),
        ], Response::HTTP_BAD_REQUEST);
      }

      // Retrieve the validated input...
      $validated = $validator->validated();
      $data = $validator->safe()->only(['title','description','body']);
      $post = Post::create(array_merge($data,['website_id' => $website_id]));

      return response()->json([
        'success' => true,
        'data' => [
          'post' => $post,
        ],
      ], Response::HTTP_CREATED);
    }
}
