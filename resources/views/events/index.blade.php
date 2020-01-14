@extends('layout')

@section('content')
  <h1>Events</h1>
  <ul>
    @foreach ($events as $event)
      <li>
        <a href="/events/{{ $event->id }}">{{ $event->name }}</a>
      </li>
    @endforeach
  </ul>
  <a href="/events/create">Create an event</a>
@endsection