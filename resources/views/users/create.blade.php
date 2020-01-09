@extends('layout')

@section('content')
  <h1>Create a User profile</h1>
  <form method="POST" action="/users">
  {{ csrf_field() }}
    <div>
      <input type="email" name="email" placeholder="email">
      <input type="text" name="username" placeholder="username">
      <input type="password" name="password" placeholder="password">
      <input type="text" name="name" placeholder="Your Name">
      <select name="type" id="type">
        <option value="1" selected>Performer</option>
        <option value="2">Venue</option>
      </select>
      </div>
      <div>
      <textarea name="bio" id="" cols="30" rows="10" placeholder="Performer bio"></textarea>
      <input type="hidden" name="events" value="0">
      <input type="hidden" name="socialLinks" value="1">
    </div>
    <div><input type="submit" value="Create Profile"></div>
  </form>
@endsection