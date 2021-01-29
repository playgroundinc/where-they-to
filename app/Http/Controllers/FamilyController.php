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
	 * Create social links connected to the family.
	 * 
	 * @param object $request the request object.
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
	 * Update Social Links connected to family.
	 * 
	 * @param object $request the request object.
	 */
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
		// Create the social links.
		$socialLinks = $this->createSocialLinks($request);
		// Validae that required fields have been provided.
        $attributes = request()->validate([
			'name' => 'required',
			'description' => 'required',
			'accent_color' => 'nullable',
		]);
		// Create a family with these atttributes.
		$family = Family::create($attributes);
		// Attach social links to family.
		$family->socialLinks()->save($socialLinks);
		// Find user.
		$user = User::find($request['user']->id);
		// Attach family to user.
		if ($user) {
			$user->families()->save($family);
		}
		// Find and attach performers.
        $performers = Performer::find(request('performers'));
        if (!empty($performers)) {
            foreach ($performers as $performer) {
                $family->performers()->attach($performer);
            }

        }
		// Return a success message.
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
        // Find family by ID.
		$family = Family::find($id);
		// Get all performers in family.
		$performers = $family->performers;
		// Get all social links for family.
		$socialLinks = $family->socialLinks;
		// Return these variables.
        return response()->json(compact('family', 'performers', 'socialLinks'), 200);
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
        // Find the family by ID.
		$family = Family::find($id);
		// Update the attached social links.
		$this->updateSocialLinks(request());
		// Find the user.
		$user = request('user');
		// Since performers and families are many-to-many, detach and re-attach.
        $family->performers()->detach();
        if ($user['id'] === $family['user_id']) {
			$family->update(request(['name', 'description', 'accent_color']));
            foreach (request('performers') as $performerId):
                $performer = Performer::find($performerId);
                $family->performers()->attach($performer);
			endforeach;
			// Return a success message.
			return response()->json(['status' => 'success'], 200);
		}
		// If not the right user return an unauthorized message.
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
        // Find family by ID and delete.
        $family = Family::find($id);
        $family->delete();
        return response()->json(['status' => 'success'], 200);
    }
	/** 
	 * Search for a family by a search term.
	 * 
	 * @param string $term the term to be searched for.
	 */
	public function search($term) {
		// If no term has been provided return an empty array.
        if (empty($term)) {
            return response()->json([], 200);
		}
		// Search families for term.
		$families = Family::where('name','LIKE','%'.$term.'%')->take(10)->get();
		// Return  either results  or an empty array.
        if (!empty($families)) {
            return response()->json(compact('families'), 200);
        }
        return response()->json([], 200);
    }
}
