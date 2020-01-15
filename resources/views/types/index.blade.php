@extends('layout')

@section('content')
  <h2>Event Types</h2>
  <ul class="list">
    @foreach($eventTypes as $index=>$eventType) 
      <li class="list-item">{{ $eventType->name }}</li>
      <form action="/types/{{ $eventType->id }}" method="POST">
        {{ csrf_field() }}
        @method('PUT')
        <input type="hidden" name="type" value="event">
        <label for="eventName{{$index}}" class="label">Name</label>
        <input class="input" type="text" name="name" id="eventName{{$index}}" value="{{$eventType->name}}">
        <input class="btn" type="submit" value="Update Event Type">
      </form>
      <form action="/types/{{$eventType->id}}" method="POST">
        {{ csrf_field() }}
        @method('DELETE')
        <input type="hidden" name="type" value="event">
        <input class="btn btn--danger" type="submit" value="delete">
      </form>
    @endforeach
  </ul>
  <a href="/types/create" class="btn">Add New Event Type</a>
  <h2>Performer Types</h2>
  <ul class="list">
    @foreach($performerTypes as $index=>$performerType) 
      <li class="list-item">{{ $performerType->name }}</li>
      <form action="/types/{{ $performerType->id }}" method="POST">
        {{ csrf_field() }}
        @method('PUT')
        <input type="hidden" name="type" value="performer">
        <label for="performerName{{$index}}" class="label">Name</label>
        <input class="input" type="text" name="name" id="performerName{{$index}}" value="{{ $performerType->name}}">
        <input class="btn" type="submit" value="Update Performer Type">
      </form>
      <form action="/types/{{$performerType->id}}" method="POST">
        {{ csrf_field() }}
        @method('DELETE')
        <input type="hidden" name="type" value="performer">
        <input class="btn btn--danger" type="submit" value="delete">
      </form>
    @endforeach
  </ul>
  <a href="/types/create" class="btn">Add New Performer Type</a>


@endsection('content')