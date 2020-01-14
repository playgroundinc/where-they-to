@extends('layout')

@section('content')
  <form action="/events/{{$event->id}}" method="POST">
    {{ csrf_field() }}
    @method('PUT')
    <label for="name">Name</label>
    <input type="text" name="name" id="name" value="{{ $event->name }}">
    <label for="description">description</label>
    <textarea name="description" id="description" cols="30" rows="10">{{ $event->description }}</textarea>
    <label for="type">Type</label>
    <select name="type" id="type">
      <option value="1">Drag</option>
      <option value="2">Viewing Party</option>
      <option value="3">Burlesque</option>
      <option value="4">Variety of Performers</option>
    </select>
    <label for="date">Date</label>
    <input type="text" name="date" id="date" value="{{ $event->date }}">
    <label for="venue">Venue:</label>
    <select name="venue" id="venue">
      @foreach($venues as $venue) 
        <option value="{{$venue->id}}" {{ $venue->id === $event->venue->id ? 'selected' : '' }}>
          {{$venue->name}}
        </option>
      @endforeach
    </select>
    <label for="family">Family:</label>
    <select name="family" id="family">
      @foreach($families as $family) 
        <option value="{{$family->id}}" {{ $family->id === $event->family->id ? 'selected' : '' }} >{{$family->name}}</option>
      @endforeach
    </select>
    <label for="performer">Performer:</label>
    <select name="performers[0]" id="performer">
      @foreach($performers as $index=>$performer) 
        <option value="{{$performer->id}}" {{ isset($event->performers[0]) && intval($performer->id) === intval($event->performers[0]->id) ? 'selected' : '' }}>{{$performer->name}}</option>
      @endforeach
    </select>
    <select name="performers[1]">
      @foreach($performers as $performer) 
        <option value="{{$performer->id}}" {{ isset($event->performers[1]) && intval($performer->id) === intval($event->performers[1]->id) ? 'selected' : '' }}>{{$performer->name}}</option>
      @endforeach
    </select>

    <input type="submit" value="submit">
  </form>
@endsection 