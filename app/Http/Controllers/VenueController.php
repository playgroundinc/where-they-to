<?php

namespace App\Http\Controllers;

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
			'accent_color' => 'nullable',
			'accessibility' => 'nullable',
			'accessibility_description' => 'nullable',
		]);
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    { 
        // Finds venue by the id.
		$venue = Venue::find($id);
		// Pulls the associated social links.
		$socialLinks = $venue->socialLinks;
		// Returns venue and socialLinks as data.
        return response()->json(compact('venue', 'socialLinks'));
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

	/**
	 * Search for a venue by a search term.
	 * 
	 * @param string $term the search term.
	 * @return array $venue either the matching venues or an empty array.
	 */
    public function search($term) {
		// If term is empty, return empty array.
        if (empty($term)) {
            return response()->json([], 200);
		}
		// Searches for venue by name.
		// Caps at 10 items to keep autocomplete manageable.
		$venues = Venue::where('name','LIKE','%'.$term.'%')->take(10)->get();
		// As long as something is found, returns values.
        if (!empty($venues)) {
            return response()->json(compact('venues'), 200);
		}
		// If no venues found, returns empty array.
        return response()->json([], 200);
    }
}
