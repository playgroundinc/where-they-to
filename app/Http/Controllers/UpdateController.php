<?php

namespace App\Http\Controllers;

use App\Performer;
use App\Update;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    //
    public function store(Request $request) {
      $attributes = request()->validate([
        'update' => 'required',
      ]);
      $update = Update::create($attributes);
      $type = request('type');
      $id = request('id');
      switch($type) {
        case 'performer': 
          $performer = Performer::find($id);
          $performer->updates()->save($update);
          return response()->json(compact('performer'));
        break;
      }
    }
}
