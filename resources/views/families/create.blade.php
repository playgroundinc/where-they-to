@extends('layout')

@section('content')
<h1>Create New Family</h1>
<form action="/families" method="POST">
  {{ csrf_field() }}
  <label clas="label" for="name">Name:</label>
  <input class="input" type="text" name="name" id="name">
  <label class="label" for="description">Description:</label>
  <textarea class="input" name="description" id="description" cols="30" rows="10"></textarea>
  <input class="btn" type="submit" value="Submit">
</form>

@endsection