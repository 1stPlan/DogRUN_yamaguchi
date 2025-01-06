<?php

namespace App\Http\Controllers\Admin\Event\Participant;

use App\Http\Controllers\Controller;
use App\Models\Event\Event;
use App\Models\Event\EventParticipant;
// use Hashids\Hashids;

use App\Models\User;
use DB;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // parent::__construct();
        $this->middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $event = Event::find($request->event_id);
        $eventParticipants = EventParticipant::eventId($request->event_id)->orderBy('id', 'desc')->get();

        return view('admin.event.participant.index')->with([
            'event' => $event,
            'eventParticipants' => $eventParticipants,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $event = Event::find($request->event_id);

        return view('admin.event.participant.create')->with([
            'event' => $event,
        ]);
    }

    public function store(Request $request)
    {
        // イベント参加者の編集は無し

        if (isset($request->user_id)) {
            $user = User::find($request->user_id);
        }

        if (! isset($user) && isset($request->email)) {
            $user = User::email($request->email)->first();
        }

        if (! isset($user)) {
            dump('不正なユーザー');

            return redirect()->route('admin.participant.index', $request->event_id);
        }

        $participant = EventParticipant::userId($user->id)->EventId($request->event_id)->first();
        if ($participant) {
            dump('参加済み');

            return redirect()->route('admin.participant.index', $request->event_id);
        }

        DB::beginTransaction();
        try {
            $participantData = [];
            $participantData['user_id'] = $user->id;
            $participantData['event_id'] = $request->event_id;

            // 修正必須
            // $hashids = new Hashids(config('const.remoteStyleKey'), config('const.hashLength'));
            // $urlHash = $hashids->encode([$participantData['user_id'], $participantData['event_id']]);
            // $participantData['payment_url'] = route('event.payment', $urlHash);

            EventParticipant::create($participantData);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }

        return redirect()->route('admin.participant.index', $participantData['event_id']);
    }

    public function edit(Request $request)
    {
        $event = Event::find($request->event);

        return view('admin.event.participant.edit');
    }

    public function destroy(Request $request)
    {
        $participant = EventParticipant::id($request->participant_id)->first();
        $participant->delete();

        return redirect()->back();
    }
}
