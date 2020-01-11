@extends('layout')

@section('content')
  <h1>Edit Performer profile</h1>
  <form method="POST" action="/performers/{{$performer->id}}">
    {{ csrf_field() }}
    @method('PUT')
    <div>
      <input type="text" name="name" value="{{$performer->name}}">
      <textarea name="bio" id="bio" cols="30" rows="10" placeholder="Performer bio">{{$performer->bio}}</textarea>
    </div>
    <div>
      <input type="submit" value="Create Profile">
    </div>
  </form>
  <form action="/social-links/{{$socialLinks->id}}" method="POST">
    {{ csrf_field() }}
    @method('PUT')
    <input type="hidden" name="redirect_to" value="performers/{{ $performer->id}}" >
    @foreach($platforms as $platform) 
      <input type="text" name="{{ $platform }}" value="{{ $socialLinks[$platform] }}">
    @endforeach
    <input type="submit" value="Update Social Links">
  </form>
@endsection