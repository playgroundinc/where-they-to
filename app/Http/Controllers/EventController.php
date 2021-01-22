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
		// If existing venue has been provided, save to Event.
		// Otherwise add city, address, and province separately.
        if ($request['venue_id']) {
			$venue = Venue::find($request['venue_id']);
			if ($venue) {
				$venue->events()->save($event);
			}
		} else {
			$event->address = $request['address'];
			$event->city = $request['city'];
			$event->province = $request['province'];
			$event->save();
		}
		// If family has been provided, attach to event.
        if (!empty($request['family_id'])) {
			$family = Family::find($request['family_id']);
			if ($family) {
				$family->events()->save($event);
			}
		}
		// If event has defined types, add to event.
        if (!empty($request['eventTypes'])) {
			$eventTypes = EventType::find($request['eventTypes']);
			$event->eventTypes()->detach();
			foreach ($eventTypes as $type) {
				$event->eventTypes()->attach($type);
			}
		}
		// If performers have been defined, add to
        if ($request['performers']):
			$performers = Performer::find(request('performers'));
			$event->performers()->detach();
			foreach($performers as $performer):
				$event->performers()->attach($performer);
			endforeach;
        endif;
        
    }
	/**
	 * Show all events.
	 */
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
	 * Create social links for current event.
	 * 
	 * @param object $request the request object from the initial POST.
	 */
	public function createSocialLinks($request) {
		// Validate all fields. 
		$attributes = $request->validate([
			'facebook' => 'nullable',
			'instagram' => 'nullable',
			'tiktok' => 'nullable',
			'twitch' => 'nullable',
			'twitter' => 'nullable',
			'website' => 'nullable',
			'youtube' => 'nullable',
		]);
		// Create social links and return.
		$socialLinks = SocialLinks::create($attributes);
		return $socialLinks;
	}

	/**
	 * Update existing social links.
	 * 
	 * @param object $request the request Object from the original POST.
	 */
	public function updateSocialLinks($request) {
		$socialLinks = SocialLinks::find(request('socialLinksId'));
		$socialLinks->update(request(['facebook', 'instagram', 'twitter', 'website', 'youtube']));
	}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		// Create social links.
		$socialLinks = $this->createSocialLinks($request);
		// Valiate all fields.
        $attributes = request()->validate([
			'show_time' => 'nullable',
			'name' => 'required',
			'doors' => 'nullable',
			'description' => 'required',
			'timezone' => 'nullable',
			'tickets' => 'nullable',
			'tickets_url' => 'nullable'
		]);
		// Use Carbon to parse and format date.
        $date = Carbon::parse(request('date'));
        $event = Event::create($attributes);
        $event->date = $date;
        $event->save();
		// Find the user.
		$user = request('user');
		// Save the event to the user.
		$user->events()->save($event);
		// Save most other fields.
		$this->saveFields(request(), $event);
		// Save the social links.
		$event->socialLinks()->save($socialLinks);
		// Return a success message.
        return response()->json(['status'=> 'success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Find event by ID.
		$event = Event::find($id);
		// Parse the date.
		$event_date = Carbon::parse($event['date']);
		// Format the date.
		$event->date = $event_date->format('M d, Y');
		// Find the social links.
		$socialLinks = $event->socialLinks;
		// Find the family.
		$family = $event->family;
		// Find the venue.
		$venue = $event->venue;
		// Find the performers.
		$performers = $event->performers;
		// Find the event types.
		$eventTypes = $event->eventTypes;
		// Return all of these fields.
        return response()->json(compact('event', 'socialLinks', 'family', 'venue', 'performers', 'eventTypes'), 200);
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
		// Update the social links.
		$this->updateSocialLinks(request());
		// Find the event.
		$event = Event::find($id);
		// Find the user attached to the event.
		$user = $event->user;
		$validatedUser = request('user');
		// Check that user attached to request is also the user stored in the system.
        if ($user['id'] === $validatedUser['id']):
			$event->update(request([
				'name',
				'address',
				'city',
				'doors',
				'province',
				'timezone',
				'description',
				'show_time',
				'tickets',
				'tickets_url'
			]));

			// Save the fields.
			$this->saveFields(request(), $event);
			// Parse the date.
			$date = Carbon::parse(request('date'));
			// Update the date.
			$event->date = $date;
			$event->save();
			return response()->json(['status' => 'success'], 200);
		endif;
		// If users don't match, return unauthorized.
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
        // Find event by ID.
        $event = Event::find($id);
        $user = $event->user;
		$validatedUser = request('user');
		// Check that user from request owns this event.
        if ($user['id'] === $validatedUser['id']) {
			$event->performers()->detach();
			$event->delete();
			return response()->json(['status' => 'success'], 200);
		}
		// If user does not own this event, return unauthorized. 
        return response()->json(['status' => 'unauthorized'], 401);
    }

	/**
	 * Pull events by specific date.
	 * 
	 * @param string $date the date to be queried.
	 */
    public function date($date) {
		// Parse the date.
		$today = Carbon::parse($date);
		// Find events on this date.
		$events = Event::where('date', '=', $date)
        ->get()
		->toJSON();
		// Parse the date and format it.
		$date = Carbon::parse($date)->format('F j');
		return response()->json(['events' => $events, 'date' => $date]);
	}
	
	/**
	 * Pull events by specific week.
	 * 
	 * @param string $date the first day of the week in question.
	 */
    public function week($date) {
		// Parse the date.
		$today = Carbon::parse($date);
		// Add six days to account for the week.
		$thisWeek = $today->addDays(6);
		$events = Event::where('date', '>=', $date)
        ->where('date', '<=', $thisWeek)
        ->get()
		->toJSON();
		// Return any events found.
		return response()->json(['events' => $events]);
    }
}
