<?php

namespace App\Http\Controllers;

use App\Family;
use App\Performer;
use App\User;
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
			$families[$index]['socialLinks'] = $family->socialLinks;
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
        ]);
        $family = Family::create($attributes);
		$user = User::find($request['user']->id);
		if ($user) {
			$user->families()->save($family);
		}
        $performers = request('performers');
        foreach ($performers as $performer):
			$newPerformer = Performer::find($performer['id']);
			$family->performers()->save($newPerformer);
        endforeach;
        return response()->json(['status' => 'success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Family  $family
     * @return \Illuminate\Http\Response
     */
    public function show(Family $family)
    {
        //
        $performers = $family->performers;
        $socialLinks = $family->socialLinks;
        $platforms = config('enums.platforms');
        return view('families.show', compact('family', 'performers', 'socialLinks', 'platforms'));
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
        $user = request('user');
        if ($user['id'] === $family['user_id']):
			$family->update(request(['name', 'description']));
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
        $user = request('user');
        $userPerformer = $user->performer;
        if ($userPerformer['family_id'] === $family['id']):
			$performers = $family->performers;
			foreach($performers as $performer) {
				$performer->family_id = null;
				$performer->save();
			}
			$family->delete();
			return response()->json(['status' => 'success'], 200);
        endif;
        return response()->json(['status' => 'unauthorized'], 401);
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
