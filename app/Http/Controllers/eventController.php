<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;
use App\Models\Event;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use Exception;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;


class eventController extends Controller
{
    public function paginate(Request $request, $items, $perPage = 10, $page = null, $options = [])
    {
        $page = isset($request->page) ? $request->page : 1;
        $items = $items instanceof Collection ? $items : Collection::make($items);
        if (empty($options)) {
            $options['path'] = $request->url();
        }

        return new LengthAwarePaginator(
            $items->forPage($page, $perPage),
            $items->count(),
            $perPage,
            $page,
            ['path' => $options['path']],
        );
    }


    public function index(Request $request)
    {
        $events = Event::all()->where('endingAt', '>', Carbon::now('GMT+1'));
        $eventsFullData = array();
        foreach ($events as $event) {
            array_push($eventsFullData, $event->getAttributes()['id']);
        }
        if ($request->session()->has('searchData')) {
            $request->session()->forget('searchData');
        }
        $request->session()->put('indexData', $eventsFullData);
        $events = Event::where('endingAt', '>', Carbon::now('GMT+1'))->paginate(5);
        $search =  true;
        $data = $request->all();
        //TODO: retrieve the index data in the filter functions 
        //=> $request->session()->get('indexData');
        return view('events.Show', compact('events', 'search', 'data'));
    }

    public function filter(Request $request)
    {   
        $userType = null;
        $data = array();
        if ($request->session()->has('ManagerRealTime'))
        {
            $data = $request->session()->get('ManagerRealTime');
            $userType='manager';
        }  
        else if ($request->session()->has('ManagerHistory')) {
            $data = $request->session()->get('ManagerHistory');
            $userType='manager';
        }
        else if ($request->session()->has('searchData')) 
        {
            $data = $request->session()->get('searchData');
            $userType='coordinator';
        } 
        else if ($request->session()->has('indexData')) 
        {
            $data = $request->session()->get('indexData');
            $userType='coordinator';
        }


        $hideOrder = null;
        if ($request->submit == 'filter') 
        {
            $events= array();
            $searchCrit = $request->input('SearchCrit');
            $hideOrder = false;
            switch ($searchCrit) {
                
                case 'nearest':
                    
                    array_push($events,Event::orderBy('startingAt','ASC')->whereIn('id',$data)->get()); 
                    $dataToPass = array();
                    foreach($events[0] as $event)
                    {
                        array_push($dataToPass,$event->getAttributes());
                    }
                    $events = $this->paginate($request,$dataToPass,5);
                    break;



                case 'latest':

                    array_push($events,Event::orderBy('startingAt','DESC')->whereIn('id',$data)->get()); 
                    $dataToPass = array();
                    foreach($events[0] as $event)
                    {
                        array_push($dataToPass,$event->getAttributes());
                    }
                    $events = $this->paginate($request,$dataToPass,5);
                    break;





                case 'camp':

                    $ALLevWcamps = array(); 
                    foreach(Campaign::all() as $camp)
                    {
                        array_push($ALLevWcamps,$camp->getAttributes()['eventId']);
                    }
                    $idsWcamps = array_intersect($ALLevWcamps,$data);
                    if(empty($idsWcamps))
                    {
                        dd('error!! no event matches with the filter ');
                    }
                    else
                    {
                        $events = Event::whereIn('id',$idsWcamps)->paginate(5);
                    }

                    break;




                case 'nocamp':
                    $ALLevWcamps = array(); 
                    foreach(Campaign::all() as $camp)
                    {
                        array_push($ALLevWcamps,$camp->getAttributes()['eventId']);
                    }
                    $idsWithoutCamps = array_diff($data,$ALLevWcamps);
                    if(empty($idsWithoutCamps))
                    {
                        dd('error!! no event matches with the filter.');
                    }
                    else
                    {
                        $events = Event::whereIn('id',$idsWithoutCamps)->paginate(5);
                    }
                    break;
            }

        } 
        else if ($request->submit == 'orderDesc') 
        {
            $hideOrder = true;
            $events = Event::orderBy('title','ASC')->whereIn('id',$data)->paginate(5);            
        } 
        else if ($request->submit == 'orderAsc') 
        {
            $hideOrder = true;
            $events = Event::orderBy('title','DESC')->whereIn('id',$data)->paginate(5);
        }


        $search = true;
        $data = $request->all();
        //todo make conditions to manage views returns
        if ($userType == 'coordinator') 
        {
            return view('events.Show', compact('events', 'search', 'data'));
        }
        else if ($userType == 'manager') 
        {
            $realtimedata = true;
            $Historydata = true;
            return view('events.show', compact('search','data','events','realtimedata','Historydata','hideOrder'));            
        }
    }

    public function search(Request $request)
    {

        $titleOrLocation = $request->input('search');
        $events = Event::where('title', $titleOrLocation)->orWhere('location', $titleOrLocation)->where('endingAt', '>', Carbon::now('GMT+1'))->get();
        $eventsFullData = array();
        foreach ($events as $event) {
            array_push($eventsFullData, $event->getAttributes()['id']);
        }
        if ($request->session()->has('indexData')) {
            $request->session()->forget('indexData');
        }
        $request->session()->put('searchData', $eventsFullData);
        $events = Event::where('title', $titleOrLocation)->orWhere('location', $titleOrLocation)->where('endingAt', '>', Carbon::now('GMT+1'))->paginate(5);
        $data = $request->all();
        $search = true;
        //Todo: retrieve the searched data in the filter functions 
        //=> $request->session()->get('searchData'));
        return view('events.Show', compact('events', 'data', 'search'));
    }


    public function create()
    {
        return view('events.create');
    }


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
        try {
            $sDate = explode('/', $request->input('Starting_date'));
            $eDate = explode('/', $request->input('Ending_date'));
            if (strpos($request->input('Starting_time'), 'PM') !== false) {
                $sTime = trim($request->input('Starting_time'), 'AMP ');
                $sTime = explode(':', $sTime);
                $sTime[0] = (int)$sTime[0];
                if ($sTime[0] == 12) {
                    $sTime[0] = "00";
                } else {
                    $sTime[0] += 12;
                }
                $sTime[0] = (string)$sTime[0];
                $sTime = $sTime[0] . ':' . $sTime[1];
            } else {
                $sTime = trim($request->input('Starting_time'), 'AMP ');
            }

            if (strpos($request->input('Ending_time'), 'PM') !== false) {
                $eTime = trim($request->input('Ending_time'), 'AMP ');
                $eTime = explode(':', $eTime);
                $eTime[0] = (int)$eTime[0];
                if ($eTime[0] == 12) {
                    $eTime[0] = "00";
                } else {
                    $eTime[0] += 12;
                }
                $eTime[0] = (string)$eTime[0];
                $eTime = $eTime[0] . ':' . $eTime[1];
            } else {
                $eTime = trim($request->input('Ending_time'), 'AMP ');
            }

            $startDateTime = $sDate[2] . '-' . $sDate[1] . '-' . $sDate[0]  . ' ' . $sTime . ':00';

            $endDateTime = $eDate[2] . '-' . $eDate[1] . '-' . $eDate[0]  . ' ' . $eTime . ':00';

            $format = 'Y-m-d H:i:s';
            $timezone = new DateTimeZone('GMT+1');
            $object_sDateTime = DateTime::createFromFormat($format, $startDateTime, $timezone);
            $object_eDateTime = DateTime::createFromFormat($format, $endDateTime, $timezone);
            if ($object_sDateTime > $object_eDateTime) {
                $message = 'Un événement ne peut pas avoir une date/heure de début postérieure à la date/heure de fin';
                throw new Exception($message);
            }
        } catch (Exception $e) {
            return back()->withErrors(["error" => $e->getMessage()]);
        }

        $thisEvent = new Event([
            'title' => $request->input('Title'),
            'object' => $request->input('Object'),
            'startingAt' => $startDateTime,
            'endingAt' => $endDateTime,
            'location' => $request->input('location'),
            'room' => $request->input('room'),
        ]);

        $thisEvent->save();

        Session::flash('successMsg', 'Événement créé avec succès.');
        return redirect(route('dashboard'));
    }


    public function show($id)
    {
        $details = Event::find($id);
        $Date_Time = array();
        $Sd = array();
        $Ed = array();
        $St = array();
        $Et = array();
        for ($i = 0; $i < 10; $i++) {
            array_push($Sd, $details->startingAt[$i]);
            array_push($Ed, $details->endingAt[$i]);
        }
        for ($i = 11; $i < 19; $i++) {
            array_push($St, $details->startingAt[$i]);
            array_push($Et, $details->endingAt[$i]);
        }
        array_push($Date_Time, implode('', $Sd), implode('', $Ed), implode('', $St), implode('', $Et));
        return view('events.Show', compact('details', 'Date_Time'));
    }


    public function destroy($id)
    {
        $event = Event::find($id);
        $event->delete();
        return redirect(route('dashboard'));
    }
}
