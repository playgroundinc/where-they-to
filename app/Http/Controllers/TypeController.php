<?php

namespace App\Http\Controllers;

use App\EventType;
use App\PerformerType;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $eventTypes = EventType::all();
        $performerTypes = PerformerType::all();
        return view('types.index', compact('eventTypes', 'performerTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      //
        return view('types.create');
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
            'name' => 'required'
        ]);
        $newType;
        if ($request['type'] === 'performer'):
            $newType = PerformerType::create($attributes);
        elseif ($request['type'] === 'event'):
            $newType = EventType::create($attributes);
        endif;

        return response()->json(array('addition' => $newType), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PerformerType  $performerType
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        return redirect('/types');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PerformerType  $performerType
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        return redirect('/types');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PerformerType  $performerType
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        //
        $postType = request('type');
        if ($postType === 'event'):
            $type = EventType::find($id);
        else: 
            $type = PerformerType::find($id);
        endif;
        $type->update(['name'=>request('name')]);
        return redirect('/types');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PerformerType  $performerType
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        if (request('type') === 'event'):
            $type = EventType::find($id);
        elseif (request('type') === 'performer'): 
            $type = PerformerType::find($id);
            $type->performers()->detach();
        endif;
        $type->delete();
        return redirect('/types');

    }
    
    public function performerIndex() {
        $performerTypes = PerformerType::all();
        return response()->json($performerTypes, 200);
    }

    public function eventIndex() {
        $eventTypes = EventType::all();
        return response()->json($eventTypes, 200);
    }

    public function performerSearch($term) {
        if (empty($term)) {
            return response()->json([], 200);
        }
        $performerTypes = PerformerType::where('name','LIKE','%'.$term.'%')->take(10)->get();
        if (!empty($performerTypes)) {
            return response()->json($performerTypes, 200);
        }
        return response()->json([], 200);
    }

    public function eventSearch($term) {
        if (empty($term)) {
            return response()->json([], 200);
        }
        $eventTypes = EventType::where('name','LIKE','%'.$term.'%')->take(10)->get();
        if (!empty($eventTypes)) {
            return response()->json($eventTypes, 200);
        }
        return response()->json([], 200);
    }

    /**
     * Creates a new Event Type.
     * 
     * @param object $request the request object.
     */
    public function eventStore($request) {
        $attributes = request()->validate([
            'name' => 'required'
        ]);
        $newType = EventType::create($attributes);
        return response()->json(compact('newType'), 200);
    }

    /**
     * Create a new Performer Type tag.
     * 
     * @param object $request the request object.
     */
    public function performerStore($request) {
        $attributes = request()->validate([
            'name' => 'required'
        ]);
        $newType = PerformerType::create($attributes);
        return response()->json(compact('newType'), 200);
    }
}
