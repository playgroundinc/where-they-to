@extends('layout')

@section('content')
  <h1>Venues</h1>
  <ul>
    @foreach ($venues as $venue)
      <li>
        <a href="/venues/{{ $venue->id }}">{{ $venue->name }}</a>
      </li>
    @endforeach
  </ul>
  <a href="/users/create">Create a profile</a>
@endsection