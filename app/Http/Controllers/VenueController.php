<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Venue;
use App\User;
use App\Event;
use App\SocialLinks;

class VenueController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
		$venues = Venue::all();
        return $venues;
    }

	/**
	 * Create social links connected to venue.
	 * 
	 * @param object $request the request object from the POST to the store method.
	 */
	public function createSocialLinks($request) {
		$attributes = $request->validate([
            'facebook' => 'nullable',
            'twitch' => 'nullable',
            'twitter' => 'nullable',
            'tiktok' => 'nullable',
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
    public function store(Request $request) {
		$socialLinks = $this->createSocialLinks($request);
        $attributes = request()->validate([
            'name' => 'required',
            'description' => 'required',
            'address' => 'required',
            'country' => 'nullable',
            'province' => 'required',
            // city and timezone are nullable since it could be an online venue.
            'city' => 'nullable',
            'timezone' => 'nullable',
            'venue_name' => 'nullable',
            'accent_color' => 'nullable',
            'accessibility' => 'nullable',
            'accessibility_description' => 'nullable',
		]);
        $attributes['slug'] = $this->generateSlug($attributes['name']);
		// Create the venue.
		$venue = Venue::create($attributes);
		// Save the social links to the newly created venue.
		$venue->socialLinks()->save($socialLinks);
		// Find the user.
		$user = User::find($request['user']->id);
		// Attach the venue to the user.
		$user->venues()->save($venue);
		// Send back success message.
        return response()->json(['status' => 'success'], 201);
    }

    public function upcomingEvents($id, $page ) {
        $today = Carbon::today();
        $offset = intval($page) * 10;
        $events = array();
        $query = Event::query();
        $query = $query->where('date', '>=', $today)->whereHas('venue', function($q) use ($id) {
            $q->where('id', $id );
        });
        $events['total'] = $query->count();
        $events['current'] = $query->orderby('date')->skip($offset)->take(10)->get();
        $events['page'] = $page;
        return $events;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    { 
        // Finds venue by the id.
        $venue = Venue::where('slug', $slug)->first();
		// Pulls the associated social links.
		$socialLinks = $venue->socialLinks;
        $request = request();
        $page = $request->query('page', 0);
        $events = $this->upcomingEvents($venue['id'], $page);
		// Returns venue and socialLinks as data.
        return response()->json(compact('venue', 'socialLinks', 'events'));
	}
	
	/**
	 * Update Social Links connected to a specific venue.
	 * 
	 * @param object $request the request object.
	 */
	public function updateSocialLinks($request) {
		// Finds the current social links.
		$socialLinks = SocialLinks::find(request('socialLinksId'));
		// Updates its values.
		$socialLinks->update(request(['facebook', 'instagram', 'tiktok', 'twitter', 'twitch', 'website', 'youtube']));
	}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
		// Passes the POST request object to update social links.
		$this->updateSocialLinks(request());
		// Finds venue by id.
		$venue = Venue::find($id);
		// Findes user attached to venue.
		$user = $venue->user;
		// Confirms that request came from same user.
        if ($user->id !== request('user')->id) {
			return response()->json(['status' => 'unauthorized'], 401);
		}
		// As long as they match, update venue.
		$venue->update(request(['name', 'address', 'city', 'description', 'accent_color', 'accessibility', 'accessibility_description']));
		// Send success message.
        return response()->json(['status'=> 'success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $venue = Venue::find($id);
        $venue->delete();
        return response()->json(['status' => 'success'], 200);
    }

    public function buildQuery($query, $request, $params) {
        foreach($params as $param) {
            $field = $request->query($param, false);
            if ($field) {
                switch ($param) {
                    default: 
                        $query = $query->where($param, $field);
                    break;
                }
            }
        }
        return $query;
    }

    /**
     * Generates a slug for the families page.
     */
    private function generateSlug($name) {
        $slug = preg_replace('/[^A-Za-z0-9 ]/', '', $name);
        $slug = strtolower(str_replace(' ', '-', $name));
        $duplicate = true;
        $count = 1;
        while ($duplicate) {
            $venue = Venue::where('slug', $slug)->first(); 
            if (empty($venue)) {
                $duplicate = false;
            } else {
                $slug = $slug . '-' . $count;
                $count = $count + 1;
            }
        }
        return $slug;
    }

	/**
	 * Search for a venue by a search term.
	 * 
	 * @param string $term the search term.
	 * @return array $venue either the matching venues or an empty array.
	 */
    public function search($term) {
        $request = request();
        $query = Venue::query();
        if ($term !== '*') {
            $query = $query->where('name', 'LIKE', '%' . $term . '%');
        }
        $params = array('province', 'city');
        $page = $request->query('page', 0);
        $offset = $page * 10;
        $query = $this->buildQuery($query, $request, $params);
        $venues = array();
        $venues['total'] = $query->count();
        $venues['page'] = $page;
        $venues['current'] = $query->skip($offset)->take(10)->get();
        if (!empty($venues['current'])) {
            return response()->json($venues, 200);
        }
        return response()->json([], 200);
    }

    public function events($id) {
        $request = request();
        $page = $request->query('page', 0);
        $events = $this->upcomingEvents($id, $page);
        return response()->json($events);
    }
}
