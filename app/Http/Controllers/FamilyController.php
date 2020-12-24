<?php

namespace App\Http\Controllers;

use App\Family;
use App\Performer;
use App\User;
use App\SocialLinks;
use Illuminate\Http\Request;

class FamilyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $families = Family::all();
		foreach ($families as $index=>$family):
			$families[$index]['social_links'] = $family->socialLinks;
			$families[$index]['performers'] = $family->performers;
        endforeach;
        return response()->json($families, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        return view('families.create');
    }

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
    
    public function updateSocialLinks($request) {
		$socialLinks = SocialLinks::find(request('socialLinksId'));
		$socialLinks->update(request(['facebook', 'instagram', 'tiktok','twitter','twitch', 'website', 'youtube']));
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
        ]);
        $family = Family::create($attributes);
        $family->socialLinks()->save($socialLinks);
		$user = User::find($request['user']->id);
		if ($user) {
			$user->families()->save($family);
        }
        $performers = Performer::find(request('performers'));
        if (!empty($performers)) {
            foreach ($performers as $performer) {
                $family->performers()->attach($performer);
            }

        }

        return response()->json(['status' => 'success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Family  $family
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $family = Family::find($id);
        $performers = $family->performers;
        $socialLinks = $family->socialLinks;
        return response()->json(compact('family', 'performers', 'socialLinks'), 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Family  $family
     * @return \Illuminate\Http\Response
     */
    public function edit(Family $family)
    {
        //
        $socialLinks = $family->socialLinks;
        $allPerformers = Performer::all();
        $familyPerformers = $family->performers;
        $platforms = config('enums.platforms');
        return view('families.edit', compact('allPerformers', 'familyPerformers', 'family', 'socialLinks', 'platforms'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Family  $family
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        //
        $family = Family::find($id);
        $this->updateSocialLinks(request());
        $user = request('user');
        $family->performers()->detach();
        if ($user['id'] === $family['user_id']):
            $family->update(request(['name', 'description']));
            foreach (request('performers') as $performerId):
                $performer = Performer::find($performerId);
                $family->performers()->attach($performer);
            endforeach;
			return response()->json(['status' => 'success'], 200);
        endif;
        return response()->json(['message' => 'unauthorized'], 405);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Family  $family
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $family = Family::find($id);
        $family->delete();
        return response()->json(['status' => 'success'], 200);
    }

    public function performer($id) {
		$family = Family::find($id);
		$request_performer = request('performer');
		$performer = Performer::find($request_performer['id']);
		$user = request('user');
		if (intval($family['user_id']) === intval($user['id'])):
			$family->performers()->save($performer);
			return response()->json(['status' => 'success'], 200);
		endif;
		return response()->json(['message' => 'unauthorized user'], 401);
    }

    public function performerDestroy($id) {
		$performer = Performer::find($id);
		$family = $performer->family;
		$user = request('user');
		if (intval($family['user_id']) === intval($user['id'])):
			$performer->family()->dissociate();
			$performer->save();
			return response()->json(['status' => 'success'], 200);
		endif;
	return response()->json(['message' => 'unauthorized user'], 401);

    }
}
