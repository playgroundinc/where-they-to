@extends('layout')

@section('content')
  <h1>Performers</h1>
  <ul>
    @foreach ($performers as $performer)
      <li>
        <a href="/performers/{{ $performer->id }}">{{ $performer->id }}</a>
      </li>
    @endforeach
  </ul>
  <a href="/performers/create">Create a performer profile</a>
@endsection