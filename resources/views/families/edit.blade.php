@extends('layout')

@section('content')
  <h1>Edit Family</h1>
  <form action="/families/{{$family->id}}" method="POST">
  {{ csrf_field() }}
  @method('PUT')
  <label class="label" for="name">Name</label>
  <input class="input" type="text" name="name" id="name" value="{{ $family->name }}">
  <label class="label" for="description">Description:</label>
  <textarea class="input" name="description" id="description" cols="30" rows="10">{{ $family->description }}</textarea>
  <input class="btn" type="submit" value="Submit">
</form>
<h2>Current Performers</h2>
<ul class="list container--inner">
  @foreach ($familyPerformers as $familyPerformer)
    <li class="list-item list-item--flex">
      <a class="list-link" href="/performers/{{ $familyPerformer->id}}">
        {{ $familyPerformer->name }}
      </a>
      <form action="/families/performers/{{ $familyPerformer->id }}/destroy" method="POST">
        {{ csrf_field() }}
        <input type="hidden" name="family" value="{{ $family->id }}">
        <input class="btn btn--danger" type="submit" value="Remove Performer">
      </form>
    </li>
  @endforeach
</ul>
<h2>Add New Performer</h2>
<form action="/families/performers/{{$family->id}}" method="POST">
  {{ csrf_field() }}
  <label class="label" for="performer">Performers</label>
  <select class="input" name="performer" id="performer">
    @foreach($allPerformers as $performer) 
      <option value="{{$performer->id}}">{{$performer->name}}</option>
    @endforeach
  </select>
  <input class="btn" type="submit" value="Add New Performer">
</form>
<h2>Edit Social Links</h2>
@if (isset($socialLinks))
<form action="/social-links/{{$socialLinks->id}}" method="POST">
  {{ csrf_field() }}
  @method('PUT')
  @foreach($platforms as $platform) 
    <label class="label" for="{{ $platform }}">{{ $platform }}</label>
    <input class="input" type="text" name="{{ $platform }}" id="{{ $platform }}" value="{{ $socialLinks[$platform]}}">
  @endforeach
  <input class="btn" type="submit" value="Update Social Links">
</form>
@else 
<form action="/social-links" method="POST">
  {{ csrf_field() }}
  <input type="hidden" name="family_id" value="{{ $family->id }}">
  <label class="label" for="facebook">Facebook</label>
  <input class="input" type="text" id="facebook" name="facebook" placeholder="Facebook URL">
  <label class="label" for="instagram">Instagram</label>
  <input class="input" type="text" id="instagram" name="instagram" placeholder="Instagram Handle">
  <label class="label" for="twitter">Twitter</label>
  <input class="input" type="text" id="twitter" name="twitter" placeholder="Twitter Handle">
  <label class="label" for="youtube">YouTube</label>
  <input class="input" type="text" id="youtube" name="youtube" placeholder="Youtube">
  <label class="label" for="website">Website</label>
  <input class="input" type="text" id="website" name="website" placeholder="Website">
  <input class="btn" type="submit" value="Submit">
</form>
@endif
<form action="/families/{{$family->id}}" method="POST">
  {{ csrf_field() }}
  @method('DELETE')
  <input class="btn btn--danger" type="submit" value="Delete Family">
</form>
@endsection