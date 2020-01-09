@extends('layout')

@section('content')
  <h1>Users</h1>
  <ul>
    @foreach ($users as $user)
      <li>
        <a href="/users/{{ $user->id}}">{{ $user->name }}</a>
      </li>
    @endforeach
  </ul>
  <a href="/users/create">Create an account</a>
@endsection