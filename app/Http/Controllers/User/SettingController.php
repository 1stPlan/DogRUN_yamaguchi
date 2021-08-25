<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Event\Event;
use App\Models\Event\EventParticipant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $user = User::find(Auth::id());

      //これでこのユーザーの参加しているイベントを全取得する。ここからそのイベントの詳細を取得する。
      $event_participants = EventParticipant::userId($user->id)->get();
      // $event_author = Event::userId($user->id)->get();
      
      if(count($event_participants) == 0){
        $event_participant = "";
      }else{
        for ($i = 0; $i < count($event_participants); $i++) {
          $event_participant[$i] = Event::find($event_participants[$i]["event_id"]);
        }
      }

      return view('user.settings.index')->with([
        'user' => $user,
        'participant' => $event_participant,
        // 'author' => $event_author
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
    public function edit(User $user)
    {
        return view('user.settings.edit')->with([
            'user' => $user
        ]);;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,User $user)
    {

        $data = $request->all();
        
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->intro = $data['intro'];
        $user->img_no = $data['img_no'];
        // if($request->file('img_url')){
        //   $extension = $request->file('img_url')->getClientOriginalExtension();
        //   $url_path = Storage::disk('local')->putFileAs('public/image', $data['img_url'], date('YmdHis').$data['name'].".".$extension, 'public');
        //   $user->img_url = Storage::url($url_path);
        // }
  
        $user ->save();

        return redirect('/user/setting');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function event_destroy(Event $event)
    {
        $user = User::find(Auth::id());
        $event_participants = EventParticipant::userId($user->id)->eventId($event->id)->first();

        $event_participants->delete();
        return redirect()->back();
    }

    
    public function withdrawal()
    {
        $user = User::find(Auth::id());
        return view('user.settings.withdrawal')->with([
          'user' => $user
      ]);
    }

    /**
     * Remove the specified resource from storage.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function withdrawal_complate(User $user)
    {
        $user->delete();
        return view('user.settings.withdrawal_complete');
    }
}
