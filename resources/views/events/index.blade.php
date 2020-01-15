@extends('layout')

@section('content')
  <h1>Events</h1>
  <ul class="list">
    @foreach ($events as $event)
      <li class="list-item">
        <a class="list-link" href="/events/{{ $event->id }}">{{ $event->name }}</a>
      </li>
    @endforeach
  </ul>
  <a class="btn" href="/events/create">Create an event</a>
@endsection