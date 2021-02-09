<?php

namespace App\Http\Controllers;

use App\Update;

use App\Performer;
use App\Venue;
use App\Family;
use App\Event;
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
        break;
        case 'family': 
          $family = Family::find($id);
          $family->updates()->save($update);
        break;
        case 'venue': 
          $venue = Venue::find($id);
          $venue->updates()->save($update);
        break;
        case 'event': 
          $event = Event::find($id);
          $event->updates()->save($update);
        break;
        return response()->json(array('status' => 'success'));
      }
    }
    public function index($type, $id) {
      switch($type) {
        case 'performer':
          $performer = Performer::find($id);
          $updates = $performer->updates;
        break;
        case 'family': 
          $family = Family::find($id);
          $updates = $family->updates;
        break;
        case 'venue': 
          $venue = Venue::find($id);
          $updates = $venue->updates;
        break;
        case 'event': 
          $event = Event::find($id);
          $updates = $event->updates;
        break;
        default:
          $updates = array();
        break;
      }
      return response()->json(compact('updates'));
    }
}
