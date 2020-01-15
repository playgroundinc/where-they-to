<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use App\Event;
use App\Performer;
use App\Venue;
use App\Family;
use App\EventType;

use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private function saveFields($request, $event) {
        $venue = Venue::find($request['venue']);
        $venue->events()->save($event);

        $family = Family::find($request['family']);
        $family->events()->save($event);

        $eventType = EventType::find($request['eventType']);
        $eventType->events()->save($event);

        $performers = Performer::find(request('performers'));
        $event->performers()->detach();
        foreach($performers as $performer):
          $event->performers()->attach($performer);
        endforeach;
    }

    private function updateFields($request, $event) {

    }
    public function index()
    {
        //
        $events = Event::all();
        return view('events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $performers = Performer::all();
        $families = Family::all();
        $venues = Venue::all();
        $eventTypes = EventType::all();
        return view('events.create', compact('performers', 'families', 'venues', 'eventTypes'));
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
        $attributes = request()->validate([
          'date' => 'required',
          'time' => 'required',
          'name' => 'required',
          'description' => 'required',
        ]);

        $event = Event::create($attributes);
        $this->saveFields($request, $event);
        
        $platforms = config('enums.platforms');
        return view('events.show', compact('event', 'platforms'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        //
        $event->date = Carbon::parse($event->date.' '.$event->time)->format('M d, Y @ h:i A');
        $platforms = config('enums.platforms');
        return view('events.show', compact('event', 'platforms'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        //
        $venues = Venue::all();
        $performers = Performer::all();
        $families = Family::all();
        $eventTypes = EventType::all();
        return view('events.edit', compact('event', 'venues', 'performers', 'families', 'eventTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        //
        $event->update(request([
          'name',
          'description',
          'date',
          'type'
        ]));
        $this->saveFields($request, $event);
        return redirect('/events/'.$event->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        //
        $event->performers()->detach();
        $event->delete();
        return redirect('/events');
    }
}
