@extends('layout')

@section('content')
  <h1>Edit venue profile</h1>
  {{ $venue }}
  <form method="POST" action="/venues/{{ $venue->id }}">
  {{ csrf_field() }}
  @method('PUT')
    <div>
      <label for="name">Name:</label>
      <input type="text" id="name" name="name" value="{{ $venue->name }}">
      <label for="address">Address:</label>
      <input type="text" name="address" id="address" value="{{ $venue->address }}">
      <label for="city">City:</label> 
      <input type="text" name="city" id="city" value="{{ $venue->city }}">
      <label for="description">Description</label>
      <textarea name="description" id="description" cols="30" rows="10" placeholder="Venue description">{{ $venue->description }}</textarea>
    </div>
    <div><input type="submit" value="Update Profile"></div>
  </form>
@endsection