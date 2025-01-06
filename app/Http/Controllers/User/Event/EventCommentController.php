<?php

namespace App\Http\Controllers\User\Event;

use App\Http\Controllers\Controller;
use App\Models\Event\EventComment;
use App\Models\Event\EventPost;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventCommentController extends Controller
{
    public function store(Request $request, $post)
    {

        $this->validate($request, [
            'body' => 'required',
        ]);
        $user = User::find(Auth::id());
        $event_id = EventPost::id($post)->first()->event_id;

        $comment = EventComment::create([
            'event_post_id' => $post,
            'body' => $request->body,
            'user_id' => $user->id,
        ]);

        return redirect()->action('User\Event\EventPostController@show', $event_id);

    }

    public function destroy(EventComment $Comment)
    {
        $Comment->delete();

        return redirect()->back();
    }
}
