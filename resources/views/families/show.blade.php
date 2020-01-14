@extends('layout')

@section('content')
  <h1>{{ $family->name }}</h1>
  <h2>Description</h2>
  <p>{{ $family->description }}</p>
  <h2>Performers</h2>
  @if (isset($performers))
    <ul> 
      @foreach($performers as $performer) 
        <li>
          <a href="/performers/{{$performer->id}}">{{ $performer->name}}</a>
        </li>
      @endforeach
    </ul>
  @endif
  <h2>Social Links</h2>
  <ul>
    @foreach($platforms as $platform)
      <li>
        <p>{{$platform}} : {{ $socialLinks[$platform] }}</p>
      </li>
    @endforeach
  </ul>
  <h2>Events</h2>
  <ul>
    @foreach ($family->events as $event) 
      <li><a href="/events/{{$event->id}}">{{ $event->name }}</a></li>
    @endforeach
  </ul>
  <a href="/families/{{ $family->id }}/edit">Edit Family</a>
@endsection