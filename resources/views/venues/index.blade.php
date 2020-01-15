@extends('layout')

@section('content')
  <h1>Venues</h1>
  <ul class="list">
    @foreach ($venues as $venue)
      <li class="list-item">
        <a class="list-link" href="/venues/{{ $venue->id }}">{{ $venue->name }}</a>
      </li>
    @endforeach
  </ul>
  <a class="btn" href="/users/create">Create a profile</a>
@endsection