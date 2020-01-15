@extends('layout')

@section('content')
  <h1>Create a Venue profile</h1>
  <form method="POST" action="/venues">
  {{ csrf_field() }}
    <div>
      <input type="hidden" name="id" value={{ $user_id }}>
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
@endsection