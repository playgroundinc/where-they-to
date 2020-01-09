@extends('layout')

@section('content')
  <h1>Create a Performer profile</h1>
  <form method="POST" action="/performers">
  {{ csrf_field() }}
    <div>
      <input type="hidden" name="user" value={{ $id }}>
      <input type="text" name="name">
      <textarea name="bio" id="bio" cols="30" rows="10" placeholder="Performer bio"></textarea>
      <input type="hidden" name="events" value="0">
      <input type="hidden" name="socialLinks" value="0">
    </div>
    <div><input type="submit" value="Create Profile"></div>
  </form>
@endsection