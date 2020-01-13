@extends('layout')

@section('content')

<form action="/families" method="POST">
  {{ csrf_field() }}
  <label for="name">Name:</label>
  <input type="text" name="name" id="name">
  <label for="description">Description:</label>
  <textarea name="description" id="description" cols="30" rows="10"></textarea>
  <input type="submit" value="Submit">
</form>

@endsection