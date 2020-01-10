<?php

namespace App\Http\Controllers;

use App\SocialLinks;
use App\User;
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
        $user = User::find($request['id']);
        $user->socialLinks()->save($socialLinks);
        return redirect('/users');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SocialLinks  $socialLinks
     * @return \Illuminate\Http\Response
     */
    public function show(SocialLinks $socialLinks)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SocialLinks  $socialLinks
     * @return \Illuminate\Http\Response
     */
    public function edit(SocialLinks $socialLinks)
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
    public function update(Request $request, SocialLinks $socialLinks)
    {
        //
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
