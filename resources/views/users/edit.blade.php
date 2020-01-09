@extends('layout')

@section('content')
  <h1>Update {{ $user->name}}'s profile</h1>
  <form method="POST" action="/users/{{ $user->id }}">
  {{ csrf_field() }}
  @method('PUT')
    <div>
      <label for="email">Email Address:</label>
      <input type="email" id="email" name="email" placeholder="email" value={{ $user->email }}>
    </div>
    <div><input type="submit" value="Update Profile"></div>
  </form>
  <a href="/users/{{ $user->id}}">Return to Profile </a>
  <div>
    <form action="/users/{{ $user->id }}" method="POST">
      {{ csrf_field() }}
      @method('DELETE')
      <input type="submit" value="Delete User">
    </form>
  </div>
@endsection