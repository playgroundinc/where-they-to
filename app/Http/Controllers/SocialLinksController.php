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
        return view('socialLinks.create', compact('user_id'));
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
          $user = User::find($request['user_id']);
          $user->socialLinks()->save($socialLinks);
        } elseif ($request['family_id']) {
          $family = Family::find($request['family_id']);
          $family->socialLinks()->save($socialLinks);
        }
        return response()->json(['status' => 'success'], 201);

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
        $socialLink = SocialLinks::find($id);
        $socialLink->update(request(['facebook', 'instagram', 'website', 'youtube', 'twitter']));
        return response()->json(['status' => 'success'], 200);
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
