@extends('layout')

@section('content')
  <div>
    <h1>{{ $user->username }}</h1>
    <p>{{ $user->email }}</p>
    <a class="btn" href="/users/{{$user->id}}/edit">Edit User Details</a>
  </div>
  <div>
    @if (isset($performer))
      <h2>{{ $performer->name }}</h2>
      <p> {{ $performer->bio}}</p>
      <a class="btn" href="/performers/{{ $performer->id }}/edit">Edit Performer Profile</a>
    @elseif (isset($venue))
      <h2>{{ $venue->name }}</h2>
      <p> {{ $venue->description }}</p>
      <a class="btn" href="/venues/{{ $venue->id }}/edit">Edit Venue Profile</a>
    @endif
  </div>
  <h2>Events</h2>
  @if(isset($performer) && !empty($performer->events))
    <ul>
      @foreach($performer->events as $event)
        <li><a href="/events/{{$event->id}}">{{$event->name}}</a></li>
      @endforeach
    </ul>
  @elseif(isset($venue) && !empty($venue->events))
    <ul>
      @foreach($venue->events as $event)
        <li><a href="/events/{{$event->id}}">{{$event->name}}</a></li>
      @endforeach
    </ul>
  @endif
  <a class="btn" href="/users">Return to Users</a>
  
@endsection