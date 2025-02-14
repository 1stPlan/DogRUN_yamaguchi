<?php

namespace App\Http\Controllers\Admin\Place;

use App\Http\Controllers\Controller;
use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class indexController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $places = Place::all();
        // $place_all[] = Place::tag("yamaguchi")->get();
        // $place_all[] = Place::tag("hagi")->get();
        // $place_all[] = Place::tag("syuunan")->get();
        // $place_all[] = Place::tag("shimonoseki")->get();
        // $place_all[] = Place::tag("houhu")->get();
        // $place_all[] = Place::tag("ubeonoda")->get();
        // $place_all[] = Place::tag("iwakunihikari")->get();

        return view('admin.places.index')->with([
            'places' => $places,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $places = Place::all();

        return view('admin.places.create')->with([
            'places' => $places,
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

        DB::transaction(function () use ($data, $request) {

            if ($request->hasFile('img_url')) {

                $extension = $request->file('img_url')->getClientOriginalExtension();
                Storage::disk('local')->putFileAs('public/image/shop/', $data['img_url'], $data['id'] . '.' . $extension, 'public');
            }

            Place::create([
                'name' => $request->name,
                'address' => $request->address,
                'price' => $request->price,
                'time' => $request->time,
                'off' => $request->off,
                'url' => $request->url,
                'CAFE' => $request->has('CAFE') ? 1 : 0,
                'INDOOR' => $request->has('INDOOR') ? 1 : 0,
                'KASIKIRI' => $request->has('KASIKIRI') ? 1 : 0,
                // 'data_id' => null
            ]);
        });

        return redirect()->route('admin.places.index')->with('success', '登録が完了しました');
    }

    public function show(Request $request)
    {
        $place = Place::find($request->place);

        return view('admin.places.show')->with([
            'place' => $place,
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
        $place = Place::find($request->place);

        return view('admin.places.edit')->with([
            'place' => $place,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $place = Place::find($id);

        $data = $request->all();

        DB::transaction(function () use ($data, $place, $request) {

            if ($request->hasFile('img_url')) {
                $extension = $request->file('img_url')->getClientOriginalExtension();
                Storage::disk('local')->putFileAs('public/image/shop/', $data['img_url'], $data['id'] . '.' . $extension, 'public');
            }

            $place->update([
                'name' => $request->name,
                'address' => $request->address,
                'price' => $request->price,
                'time' => $request->time,
                'off' => $request->off,
                'url' => $request->url,
                'CAFE' => $request->has('CAFE') ? 1 : 0,
                'INDOOR' => $request->has('INDOOR') ? 1 : 0,
                'KASIKIRI' => $request->has('KASIKIRI') ? 1 : 0,
                // 'data_id' => null
            ]);
        });



        return redirect()->route('admin.places.index')->with('success', '更新が完了しました');
    }

    public function destroy(Request $request)
    {
        $place = Place::find($request->event);
        $place->delete();

        return redirect()->back();
    }
}
