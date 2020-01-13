<?php

namespace App\Http\Controllers;

use App\SocialLinks;
use App\User;
use App\Family;
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
        return view('socialLinks.create');
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
          'facebook' => 'required',
          'twitter' => 'required',
          'instagram' => 'required',
          'website' => 'required',
          'youtube' => 'required',
        ]);
        $socialLinks = SocialLinks::create($attributes);
        if ($request['user_id']) {
          $user = User::find($request['id']);
          $user->socialLinks()->save($socialLinks);
          return redirect('/users');
        } elseif ($request['family_id']) {
          $family = Family::find($request['family_id']);
          $family->socialLinks()->save($socialLinks);
          return redirect('/families');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SocialLinks  $socialLinks
     * @return \Illuminate\Http\Response
     */
    public function show(SocialLinks $socialLink)
    {
        //

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
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SocialLinks  $socialLinks
     * @return \Illuminate\Http\Response
     */
    public function update(SocialLinks $socialLink)
    {
        //
        $socialLink->update(request(['facebook', 'instagram', 'website', 'youtube', 'twitter']));
        return redirect(request('redirect_to'));
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
    }
}
