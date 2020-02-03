<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket;

class TicketController extends Controller
{
    //
    public function index() {
      $tickets = Ticket::all();
      return response()->json($tickets);
    }

    public function store() {
      $attributes = request()->validate([
        'description' => 'required',
        'price' => 'required',
        'url' => 'nullable'
      ]);
      $ticket = Ticket::create($attributes);
      return response()->json([$ticket], 200);
    }
}
