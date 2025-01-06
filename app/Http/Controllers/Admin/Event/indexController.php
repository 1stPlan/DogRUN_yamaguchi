<?php

namespace App\Http\Controllers\Admin\Event;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventRequest;
use App\Models\Event\Event;
use App\Models\Event\EventPost;
use App\Models\Event\EventSearch;
use App\Models\Event\EventSearchCategory;
use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class IndexController extends Controller
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

    public function index(Request $request)
    {
        $events = Event::orderBy('start_datetime', 'desc')->with('eventSearches')->get();

        // viewに返すデータを整形する

        $eventInfo = [];

        $count = count($events);

        for ($i = 0; $i < $count; $i++) {
            $eventInfo[$i]['id'] = $events[$i]->id;
            $eventInfo[$i]['title'] = $events[$i]->title;
            $eventInfo[$i]['start_datetime'] = $events[$i]->start_datetime;
            $eventInfo[$i]['img_url'] = $events[$i]->img_url;
            $eventInfo[$i]['ticket_price'] = $events[$i]->ticket_price;
            $eventInfo[$i]['body'] = $events[$i]->body;
            $eventInfo[$i]['remarks'] = $events[$i]->remarks;
            $eventInfo[$i]['venue'] = $events[$i]->venue;
            $eventInfo[$i]['shop'] = $events[$i]->shop;
            $eventInfo[$i]['view_count'] = $events[$i]->view_count;
        }

        return view('admin.event.index')->with([
            'eventInfo' => $eventInfo,
        ]);
    }

    public function create(Request $request)
    {
        $events = Event::orderBy('id', 'desc')->get();
        $places = Place::orderBy('id', 'desc')->get();

        return view('admin.event.create')->with([
            'events' => $events,
            'places' => $places,
        ]);
    }

    public function store(EventRequest $request)
    {
        $data = $request->all();

        DB::transaction(function () use ($data, $request) {

            if (isset($data['img_url'])) {
                $extension = $request->file('img_url')->getClientOriginalExtension();
                $path = Storage::disk('local')->putFileAs('public/image/event/', $data['img_url'], $data['title'].'.'.$extension, 'public');

                $filepath = pathinfo(Storage::url($path));
                $data['img_url'] = $filepath['filename'];
            }

            $data['user_id'] = Auth::id();

            $event = Event::create($data);

            EventSearch::create([
                'event_id' => $event->id,
                'category_id' => (int) $data['maker'],
            ]);

            EventPost::create([
                'event_id' => $event->id,
                'title' => $data['title'],
            ]);
        });

        return redirect()->route('admin.events.index');
    }

    public function show(Request $request)
    {
        $event = Event::find($request->event);
        $eventSearchCategories = EventSearchCategory::all();

        return view('admin.event.show')->with([
            'event' => $event,
            'eventSearchCategories' => $eventSearchCategories,
        ]);
    }

    public function edit(Request $request)
    {
        $event = Event::find($request->event);
        $eventSearchCategories = EventSearchCategory::all();

        return view('admin.event.edit')->with([
            'event' => $event,
            'eventSearchCategories' => $eventSearchCategories,
        ]);
    }

    public function update(Request $request, Event $event)
    {
        $data = $request->all();

        DB::transaction(function () use ($data, $event, $request) {

            if (isset($data['img_url'])) {
                $extension = $request->file('img_url')->getClientOriginalExtension();
                $path = Storage::disk('local')->putFileAs('public/image/event/', $data['img_url'], $data['name'].'.'.$extension, 'public');

                $filepath = pathinfo(Storage::url($path));
                $data['img_url'] = $filepath['filename'];
            }

            $event->fill($data)->save();
        });

        return redirect()->route('admin.events.index');
    }

    public function destroy(Request $request)
    {
        $event = Event::find($request->event);
        $event->delete();

        // return ['result' => 'success'];
        return redirect()->back();
    }
}
