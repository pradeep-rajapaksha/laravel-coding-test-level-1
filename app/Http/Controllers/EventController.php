<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Redis;

use App\Events\SendMailOnEventCreate;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')
            ->only([
                'destroy',
                'store',
                'update',
            ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::all();

        return view('events.index', [ 'events' => $events]);
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
            'name' => 'required',
            'slug' => 'required|unique:events',
            'startAt' => 'required',
            'endAt' => 'required',
        ]);

        $event = Event::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'startAt' => $request->startAt,
            'endAt' => $request->endAt,
        ]);

        Redis::set('event_' . $event->id, $event);

        event(new SendMailOnEventCreate(\Auth::user()->email));

        return redirect()->route('events.show', ['event' => $event]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cachedEvent = Redis::get('event_' . $id);
        
        if(isset($cachedEvent)) {
            $event = json_decode($cachedEvent, FALSE);
        } 
        else {
            $event = Event::findOrFail($id);
            Redis::set('event_' . $id, $event);
        }

        return view('events.view', ['event' => $event]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $event = Event::findOrFail($id);

        return view('events.edit', ['event' => $event]);
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
        $event = Event::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:events,slug,'.$id,
            'startAt' => 'required',
            'endAt' => 'required',
        ]);

        $event->name = $request->name;
        $event->slug = $request->slug;
        $event->startAt = $request->startAt;
        $event->endAt = $request->endAt;

        $event->save();

        Redis::del('event_' . $id);
        Redis::set('event_' . $id, $event);

        return redirect()->route('events.show', ['event' => $event]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = Event::findOrFail($id);

        $event->delete();

        Redis::del('event_' . $id);

        return redirect()->route('events.index');
    }
}
