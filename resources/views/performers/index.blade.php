@extends('layout')

@section('content')
  <h1>Performers</h1>
  <ul class="list">
    @foreach ($performers as $performer)
      <li class="list-item">
        <a class="list-link" href="/performers/{{ $performer->id }}">{{ $performer->name }}</a>
      </li>
    @endforeach
  </ul>
  <a class="btn" href="/users/create">Create a profile</a>
@endsection