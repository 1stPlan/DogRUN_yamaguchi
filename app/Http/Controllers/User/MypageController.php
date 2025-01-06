<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event\Event;
use App\Models\Event\EventParticipant;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MypageController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function index()
    {
        $user = User::find(Auth::id());
        $today = Carbon::now();
        $deadLine = strtotime($user->dead_line);

        // ログイン日数を記録する為に使用
        if ($today->format('Y/m/d') > $user->updated_at->format('Y/m/d')) {
            $user->login_count = $user->login_count + 1;
            $user->save();
        }

        // 残り日数を取得
        $count = floor(($deadLine - strtotime($today)) / (60 * 60 * 24));

        // Userから取得　
        $type = $user->type;

        // 参加予定イベントを取得する。
        $events = Event::status('公開中')->get();

        // これでこのユーザーの参加しているイベントを前取得する。ここからそのイベントの詳細を取得する。
        $event_participants = EventParticipant::userId($user->id)->get();

        if (count($event_participants) == 0) {
            $event_participant = '';
        } else {
            for ($i = 0; $i < count($event_participants); $i++) {
                $event_participant[$i] = Event::find($event_participants[$i]['event_id']);
            }
        }

        return view('user.mypage')->with([
            'user' => $user,
            'count' => $count,
            'type' => $type,
            'events' => $events,
            'participant' => $event_participant,
        ]);
    }

    public function event_participant_destroy(Request $request)
    {
        $participant = EventParticipant::eventId($request->event_id)->userId($request->user_id)->first();
        $participant->delete();

        return redirect()->back();
    }
}
