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
    public function update($request)
    {
        //
        $socialLinks = SocialLinks::find(request('socialLinksId'));
        $socialLinks->update(request(['facebook', 'instagram', 'tiktok','twitter','twitch', 'website', 'youtube']));
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
