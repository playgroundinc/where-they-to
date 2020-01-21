<?php

namespace App\Http\Controllers;

use App\Family;
use App\Performer;
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
        return $families;
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
        $family_id = $family->id;
        return view('socialLinks.create', compact('family_id'));
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
    public function update(Request $request, Family $family)
    {
        //
        $family->update(request(['name', 'description']));
        return redirect('/families/'.$family->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Family  $family
     * @return \Illuminate\Http\Response
     */
    public function destroy(Family $family)
    {
        //
        $performers = $family->performers;
        foreach($performers as $performer) {
          $performer->family_id = null;
          $performer->save();
        }
        $family->delete();
        return redirect('/families');
    }

    public function performer($id) {
      $family = Family::find($id);
      $performer = Performer::find(request('performer'));
      $family->performers()->save($performer);
      $allPerformers = Performer::all();
      $familyPerformers = Family::find($id)->performers;
      return redirect('/families/'.$family->id.'/edit')->with(compact('allPerformers', 'familyPerformers', 'family'));
    }
    public function performerDestroy($id) {
      $performer = Performer::find($id);
      $family_id = $performer->family_id;
      $performer->family_id = null;
      $performer->save();
      $allPerformers = Performer::all();
      $family = Family::find($family_id);
      $familyPerformers = $family->performers;
      return redirect('families/'.$family_id.'/edit')->with(compact('allPerformers', 'familyPerformers', 'family'));
    }
}
