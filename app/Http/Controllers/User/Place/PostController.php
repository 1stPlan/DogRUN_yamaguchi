<?php

namespace App\Http\Controllers\User\Place;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post\Post;
use App\Models\Post\Rating;
use App\Models\Post\Like;
use App\Models\Place;
use App\Models\User;
use App\Http\Requests\PostRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class PostController extends Controller
{

    public function __construct() {}

    public function index(Request $request, $place_id)
    {
        $posts = Post::placeId($place_id)->latest()->get();
        $users = User::get();
        $place = Place::id($place_id)->first();

        foreach ($posts as $post) {
            $rating = Rating::postId($post->id)->first();
            $sameIp =  $post->ip_address == $request->ip() ?  "1" : "0";

            $like_count = Like::postId($post->id)->count();
            $post['rating'] =  $rating['rating'];
            $post['like_count'] =  $like_count;
            $post['sameIp'] = $sameIp;
        }

        return view('user.place.posts.post')
            ->with([
                'posts' => $posts,
                'users' => $users,
                'place' => $place,
            ]);
    }

    public function create(Request $request)
    {
        $id = $request->id;
        $place = Place::id($id)->first();
        $user =  Auth::id() ? User::find(Auth::id()) : "";

        return view('user.place.posts.create')
            ->with([
                'place' => $place,
                'user' => $user,
            ]);
    }

    public function store(PostRequest $request)
    {
        $data = $request->all();
        $user_id = Auth::id() ? Auth::id() : null;

        DB::transaction(function () use ($data, $user_id, $request) {

            $post = post::create([
                'tittle' =>  $data['tittle'],
                'body' =>  $data['body'],
                'user_id' =>  $user_id,
                'name' => $data['name'],
                'place_id' => $data['place_id'],
                'ip_address' => $request->ip()
            ]);

            Rating::create([
                'rating' =>  $data['rating'],
                'post_id' => $post->id,
                // 'place_id' => $data['place_id']
            ]);
        });

        return redirect()->action('User\Place\PostController@index', ['place_id' => $data['place_id']]);
    }

    public function destroy(Post $post)
    {
        DB::transaction(function () use ($post) {
            $post->delete();
            $post->ratings()->delete();
            $post->likes()->delete();
        });

        return redirect()->back();
    }
}
