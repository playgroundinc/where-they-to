@extends('layout')

@section('content')
  <form action="/events/{{$event->id}}" method="POST">
    {{ csrf_field() }}
    @method('PUT')
    <label class="label" for="name">Name</label>
    <input class="input" type="text" name="name" id="name" value="{{ $event->name }}">
    <label class="label" for="description">description</label>
    <textarea class="input" name="description" id="description" cols="30" rows="10">{{ $event->description }}</textarea>
    <label class="label" for="eventType">Event Type</label>
    <select class="input" name="eventType" id="eventType">
      @foreach($eventTypes as $index=>$eventType) 
        <option value="{{$eventType->id}}" {{ $eventType->id === $event->eventType->id ? 'selected' : '' }}>{{ $eventType->name }}</option>
      @endforeach
    </select>
    <label class="label" for="date">Date</label>
    <input class="input" type="date" name="date" id="date" value="{{ $event->date }}">
    <label class="label" for="time">Time</label>
    <input class="input" type="time" value="{{ $event->time}}">
    <label class="label" for="venue">Venue</label>
    <select class="input" name="venue" id="venue">
      @foreach($venues as $venue) 
        <option value="{{$venue->id}}" {{ $venue->id === $event->venue->id ? 'selected' : '' }}>
          {{$venue->name}}
        </option>
      @endforeach
    </select>
    <label class="label" for="family">Family</label>
    <select class="input" name="family" id="family">
      @foreach($families as $family) 
        <option value="{{$family->id}}" {{ $family->id === $event->family->id ? 'selected' : '' }} >{{$family->name}}</option>
      @endforeach
    </select>
    <label class="label" for="performer1">Performer 1</label>
    <select class="input" name="performers[0]" id="performer1">
      @foreach($performers as $index=>$performer) 
        <option value="{{$performer->id}}" {{ isset($event->performers[0]) && intval($performer->id) === intval($event->performers[0]->id) ? 'selected' : '' }}>{{$performer->name}}</option>
      @endforeach
    </select>
    <label for="performer2" class="label">Performer 2</label>
    <select class="input" name="performers[1]" id="performer2">
      @foreach($performers as $performer) 
        <option value="{{$performer->id}}" {{ isset($event->performers[1]) && intval($performer->id) === intval($event->performers[1]->id) ? 'selected' : '' }}>{{$performer->name}}</option>
      @endforeach
    </select>

    <input class="btn" type="submit" value="Update Event">
  </form>
  <form action="/events/{{$event->id}}" method="POST">
    {{csrf_field()}}
    @method('DELETE')
    <input class="btn btn--danger" type="submit" value="Delete Event">
  </form>
@endsection 