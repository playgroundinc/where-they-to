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
   * 
   * */
	public function index() 
    {
		//
        $performers = Performer::all();
        return response()->json($performers, 200);
    }

	public function createSocialLinks($request) {
		$attributes = $request->validate([
			'facebook' => 'nullable',
            'twitter' => 'nullable',
            'tiktok' => 'nullable',
            'twitch' => 'nullable',
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
            'bio' => 'required',
			'tips' => 'nullable',
			'accent_color' => 'nullable',
        ]);
        $performer = Performer::create($attributes);
        if ($request['performerTypes']) {
			$types = PerformerType::find($request['performerTypes']);
			$performer->performerTypes()->detach();
			foreach ($types as $type) {
				$performer->performerTypes()->attach($type);
			}
        }
		$performer->socialLinks()->save($socialLinks);

        $user = User::find($request['user_id']);

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
        $socialLinks = $performer->socialLinks;
        $family = Family::find($performer->family_id);
        $types = $performer->performerTypes;
        return response()->json(compact('performer', 'types', 'family', 'socialLinks'));
    }

	public function updateSocialLinks($request) {
		$socialLinks = SocialLinks::find(request('socialLinksId'));
		$socialLinks->update(request(['facebook', 'instagram', 'tiktok','twitter','twitch', 'website', 'youtube']));
	}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		//
		$this->updateSocialLinks(request());
		$performer = Performer::find($id);
        $user = $performer->user;
        if ($user->id !== request('user_id')):
			return response()->json(['status' => 'unauthorized'], 401);
        endif;
        $performer->update(request(['name', 'bio', 'tips', 'accent_color']));
        $performer->performerTypes()->detach();
        foreach (request('performerTypes') as $performerTypeId):
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

    public function buildQuery($query, $request, $params) {
        foreach($params as $param) {
            $field = $request->query($param, false);
            if ($field) {
                switch ($param) {

                    case 'performerTypes':
                        $field = explode(',', $field);
                        $query = $query->whereHas($param, function($q) use ($field) {
                            $q->whereIn('performer_type_id', $field );
                        });
                    break;
                    case 'performers': 
                        $field = explode(',', $field);
                        $query = $query->whereHas($param, function($q) use ($field) {
                            $q->whereIn('name', $field );
                        });
                    break;
                    default:
                        $query = $query->whereHas($param, function($q) use ($field) {
                            $q->where('name', $field );
                        });
                    break;
                }
            }
        }
        return $query;
    }

    /**
     * Search for performers by name.
     * 
     * @param string $search_term.
     */
    public function search($term) {
        $request = request();
        $query = Performer::query();
        if ($term !== '*') {
            $query = $query->where('name', 'LIKE', '%' . $term . '%');
        }
        $params = array('performerTypes', 'families');
        $offset = $request->query('offset', 10);
        $query = $this->buildQuery($query, $request, $params);
        $performers = $query->take($offset)->get();
        if (!empty($performers)) {
            return response()->json($performers, 200);
        }
        return response()->json([], 200);
    }

    /**
     * Search for performers by name.
     * 
     * @param string $search_term.
     */
    public function getNames() {
        $performer_ids = request();
        return response()->json(['ids' => $performer_ids], 200);
        $performers = Performer::find($performer_ids);
        return response()->json(compact('performers'), 200);
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
        if ($user->id !== request('user_id')):
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