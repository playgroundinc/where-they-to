<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Venue;
use App\User;
use App\Event;
use App\SocialLinks;

class VenueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
		$venues = Venue::all();
		// foreach ($venues as $index=>$venue) {
		// 	$venues[$index]['social_links'] = $venue->socialLinks;
		// }
        return $venues;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('venues.create');
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
            'name' => 'required',
            'description' => 'required',
            'address' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
        ]);
		$venue = Venue::create($attributes);
		$venue->socialLinks()->save($socialLinks);
        $user = User::find($request['user']->id);
        $user->venues()->save($venue);
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
        //
        $venue = Venue::find($id);
        return response()->json(compact('venue'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Venue $venue)
    {
        //
        $socialLinks = User::find($venue->user['id'])->socialLinks;
        $platforms = config('enums.platforms');
        return view('venues.edit', compact('venue', 'socialLinks', 'platforms'));
	}
	
	public function updateSocialLinks($request) {
		$socialLinks = SocialLinks::find(request('socialLinksId'));
		$socialLinks->update(request(['facebook', 'instagram', 'twitter', 'website', 'youtube']));
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
		//
		$this->updateSocialLinks(request());
		$venue = Venue::find($id);
        $user = $venue->user;
        if ($user->id !== request('user')->id):
			return response()->json(['status' => 'unauthorized'], 401);
        endif;
		$venue->update(request(['name', 'address', 'city', 'description']));
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
}
