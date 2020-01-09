@extends('layout')

@section('content')
  <div>
    <h1>{{ $user->username }}</h1>
    <p>Name: {{ $user->name }}</p>
    <p>
      {{ $user->bio }}
    </p>
  </div>
  <a href="/users/{{$user->id}}/edit">Edit</a>
  <a href="/users">Return to Users</a>

@endsection