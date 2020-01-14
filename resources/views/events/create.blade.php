@extends('layout')

@section('content')
  <form action="/events" method="POST">
    {{ csrf_field() }}
    <label for="name">Name</label>
    <input type="text" name="name" id="name">
    <label for="description">description</label>
    <textarea name="description" id="description" cols="30" rows="10"></textarea>
    <label for="date">Date</label>
    <input type="text" name="date" id="date">
    <label for="eventType">Event Type</label>
    <select name="eventType" id="eventType">
      @foreach($eventTypes as $index=>$eventType) 
        <option value="{{$eventType->id}}" {{ intval($index) === 0 ? 'selected' : '' }}>{{ $eventType->name }}</option>
      @endforeach
    </select>
    <label for="venue">Venue:</label>
    <select name="venue" id="venue">
      @foreach($venues as $index=>$venue) 
        <option value="{{$venue->id}}" {{ intval($index) === 0 ? 'selected' : '' }}>{{$venue->name}}</option>
      @endforeach
    </select>
    <label for="family">Family:</label>
    <select name="family" id="family">
      @foreach($families as $index=>$family) 
        <option value="{{$family->id}}" {{ intval($index) === 0 ? 'selected' : '' }}>{{$family->name}}</option>
      @endforeach
    </select>
    <label for="performer">Performer:</label>
    <select name="performers[0]" id="performer">
      @foreach($performers as $index=>$performer) 
        <option value="{{$performer->id}}" {{ intval($index) === 0 ? 'selected' : '' }}>{{$performer->name}}</option>
      @endforeach
    </select>
    <select name="performers[1]">
      @foreach($performers as $index=>$performer) 
        <option value="{{$performer->id}}" {{ intval($index) === 0 ? 'selected' : '' }}>{{$performer->name}}</option>
      @endforeach
    </select>

    <input type="submit" value="submit">
  </form>
@endsection