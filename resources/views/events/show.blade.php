@extends('layout')

@section('content')
  <h1>{{ $event->name }}</h1>
  <h2>Date</h2>
  <p>{{ $event->date }}</p>
  <h2>Description</h2>
  <p>{{ $event->description }}</p>
  @if (isset($event->eventType))
    <h2>Type</h2>
    <p>{{ $event->eventType->name }}</p>
  @endif
  <h2>Family</h2>
  <a href="/families/{{$event->family->id}}">{{ $event->family->name }}</a>
  @if (count($event->performers) > 0)
  <h2>Performers</h2>
  <ul>
    @foreach($event->performers as $performer) 
      <li><a href="/performers/{{$performer->id}}">{{ $performer->name }}</a></li>
    @endforeach   
  </ul>
  @endif
  @if (isset($event->venue))
  <div>
    <h2>Venue</h2>
    <a href="/venues/{{$event->venue->id}}">{{ $event->venue->name }}</a>
  </div>
  @endif
  @if (!empty($event->socialLinks))
  <h2>Social Links</h2>
  <ul>
    @foreach($platforms as $index=>$platform) 
      @if (isset($event->socialLinks[$index]) && strlen($event->socialLinks[$index]) > 0)
        <li>{{ $platform }} : {{ $event->socialLinks[$index] }} </li>
      @endif
    @endforeach
  </ul>
  @endif
  <div>
    <h2>Tickets</h2>
      @foreach ($event->tickets as $ticket)
        <p>${{ $ticket->price }} - {{ $ticket->description }}</p>
        @if(isset($ticket->url))
          <a href="{{ $ticket->url }}">Ticket Link</a>
        @endif
      @endforeach
  </div>
  <a class="btn" href="/events/{{$event->id}}/edit">Edit Event</a>

@endsection