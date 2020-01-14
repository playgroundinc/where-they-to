<?php

namespace App\Http\Controllers;

use App\Event;
use App\Performer;
use App\Venue;
use App\Family;

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
        return view('events.create', compact('performers', 'families', 'venues'));
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
          'name' => 'required',
          'description' => 'required',
          'date' => 'required',
          'type' => 'required'
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
        return view('events.edit', compact('event', 'venues', 'performers', 'families'));
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
    }
}
