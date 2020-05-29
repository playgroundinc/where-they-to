<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use App\Event;
use App\Performer;
use App\Venue;
use App\Family;
use App\EventType;
use App\SocialLinks;

use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private function saveFields($request, $event) {
        if ($request['venue']):
			$venue = Venue::find($request['venue']);
			if ($venue) {
				$venue->events()->save($event);
			}
        endif;
        if ($request['family']):
			$family = Family::find($request['family']);
			if ($family) {
				$family->events()->save($event);
			}
        endif;
        if ($request['eventType']):
			$eventType = EventType::find($request['eventType']);
			if ($eventType) {
				$eventType->events()->save($event);
			}
        endif;
        if ($request['performers']):
			$performers = Performer::find(request('performers'));
			$event->performers()->detach();
			foreach($performers as $performer):
				$event->performers()->attach($performer);
			endforeach;
        endif;
        
    }

    private function updateFields($request, $event) {

    }
    public function index()
    {
        //
        $events = Event::all();
        foreach($events as $index=>$event):
			$events[$index]['performers'] = $event->performers;
			$events[$index]['social_links'] = $event->socialLinks;
        endforeach;
        return $events;
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
	
	public function createSocialLinks($request) {
		$attributes = $request->validate([
			'facebook' => 'nullable',
			'twitter' => 'nullable',
			'instagram' => 'nullable',
			'website' => 'nullable',
			'youtube' => 'nullable',
		]);
		$socialLinks = SocialLinks::create($attributes);
		return $socialLinks;
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
		$socialLinks = $this->createSocialLinks($request);
        $attributes = request()->validate([
			'time' => 'nullable',
			'name' => 'required',
			'description' => 'required',
			'timezone' => 'nullable',
			'tickets' => 'nullable',
			'tickets_url' => 'nullable'
        ]);
        $date = Carbon::parse(request('date'));

        $event = Event::create($attributes);
        $event->date = $date;
        $event->save();
        $user = request('user');
        // return response()->json($user);
        $user->events()->save($event);
		$this->saveFields(request(), $event);
		$event->socialLinks()->save($socialLinks);
        return response()->json(['status'=> 'success'], 200);
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
    public function update($id)
    {
        //
        $event = Event::find($id);
        $user = $event->user;
        $validatedUser = request('user');
        if ($user['id'] === $validatedUser['id']):
          $event->update(request([
            'name',
            'description',
            'date',
            'type',
            'tickets', 
            'tickets_url'
          ]));
          $this->saveFields(request(), $event);
          return response()->json(['status' => 'success'], 200);
        endif;
        return response()->json(['status' => 'unauthorized'], 401);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $event = Event::find($id);
        $user = $event->user;
        $validatedUser = request('user');
        if ($user['id'] === $validatedUser['id']):
          $event->performers()->detach();
          $event->delete();
          return response()->json(['status' => 'success'], 200);
        endif; 
        return response()->json(['status' => 'unauthorized'], 401);
    }

    public function addPerformer($id) 
    {
      $performer = Performer::find(request('performer'));
      $event = Event::find($id);
      $performer->events()->attach($event);
      return response()->json(['status' => 'success'], 200);
    }

    public function deletePerformer($id) 
    {
      $performer = Performer::find(request('performer'));
      $event = Event::find($id);
      $event->performers()->detach($performer);
      return response()->json(['status' => 'success'], 200);
    }

    public function date($date) {
      $today = Carbon::parse($date);
      $events = Event::where('date', '=', $date)
        ->get()
        ->toJSON();
      $date = Carbon::parse($date)->format('F j');
      return response()->json(['events' => $events, 'date' => $date]);
    }

    public function week($date) {
      $today = Carbon::parse($date);
      $thisWeek = $today->addDays(6);
      $events = Event::where('date', '>=', $date)
        ->where('date', '<=', $thisWeek)
        ->get()
        ->toJSON();
      return response($events);
    }
}
