@extends('layout')

@section('content')
  <h1>Create a Performer profile</h1>
  <form method="POST" action="/performers">
  {{ csrf_field() }}
  <div>
    <input type="hidden" name="id" value={{ $id ?? '0' }}>
      <input type="text" name="name">
      <textarea name="bio" id="bio" cols="30" rows="10" placeholder="Performer bio"></textarea>
      <input type="hidden" name="events">
      <input type="hidden" name="socialLinks">
    </div>
    <div><input type="submit" value="Create Profile"></div>
  </form>
  <h1>Add Social Links</h1>
  <form action="/social-links" method="POST">
  {{ csrf_field() }}
    <input type="hidden" name="user_id" value={{ $id ?? null}}>
    <input type="text" id="facebook" name="facebook" placeholder="Facebook URL">
    <input type="text" id="instagram" name="instagram" placeholder="Instagram Handle">
    <input type="text" id="twitter" name="twitter" placeholder="Twitter Handle">
    <input type="text" id="youtube" name="youtube" placeholder="Youtube">
    <input type="text" id="website" name="website" placeholder="Website">
    <input type="submit" value="Submit">
  </form>
@endsection