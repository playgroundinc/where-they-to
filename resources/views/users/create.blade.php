@extends('layout')

@section('content')
  <h1>Create a User profile</h1>
  <form method="POST" action="/users">
  {{ csrf_field() }}
    <div>
      <input type="email" name="email" placeholder="email">
      <input type="text" name="username" placeholder="username">
      <input type="password" name="password" placeholder="password">
      <select name="type" id="type">
        <option value="1" selected>Performer</option>
        <option value="2">Venue</option>
      </select>
    </div>
    <div><input type="submit" value="Create Profile"></div>
  </form>
@endsection