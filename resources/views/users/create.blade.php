@extends('layout')

@section('content')
  <h1>Create a User profile</h1>
  <form method="POST" action="/users">
  {{ csrf_field() }}
    <label class="label" for="email">Email</label>
    <input class="input" type="email" name="email" placeholder="email">
    <label class="label" for="username" >Username</label>
    <input class="input" type="text" name="username" placeholder="username">
    <label for="password" class="label">Password</label>
    <input class="input" type="password" name="password" placeholder="password">
    <label for="type" class="label">Type</label>
    <select class="input" name="type" id="type">
      <option value="1" selected>Performer</option>
      <option value="2">Venue</option>
    </select>
    <input class="btn" type="submit" value="Create Profile">
  </form>
@endsection