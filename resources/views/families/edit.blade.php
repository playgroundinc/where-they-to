@extends('layout')

@section('content')
  <h1>Edit Family</h1>
  <form action="/families/{{$family->id}}" method="POST">
  {{ csrf_field() }}
  @method('PUT')
  <label for="name">Name:</label>
  <input type="text" name="name" id="name" value="{{ $family->name }}">
  <label for="description">Description:</label>
  <textarea name="description" id="description" cols="30" rows="10">{{ $family->description }}</textarea>
  <input type="submit" value="Submit">
</form>
<h2>Current Performers</h2>
<ul>
  @foreach ($familyPerformers as $familyPerformer)
    <li>
      <a href="/performers/{{ $familyPerformer->id}}">
        {{ $familyPerformer->name }}
      </a>
      <form action="/families/performers/{{ $familyPerformer->id }}/destroy" method="POST">
        {{ csrf_field() }}
        <input type="hidden" name="family" value="{{ $family->id }}">
        <input type="submit" value="Remove Performer">
      </form>
    </li>
  @endforeach
</ul>
<h2>Add New Performer</h2>
<form action="/families/performers/{{$family->id}}" method="POST">
  {{ csrf_field() }}
  <label for="performer">Performers:</label>
  <select name="performer" id="performer">
    @foreach($allPerformers as $performer) 
      <option value="{{$performer->id}}">{{$performer->name}}</option>
    @endforeach
  </select>
  <input type="submit" value="Add New Performer">
</form>
<h2>Edit Social Links</h2>
@if (isset($socialLinks))
<form action="/social-links/{{$socialLinks->id}}" method="POST">
  {{ csrf_field() }}
  @method('PUT')
  @foreach($platforms as $platform) 
    <label for="{{ $platform }}">{{ $platform }}</label>
    <input type="text" name="{{ $platform }}" id="{{ $platform }}" value="{{ $socialLinks[$platform]}}">
  @endforeach
  <input type="submit" value="Update Social Links">
</form>
@else 
<form action="/social-links" method="POST">
  {{ csrf_field() }}
  <input type="hidden" name="family_id" value="{{ $family->id }}">
  <input type="text" id="facebook" name="facebook" placeholder="Facebook URL">
  <input type="text" id="instagram" name="instagram" placeholder="Instagram Handle">
  <input type="text" id="twitter" name="twitter" placeholder="Twitter Handle">
  <input type="text" id="youtube" name="youtube" placeholder="Youtube">
  <input type="text" id="website" name="website" placeholder="Website">
  <input type="submit" value="Submit">
</form>
@endif
<form action="/families/{{$family->id}}" method="POST">
  {{ csrf_field() }}
  @method('DELETE')
  <input type="submit" value="Delete Family">
</form>
@endsection