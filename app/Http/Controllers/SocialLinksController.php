<?php

namespace App\Http\Controllers;

use App\SocialLinks;
use App\User;
use App\Family;
use App\Event;
use Illuminate\Http\Request;

class SocialLinksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $socialLinks = SocialLinks::all();
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
        return view('socialLinks.create', compact('user_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
		// 
		$authenticatedUser = request('user');
		$attributes = request()->validate([
			'facebook' => 'nullable',
			'twitter' => 'nullable',
			'instagram' => 'nullable',
			'website' => 'nullable',
			'youtube' => 'nullable',
		]);
		$socialLinks = SocialLinks::create($attributes);
		if (request('event_id')) {
			$event = Event::find(request('event_id'));
			$event->socialLinks()->save($socialLinks);
			return response()->json(['status' => 'success'], 201);
		}
		if (request('family_id')) {
			$family = Family::find(request('family_id'));
			$family->socialLinks()->save($socialLinks);
			return response()->json(['status' => 'success'], 201);
		} 
		if (request('user_id') && intval(request('user_id')) === intval($authenticatedUser['id'])) {
			$user = User::find(request('user_id'));
			$user->socialLinks()->save($socialLinks);
			return response()->json(['status' => 'success'], 201);
		} 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SocialLinks  $socialLinks
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $socialLinks = SocialLinks::find($id);
        return response()->json(compact('socialLinks'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SocialLinks  $socialLinks
     * @return \Illuminate\Http\Response
     */
    public function edit(SocialLinks $socialLink)
    {
        //
        return redirect('/');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SocialLinks  $socialLinks
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        //
        $socialLinks = SocialLinks::find($id);
        $user = $socialLinks->user;
        if (request('family_id')) {
          $userPerformer = request('user')->performer;
          if (intval($userPerformer['family_id']) === intval(request('family_id'))):
            $socialLinks->update(request(['facebook', 'instagram', 'website', 'youtube', 'twitter']));
            return response()->json(['message'=>'success'], 200);
          endif;
          return response()->json(['message' => 'unauthorized'], 401);
        }
        if (request('event_id')) {
          $event = Event::find(request('event_id'));
          $user = $event->user;
          $validatedUser = request('user');
          if ($user['id'] === $validatedUser['id']):
            $socialLinks->update(request(['facebook', 'instagram', 'website', 'youtube', 'twitter']));
            return response()->json(['message'=>'success'], 200);
          endif;
        }
        if (request('user_id') && $user->id === request('user')->id):
          $socialLinks->update(request(['facebook', 'instagram', 'website', 'youtube', 'twitter']));
          return response()->json(['status' => 'success'], 200);
        endif;
        return response()->json(['status' => 'unauthorized'], 401);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SocialLinks  $socialLinks
     * @return \Illuminate\Http\Response
     */
    public function destroy(SocialLinks $socialLinks)
    {
        //
        return  redirect('/');
    }
}
