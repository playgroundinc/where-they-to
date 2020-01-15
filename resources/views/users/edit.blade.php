@extends('layout')

@section('content')
  <h1>Update {{ $user->username}}'s profile</h1>
  <form method="POST" action="/users/{{ $user->id }}">
  {{ csrf_field() }}
  @method('PUT')
    <label class="label" for="email">Email Address:</label>
    <input class="input" type="email" id="email" name="email" placeholder="email" value={{ $user->email }}>
    <input class="btn" type="submit" value="Update Profile">
  </form>
  <form action="/users/{{ $user->id }}" method="POST">
      {{ csrf_field() }}
      @method('DELETE')
      <input class="btn btn--danger" type="submit" value="Delete User">
    </form>
@endsection