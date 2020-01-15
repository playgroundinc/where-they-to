@extends('layout')

@section('content')
  <h1>Create an Event</h1>
  <form action="/events" method="POST">
    {{ csrf_field() }}
    <label class="label" for="name">Name</label>
    <input class="input" type="text" name="name" id="name">
    <label class="label" for="description">description</label>
    <textarea class="input" name="description" id="description" cols="30" rows="10"></textarea>
    <label class="label" for="date">Date</label>
    <input class="input" type="date" name="date" id="date">
    <label class="label" for="time">Time</label>
    <input class="input" type="time" name="time" id="time">
    <label class="label" for="eventType">Event Type</label>
    <select class="input" name="eventType" id="eventType">
      @foreach($eventTypes as $index=>$eventType) 
        <option value="{{$eventType->id}}" {{ intval($index) === 0 ? 'selected' : '' }}>{{ $eventType->name }}</option>
      @endforeach
    </select>
    <label class="label" for="venue">Venue</label>
    <select class="input" name="venue" id="venue">
      @foreach($venues as $index=>$venue) 
        <option value="{{$venue->id}}" {{ intval($index) === 0 ? 'selected' : '' }}>{{$venue->name}}</option>
      @endforeach
    </select>
    <label class="label" for="family">Family</label>
    <select class="input" name="family" id="family">
      @foreach($families as $index=>$family) 
        <option value="{{$family->id}}" {{ intval($index) === 0 ? 'selected' : '' }}>{{$family->name}}</option>
      @endforeach
    </select>
    <label class="label" for="performer1">Performer 1</label>
    <select class="input" name="performers[0]" id="performer1">
      @foreach($performers as $index=>$performer) 
        <option value="{{$performer->id}}" {{ intval($index) === 0 ? 'selected' : '' }}>{{$performer->name}}</option>
      @endforeach
    </select>
    <label for="performer2" class="label">Performer 2</label>
    <select class="input" name="performers[1]">
      @foreach($performers as $index=>$performer) 
        <option value="{{$performer->id}}" {{ intval($index) === 0 ? 'selected' : '' }}>{{$performer->name}}</option>
      @endforeach
    </select>

    <input class="btn" type="submit" value="submit">
  </form>
@endsection