@extends('layout')

@section('content')
  <h2>Add New Event Type</h2>
  <form action="/types" method="POST">
    {{ csrf_field() }}
    <input type="hidden" name="type" value="event">
    <label class="label" for="name">Name</label>
    <input class="input" type="text" name="name" id="name">
    <input class="btn" type="submit" value="Add Event Type">
  </form>

  <h2>Add new Performer Type</h2>
  <form action="/types" method="POST">
    {{ csrf_field() }}
    <input type="hidden" name="type" value="performer">
    <label class="label" for="name">Name</label>
    <input class="input" type="text" name="name" id="name">
    <input class="btn" type="submit" value="Add Performer Type">
  </form>
  
@endsection('content')