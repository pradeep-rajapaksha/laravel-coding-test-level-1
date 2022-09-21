<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Models\Event;
use App\Http\Resources\EventResource;

use Event;
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

        return EventResource::collection($events);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getActiveEvents()
    {
        $datetime = date('Y-m-d H:i:s');
        $events = Event::where('startAt', '<=', $datetime)->where('endAt', '>=', $datetime)->get();

        return EventResource::collection($events);
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

        Event::fire(new SendMailOnEventCreate(\Auth::user()->email));

        return new EventResource($event);
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

        return new EventResource($event);
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

        if(!$event && $request->method() === "PUT") {
            // create new event 
            $event = Event::firstOrNew($request->all());
            $event->save();
        }
        else {
            if ($request->has('name')) { $event->name = $request->name; }
            if ($request->has('slug')) { $event->slug = $request->slug; }
            if ($request->has('startAt')) { $event->startAt = $request->startAt; }
            if ($request->has('endAt')) { $event->endAt = $request->endAt; }

            $event->save();
            
            Redis::del('event_' . $id);
            Redis::set('event_' . $id, $event);
        }

        return new EventResource($event);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Event::where('id', $id)->delete();

        Redis::del('event_' . $id);

        return response()->json(null, 204);
    }
}
