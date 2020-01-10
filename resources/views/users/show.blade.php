@extends('layout')

@section('content')
  <div>
    <h1>{{ $user->username }}</h1>
  </div>
  <a href="/users/{{$user->id}}/edit">Edit</a>
  <a href="/users">Return to Users</a>
  @if (isset($performer))
    <a href="/performers/{{ $performer->id }}/edit">Edit Performer Profile</a>
  @elseif (isset($venue))
    <a href="/venues/{{ $venue->id }}/edit">Edit Venue Profile</a>
  @endif
@endsection