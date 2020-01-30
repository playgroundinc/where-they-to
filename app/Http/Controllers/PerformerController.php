<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Performer;
use App\User;
use App\Family;
use App\Event;
use App\PerformerType;

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
        return $performers;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $performerTypes = PerformerType::all();
        return view('performers.create', compact('performerTypes'));
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
        
        $performerType = PerformerType::find($request['performerType']);
        $performer->performerTypes()->attach($performerType);
      
        $user = User::find($request['id']);
        $user->performer()->save($performer);

        return response()->json(['status' => 'success'], 201);
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
        $performer = Performer::find($id);
        $user = User::find($performer->user['id']);
        $socialLinks = array();
        if (isset($user)) {
          $socialLinks = $user->socialLinks;
        }
        $platforms = config('enums.platforms');
        $family = Family::find($performer->family_id);
        $type = $performer->performerTypes;
        return response()->json(compact('performer', 'type', 'family', 'socialLinks'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $performer = Performer::find($id);
        $socialLinks = User::find($performer->user['id'])->socialLinks;
        $performerTypes = PerformerType::all(); 
        $platforms = config('enums.platforms');
        return view('performers.edit', compact('performer', 'socialLinks', 'platforms', 'performerTypes'));
        
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
        $performer = Performer::find($id);
        $performer->update(request(['name', 'bio']));
        $performer->performerTypes()->detach();
        foreach (request('performerType') as $performerTypeId):
          $performerType = PerformerType::find($performerTypeId);
          $performer->performerTypes()->attach($performerType);
        endforeach;
        return response()->json(['status'=>'success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Performer $performer)
    {
        //
        $performer->performerTypes()->detach();
        $performer->events()->detach();
        $performer->delete();
        return redirect('/performers');
    }
}