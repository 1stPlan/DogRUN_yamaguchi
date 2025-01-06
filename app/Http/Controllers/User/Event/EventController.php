<?php

namespace App\Http\Controllers\User\Event;

use App\Http\Controllers\Controller;
use App\Models\Event\Event;
use App\Models\Event\EventParticipant;
use App\Models\Event\EventPost;
use App\Models\Event\EventSearch;
use App\Models\Event\EventSearchCategory;
use App\Models\Event\EventView;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::orderBy('start_datetime', 'desc')->get();
        $event_search = EventSearch::get();
        $event_categories = EventSearchCategory::get();

        foreach ($event_search as $index => $search) {
            for ($i = 0; $i < count($events); $i++) {
                if ($search->event_id == $events[$i]->id) {
                    $events[$i]['categoryid'] = $search->category_id;
                }
            }
        }
        $event_count = Event::orderBy('view_count', 'DESC')->take(4)->get();

        foreach ($event_search as $index => $search) {
            for ($i = 0; $i < count($event_count); $i++) {
                if ($search->event_id == $event_count[$i]->id) {
                    $event_count[$i]['categoryid'] = $search->category_id;
                }
            }
        }

        $now = Carbon::now();

        return view('user.event.event')->with([
            'events' => $events,
            'event_count' => $event_count,
            'now' => $now,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $events = Event::orderBy('id', 'desc')->get();
        $event_categories = EventSearchCategory::get();

        return view('user.event.create')->with([
            'events' => $events,
            'event_categories' => $event_categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        // $this->validator($request->all())->validate();

        DB::transaction(function () use ($data, $request) {

            if ($request->file('img_url')) {
                $extension = $request->file('img_url')->getClientOriginalExtension();
                $path = Storage::disk('local')->putFileAs('public/image', $data['img_url'], date('YmdHis').$data['title'].'.'.$extension, 'public');
                $data['img_url'] = Storage::url($path);
            }

            // $data['status'] = "none"; //これは変えたい
            $data['user_id'] = Auth::id();

            $event = Event::create($data);

            EventSearch::create([
                'event_id' => $event->id,
                'category_id' => $data['event_search_category_id'],
            ]);

            EventPost::create([
                'event_id' => $event->id,
                'title' => $data['title'],
            ]);
        });

        // );

        // 審査完了メール
        // if (isset($event->accept_flg)) {
        //   NOTE: accept_flg = 1 : 承認, 0 : 非承認, null : 承認待ち（メール送らない）
        //   Mail::to($user)->send(new DecidePublishEventForOrganizer($event, $user));
        // }

        return redirect()->route('user.event');
    }

    public function eventParticipant(Event $event)
    {
        $user = User::find(Auth::id());
        $participant = EventParticipant::userId($user->id)->EventId($event->id)->first();
        if ($participant) {
            // 参加済みを削除
            $participant->delete();

            return redirect()->route('user.event.show', ['event' => $event->id]);
        }

        DB::beginTransaction();
        try {
            $participantData = [];
            $participantData['user_id'] = $user->id;
            $participantData['event_id'] = $event->id;

            EventParticipant::create($participantData);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }

        return redirect()->route('user.event.show', ['event' => $event->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(event $event, Request $request)
    {
        $author = User::find($event->user_id);

        if (Auth::check()) {
            $user = User::find(Auth::id());
            $participant = EventParticipant::userId($user->id)->EventId($event->id)->first();

            DB::transaction(function () use ($request, $event, $user) {

                EVENTView::create([
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'event_id' => $event->id,
                    'user_id' => $user->id,
                ]);

                $event->fill(['view_count' => $event->views->count()])->save();
            });
        } else {
            $user = '';
            $participant = '';
        }

        $participant ? $participant_flg = 1 : $participant_flg = 0;

        return view('user.event.event_show')->with([
            'event' => $event,
            'participant_flg' => $participant_flg,
            'author' => $author,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $event = Event::find($request->event);
        $event_categories = EventSearchCategory::get();

        return view('user.event.edit')->with([
            'event' => $event,
            'event_categories' => $event_categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {

        $data = $request->all();

        // $this->validator($request->all())->validate();

        if (isset($data['image'])) {
            $extension = $request->file('img_url')->getClientOriginalExtension();
            $path = Storage::disk('local')->putFileAs('public/image', $data['img_url'], date('YmdHis').$data['name'].'.'.$extension, 'public');
            $data['img_url'] = Storage::url($path);
        }

        $data['capacity'] = $data['capacity'] ?? 0;

        DB::transaction(function () use ($data, $event) {

            // $eventSearch = EventSearch::eventId($event->id)->categoryId($data['event_search_category_id'])->first();
            // if (is_null($eventSearch)) {
            //     $oldEventSearches = EventSearch::eventId($event->id)->first();
            //     if ($oldEventSearches) {
            //         $oldEventSearches->delete();
            //     }

            //     EventSearch::create([
            //         'event_id' => $event->id,
            //         'category_id' => $data['event_search_category_id'],
            //     ]);
            // }

            $event->fill($data)->save();
        });

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(request $request)
    {
        $event = Event::find($request->event);
        $event->delete();

        return redirect()->back();
    }
}
