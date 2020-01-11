@extends('layout')

@section('content')
  <div>
    <h1>{{ $user->username }}</h1>
    <p>{{ $user->email }}</p>
  </div>
  <div>
    <a href="/users/{{$user->id}}/edit">Edit</a>
  </div>
  <div>
    <a href="/users">Return to Users</a>
  </div>
  @if (isset($performer))
    <a href="/performers/{{ $performer->id }}/edit">Edit Performer Profile</a>
  @elseif (isset($venue))
    <a href="/venues/{{ $venue->id }}/edit">Edit Venue Profile</a>
  @endif
@endsection