@extends('layout')

@section('content')
  <h1>Create a Venue profile</h1>
  <form method="POST" action="/venues">
  {{ csrf_field() }}
    <div>
      <input type="hidden" name="id" value={{ $id }}>

      <label for="name">Name:</label>
      <input type="text" id="name" name="name">
      <label for="address">Address:</label>
      <input type="text" name="address" id="address">
      <label for="city">City:</label>
      <input type="text" name="city" id="city">
      <label for="description">Description</label>
      <textarea name="description" id="description" cols="30" rows="10" placeholder="Venue description"></textarea>
      <input type="hidden" name="events" value="0">
      <input type="hidden" name="socialLinks" value="0">
    </div>
    <div><input type="submit" value="Create Profile"></div>
  </form>
@endsection