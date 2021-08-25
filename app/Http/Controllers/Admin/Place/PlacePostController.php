<?php

namespace App\Http\Controllers\Admin\Place;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Place;
use App\Models\Post\Post;
use App\Models\User;
use App\Models\Post\Rating;
use App\Models\Post\Like;

class PlacePostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = Post::placeId($request->place)->latest()->get();
        $users = User::get();
        $place = Place::id($request->place)->first();

        foreach ($posts as $post) {
            $rating = Rating::postId($post->id)->first();
            $like = Like::postId($post->id)->ipAddress($request->ip())->first() ? "1" : "0";
            $sameIp =  $post->ip_address == $request->ip() ?  "1" : "0";

            $like_count = Like::postId($post->id)->count();

            $post['rating'] =  $rating['rating'];
            $post['like'] =  $like;
            $post['like_count'] =  $like_count;
            $post['sameIp'] = $sameIp;
        }

        return view('admin.places.post.index')
            ->with([
                'posts' => $posts,
                'users' => $users,
                'place' => $place,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
