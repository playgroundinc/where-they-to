@extends('layout')

@section('content')
  <h1>Performers</h1>
  <ul>
    @foreach ($performers as $performer)
      <li>
        <a href="/performers/{{ $performer->id }}">{{ $performer->name }}</a>
      </li>
    @endforeach
  </ul>
  <a href="/users/create">Create a profile</a>
@endsection