<?php

namespace App\Http\Controllers\User\Event;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event\EventPost;
use App\Models\Event\Event;

use App\Models\Place;
use App\Models\User;
use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class EventPostController extends Controller
{

    // public function __construct()
    // {
    //  $this->middleware('auth:user');
    // }


    public function show($event, User $user)
    {
      
        $post = EventPost::eventId($event)->first();
        $event = Event::id($event)->first();

        $post['title'] = $event->title;
        $post['body'] = $event->body;
        $post['img_url'] = $event->img_url;

        $user = $user::find(Auth::id());
        $users = User::get();

        return view('user.event.posts.show')
            ->with([
                'post' => $post,
                'user' => $user,
                'users' => $users
            ]);
    }

    public function create(Request $request)
    {
        $id = $request->id;
        $place = Place::dataId($id)->first();
        $user =  User::find(Auth::id());

        return view('user.posts.create')
            ->with([
                'place' => $place,
                'user' => $user,
            ]);;
    }

    public function store(PostRequest $request, User $users)
    {
        $data = $request->all();

        $user = $users::find(Auth::id());


        $post = DB::transaction(function () use ($data, $user) {

            $post = post::create([
                'body' =>  $data['body'],
                'user_id' => $user->id,
                'place_id' => $data['place_id']
            ]);

            Rating::create([
                'rating' =>  $data['rating'],
                'post_id' => $post->id,
                'place_id' => $data['place_id']
            ]);

            return $post;
        });


        //新規ポストの場所へ移動したい
        return view('user.posts.show')->with('post', $post);
    }

    public function edit(post $post)
    {
        return view('user.posts.edit')->with('post', $post);
    }

    public function update(PostRequest $request, Post $post)
    {

        $post->title = $request->title;
        $post->body = $request->body;
        $post->save();
        return redirect('/user/post');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->back();
    }
}
