<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Venue;
use App\User;
use App\Event;

class VenueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $venues = Venue::all();
        foreach ($venues as $index=>$venue) {
          $user = User::find($venue['user_id']);
          $venues[$index]['socialLinks'] = $user->socialLinks;
        }
        return $venues;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('venues.create');
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
          'address' => 'required',
          'city' => 'required',
        ]);
        $venue = Venue::create($attributes);
        $user = User::find($request['id']);
        $user->venue()->save($venue);
        $user_id = $user['id'];
        return view('socialLinks.create', compact('user_id'));

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
        $venue = Venue::find($id);
        return response()->json(compact('venue'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Venue $venue)
    {
        //
        $socialLinks = User::find($venue->user['id'])->socialLinks;
        $platforms = config('enums.platforms');
        return view('venues.edit', compact('venue', 'socialLinks', 'platforms'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        //
        $venue = Venue::find($id);
        $user = $venue->user;
        if ($user->id !== request('user')->id):
          return response()->json(['status' => 'unauthorized'], 401);
        endif;
        $venue->update(request(['name', 'address', 'city', 'description']));
        return response()->json(['status'=> 'success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Venue $venue)
    {
        //
        $venue->delete();
        return redirect('/venues');
    }
}
