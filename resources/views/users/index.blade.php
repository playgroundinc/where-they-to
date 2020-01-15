@extends('layout')

@section('content')
  <h1>Users</h1>
  <ul class="list">
    @foreach ($users as $user)
      <li class="list-item">
        <a class="list-link" href="/users/{{ $user->id}}">{{ $user->username }}</a>
      </li>
    @endforeach
  </ul>
  <a class="btn" href="/users/create">Create an account</a>
@endsection