@extends('layout')

@section('content')
  <h1>{{ $event->name }}</h1>
  <h2>Date</h2>
  <p>{{ $event->date }}</p>
  <h2>Description</h2>
  <p>{{ $event->description }}</p>
  <h2>Type</h2>
  <p>{{ $event->eventType->name }}</p>
  <h2>Family</h2>
  <a href="/families/{{$event->family->id}}">{{ $event->family->name }}</a>
  <h2>Performers</h2>
  <ul>
    @foreach($event->performers as $performer) 
      <li><a href="/performers/{{$performer->id}}">{{ $performer->name }}</a></li>
    @endforeach   
  </ul>
  <h2>Venue</h2>
  <a href="/venues/{{$event->venue->id}}">{{ $event->venue->name }}</a>
  <h2>Social Links</h2>
  <ul>
    @foreach($platforms as $index=>$platform) 
      @if (isset($event->socialLinks[$index]) && strlen($event->socialLinks[$index]) > 0)
        <li>{{ $platform }} : {{ $event->socialLinks[$index] }} </li>
      @endif
    @endforeach
  </ul>
  <a href="/events/{{$event->id}}/edit">Edit Event</a>
@endsection