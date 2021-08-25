<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post\Like;
use App\Models\Post\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class ApiLikeController extends Controller
{
  public function store(Request $request, Post $post)
  {
    try {

      $user = Auth::id() ? User::find(Auth::id()) : "";

      Like::create([
        'ip_address' => $request->ip(),
        'post_id' => $post->id,
        'user_id' =>$user
      ]);

      return response()->json(['success' => true, 'message' => 'Like successfully']);

    } catch (\Exception $e) {
      return new JsonResponse(['error' => $e->getMessage()], 500);
    }
  }

  public function destroy(Request $request, post $post, Like $like)
  {
    try {
      $like = Like::postId($post->id)->ipAddress($request->ip())->first();

      $like->delete();

      return response()->json(['success' => true, 'message' => 'Liked successfully']);

    } catch (\Exception $e) {
      return new JsonResponse(['error' => $e->getMessage()], 500);
    }
  }
}
