@extends('layout')

@section('content')
  <h1>Create a Venue profile</h1>
  <form method="POST" action="/venues">
  {{ csrf_field() }}
    <div>
      <input type="hidden" name="id" value={{ $user_id ?? '0' }}>
      <label class="label" for="name">Name</label>
      <input class="input" type="text" id="name" name="name">
      <label class="label" for="address">Address</label>
      <input class="input" type="text" name="address" id="address">
      <label class="label" for="city">City:</label>
      <input class="input" type="text" name="city" id="city">
      <label class="label" for="description">Description</label>
      <textarea class="input" name="description" id="description" cols="30" rows="10"></textarea>
    </div>
    <input class="btn" type="submit" value="Create Profile">
  </form>
  <h1>Add Social Links</h1>
  <form action="/social-links" method="POST">
    {{ csrf_field() }}
    <input type="hidden" name="user_id" value={{ $user_id ?? '1'}}>
    <label for="facebook" class="label">Facebook</label>
    <input class="input" type="text" id="facebook" name="facebook">
    <label for="instagram" class="label">Instagram</label>
    <input class="input" type="text" id="instagram" name="instagram">
    <label for="twitter" class="label">Twitter</label>
    <input class="input "type="text" id="twitter" name="twitter">
    <label for="youtube" class="label">YouTube</label>
    <input class="input" type="text" id="youtube" name="youtube">
    <label for="website" class="label">Website</label>
    <input class="input" type="text" id="website" name="website">
    <input class="btn" type="submit" value="Add Social Links">
  </form>
@endsection