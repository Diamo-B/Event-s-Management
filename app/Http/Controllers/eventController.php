<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\DB;


class eventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::latest()->simplePaginate(3);

        return view('eventShow', compact('events'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('eventForm');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'Title' => 'required',
            'Object' => 'required',
            'Starting_date' => 'required',
            'Starting_time' => 'required',
            'Ending_date' => 'required',
            'Ending_time' => 'required',
            'location' => 'required',
            'room' => 'required',
        ]);

        $startDateTime = $request->input('Starting_date') . ' ' . $request->input('Starting_time') . ':00';
        $endDateTime = $request->input('Ending_date') . ' ' . $request->input('Ending_time') . ':00';

        $thisEvent = new Event([
            'title' => $request->input('Title'),
            'object' => $request->input('Object'),
            'startingAt' => $startDateTime,
            'endingAt' => $endDateTime,
            'location' => $request->input('location'),
            'room' => $request->input('room'),
        ]);
        $thisEvent->save();

        return redirect(route('dashboard'));
    }

    /**
     * Display the details of the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $details = Event::find($id);
        return view('eventShow',compact('details'));
    }

    /** 
     * finds the specified resource.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */


    public function search(Request $request)
    {

        $titleOrLocation = $request->input('search');
        $foundEvent = Event::latest()->where('location', $titleOrLocation )->orWhere('title', $titleOrLocation)->simplePaginate(3);

        return view('eventShow', compact('foundEvent'));
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
        $event = Event::find($id);
        $event->delete();
        return redirect(route('dashboard'));
    }
}
