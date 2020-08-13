<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;

use App\Performer;
use App\User;
use App\Family;
use App\Event;
use App\Venue;
use App\PerformerType;
use App\SocialLinks;

class PerformerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() 
    {
        //
        $performers = Performer::all();
        foreach ($performers as $index=>$performer) {
			$user = User::find($performer['user_id']);
			if (isset($user)) {
				$performers[$index]['socialLinks'] = $performer->socialLinks;
			}
			$performers[$index]['type'] = $performer->performerTypes;
        }
        return response()->json($performers, 200);
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $performerTypes = PerformerType::all();
        return view('performers.create', compact('performerTypes'));
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
			'bio' => 'required',
        ]);
        $performer = Performer::create($attributes);
        if ($request['performerType']) {
			$types = PerformerType::find($request['performerType']);
			if ($types) {
				$performer->performerTypes()->detach();
				foreach ($types as $type) {
					$performer->performerTypes()->attach($type);
				}
			}
        }
		$performer->socialLinks()->save($socialLinks);
        $user = User::find($request['user']->id);

        if ($user) {
			$user->performers()->save($performer);
        }

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
        $performer = Performer::find($id);
        $user = User::find($performer->user['id']);
        $socialLinks = array();
        if (isset($user)) {
			$socialLinks = $user->socialLinks;
        }
        $platforms = config('enums.platforms');
        $family = Family::find($performer->family_id);
        $type = $performer->performerTypes;
        return response()->json(compact('performer', 'type', 'family', 'socialLinks'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $performer = Performer::find($id);
        $socialLinks = User::find($performer->user['id'])->socialLinks;
        $performerTypes = PerformerType::all(); 
        $platforms = config('enums.platforms');
        return view('performers.edit', compact('performer', 'socialLinks', 'platforms', 'performerTypes'));
        
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
		$performer = Performer::find($id);
        $user = $performer->user;
        if ($user->id !== request('user')->id):
			return response()->json(['status' => 'unauthorized'], 401);
        endif;
        $performer->update(request(['name', 'bio']));
        $performer->performerTypes()->detach();
        foreach (request('performerType') as $performerTypeId):
			$performerType = PerformerType::find($performerTypeId);
			$performer->performerTypes()->attach($performerType);
        endforeach;
        return response()->json(['status'=>'success'], 200);
	}

    public function addType($id) {
		$performer = Performer::find($id);
		$performerType = PerformerType::find(request('performerType_id'));
		$performer->performerTypes()->attach($performerType);
		return response()->json(['status'=>'success'], 200);
    }

    public function removeType($id) {
		$performer = Performer::find($id);
		$performerType = PerformerType::find(request('performerType_id'));
		$performer->performerTypes()->detach($performerType);
		return response()->json(['status'=>'success'], 200);
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
        $performer = Performer::find($id);
        $user = $performer->user;
        if ($user->id !== request('user')->id):
			return response()->json(['status' => 'unauthorized'], 401);
        endif;
        $performer->performerTypes()->detach();
        $performer->events()->detach();
        $performer->delete();
        return response()->json(['status' => 'success'], 200);
	}

	public function events($id) {
		$performer = Performer::find($id);
		$events = $performer->events;
		$events = array_map(function($event) {
			$date = Carbon::parse($event['date']);
			$event['date'] = $date->format('F d Y');
			$venue = Venue::find($event['venue_id']);
			$event['venue'] = $venue;
			return $event;
		}, $events->toArray());
		return response()->json(['events' => $events]);
    }
}