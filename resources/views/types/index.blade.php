@extends('layout')

@section('content')
  <h2>Event Types</h2>
  <ul>
    @foreach($eventTypes as $eventType) 
      <li>{{ $eventType->name }}</li>
      <form action="/types/{{$eventType->id}}" method="POST">
        {{ csrf_field() }}
        @method('DELETE')
        <input type="hidden" name="type" value="event">
        <input type="submit" value="delete">
      </form>
    @endforeach
  </ul>
  <h2>Performer Types</h2>
  <ul>
    @foreach($performerTypes as $performerType) 
      <li>{{ $performerType->name }}</li>
      <form action="/types/{{$performerType->id}}" method="POST">
        {{ csrf_field() }}
        @method('DELETE')
        <input type="hidden" name="type" value="performer">
        <input type="submit" value="delete">
      </form>
    @endforeach
  </ul>

@endsection('content')