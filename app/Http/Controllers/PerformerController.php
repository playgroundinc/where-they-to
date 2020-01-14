<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Performer;
use App\User;
use App\Family;
use App\Event;

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
        return view('performers.index', compact('performers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        return view('performers.create');
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
          'bio' => 'required',
        ]);
        $performer = Performer::create($attributes);
        $user = User::find($request['id']);
        $user->performer()->save($performer);
        return view('socialLinks.create', ['user_id' => $user['id']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Performer $performer)
    {
        //
        $socialLinks = User::find($performer->user['id'])->socialLinks;
        $platforms = [
          'facebook',
          'twitter',
          'instagram',
          'youtube',
          'website',
        ];
        $family = Family::find($performer->family_id);
        return view('performers.show', compact('performer', 'socialLinks', 'platforms', 'family'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Performer $performer)
    {
        //
        $socialLinks = User::find($performer->user['id'])->socialLinks;
        $platforms = [
          'facebook',
          'twitter',
          'instagram',
          'youtube',
          'website',
        ];
        return view('performers.edit', compact('performer', 'socialLinks', 'platforms'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Performer $performer)
    {
        //
        $performer->update(request(['name', 'bio']));
        return redirect('/performers/'.$performer->id);
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
    }
}
