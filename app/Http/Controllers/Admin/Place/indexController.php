<?php

namespace App\Http\Controllers\Admin\Place;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Place;

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function show(Request $request)
    {
        $place = Place::find($request->place);

        return view('admin.places.show')->with([
            'place' => $place
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
            'place' => $place
        ]);
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

    public function destroy(Request $request)
    {
        $place = Place::find($request->event);
        $place->delete();
        
        return redirect()->back();
    }
}
