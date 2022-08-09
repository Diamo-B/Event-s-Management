<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;


class eventController extends Controller
{

    public function paginate(Request $request, $items, $perPage = 10, $page = null, $options=[])
    {
        $page = isset($request->page) ? $request->page : 1; // Get the page=1 from the url
        /* $page = $page ?: (Paginator::resolveCurrentPage() ?: 1); */
        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator(
            $items->forPage($page, $perPage), $items->count(), $perPage, $page,
            ['path' => $request->url()],
        );
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $events = Event::latest()->where('endingAt', '>', Carbon::now('GMT+1'))->get()->toArray();
        $events = $this->paginate($request,$events);
        $search =  true;
        return view('events.Show', compact('events', 'search'));
    }

    public function search(Request $request)
    {

        $titleOrLocation = $request->input('search');
        $events = Event::latest()->where('endingAt', '>', Carbon::now('GMT+1'))->where('title', $titleOrLocation)->orWhere('location', $titleOrLocation)->get()->toArray();
        $events = $this->paginate($request,$events,5);
        return view('events.show', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('events.create');
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
        $sDate = explode('/', $request->input('Starting_date'));
        $eDate = explode('/', $request->input('Ending_date'));
        if (strpos($request->input('Starting_time'), 'PM' !== false)) {
            $sTime = trim($request->input('Starting_time'), 'AMP ');
            $sTime = explode(':', $sTime);
            $sTime[0] = (int)$sTime[0];
            $sTime[0] += 12;
            $sTime[0] = (string)$sTime[0];
            $sTime = $sTime[0] . ':' . $sTime[1];
        } else {
            $sTime = trim($request->input('Starting_time'), 'AMP ');
        }

        if (strpos($request->input('Ending_time'), 'PM' !== false)) {
            $eTime = trim($request->input('Ending_time'), 'AMP ');
            $eTime = explode(':', $eTime);
            $eTime[0] = (int)$eTime[0];
            $eTime[0] += 12;
            $eTime[0] = (string)$eTime[0];
            $eTime = $eTime[0] . ':' . $eTime[1];
        } else {
            $eTime = trim($request->input('Starting_time'), 'AMP ');
        }


        $startDateTime = $sDate[2] . '-' . $sDate[1] . '-' . $sDate[0]  . ' ' . $sTime . ':00';

        $endDateTime = $eDate[2] . '-' . $eDate[1] . '-' . $eDate[0]  . ' ' . $eTime . ':00';

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
        $Date_Time = array();
        $Sd = array();
        $Ed = array();
        $St = array();
        $Et = array();
        for ($i=0; $i<10; $i++)
        {
            array_push($Sd,$details->startingAt[$i]);
            array_push($Ed,$details->endingAt[$i]);
        }
        for ($i = 11; $i < 19; $i++) {
            array_push($St,$details->startingAt[$i]);
            array_push($Et,$details->endingAt[$i]);
        }
        array_push($Date_Time,implode('',$Sd),implode('',$Ed),implode('',$St),implode('',$Et));
        //dd($Date_Time);
        return view('events.Show', compact('details','Date_Time'));
    }

    /** 
     * finds the specified resource.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */



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
