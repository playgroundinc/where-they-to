@extends('layout')

@section('content')
  <h1>Edit venue profile</h1>
  <form method="POST" action="/venues/{{ $venue->id }}">
    {{ csrf_field() }}
    @method('PUT')
    <label class="label" for="name">Name</label>
    <input class="input" type="text" id="name" name="name" value="{{ $venue->name }}">
    <label class="label" for="address">Address</label>
    <input class="input" type="text" name="address" id="address" value="{{ $venue->address }}">
    <label class="label" for="city">City</label> 
    <input class="input" type="text" name="city" id="city" value="{{ $venue->city }}">
    <label class="label" for="description">Description</label>
    <textarea class="input" name="description" id="description" cols="30" rows="10" placeholder="Venue description">{{ $venue->description }}</textarea>
    <input class="btn" type="submit" value="Update Profile">
  </form>
  <h2>Edit Social Links</h2>
  <form action="/social-links/{{ $socialLinks->id }}" method="POST">
    {{ csrf_field() }}
    @method('PUT')
    <input type="hidden" name="redirect_to" value="/venues/{{ $venue->id}}">
    @foreach($platforms as $index=>$platform)
      <label class="label" for="{{ $index }}">{{ $platform }}:</label>
      <input class="input" type="text" id="{{ $index }}" name="{{ $index }}" value={{ $socialLinks[$index]}} > 
    @endforeach
    <input class="btn" type="submit" value="Update Social Links">
  </form>
  <form action="/venues/{{$venue->id}}" method="POST">
    {{ csrf_field() }}
    @method('DELETE')
    <input class="btn btn--danger" type="submit" value="Delete Event">
  </form>
@endsection