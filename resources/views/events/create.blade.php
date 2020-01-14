@extends('layout')

@section('content')
  <form action="/events" method="POST">
    {{ csrf_field() }}
    <label for="name">Name</label>
    <input type="text" name="name" id="name">
    <label for="description">description</label>
    <textarea name="description" id="description" cols="30" rows="10"></textarea>
    <label for="type">Type</label>
    <select name="type" id="type">
      <option value="1">Drag</option>
      <option value="2">Viewing Party</option>
      <option value="3">Burlesque</option>
      <option value="4">Variety of Performers</option>
    </select>
    <label for="date">Date</label>
    <input type="text" name="date" id="date">
    <label for="venue">Venue:</label>
    <select name="venue" id="venue">
      @foreach($venues as $venue) 
        <option value="{{$venue->id}}">{{$venue->name}}</option>
      @endforeach
    </select>
    <label for="family">Family:</label>
    <select name="family" id="family">
      @foreach($families as $family) 
        <option value="{{$family->id}}">{{$family->name}}</option>
      @endforeach
    </select>
    <label for="performer">Performer:</label>
    <select name="performers[0]" id="performer">
      @foreach($performers as $performer) 
        <option value="{{$performer->id}}">{{$performer->name}}</option>
      @endforeach
    </select>
    <select name="performers[1]">
      @foreach($performers as $performer) 
        <option value="{{$performer->id}}">{{$performer->name}}</option>
      @endforeach
    </select>

    <input type="submit" value="submit">
  </form>
@endsection