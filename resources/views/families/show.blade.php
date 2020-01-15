@extends('layout')

@section('content')
  <h1>{{ $family->name }}</h1>
  <h2>Description</h2>
  <p>{{ $family->description }}</p>
  @if (isset($performers))
    <h2>Performers</h2>
    <ul class="list"> 
      @foreach($performers as $performer) 
        <li class="list-item">
          <a class="list-link" href="/performers/{{$performer->id}}">{{ $performer->name}}</a>
        </li>
      @endforeach
    </ul>
  @endif
  @if (!empty($socialLinks))
    <h2>Social Links</h2>
    <ul class="list">
      @foreach($platforms as $index=>$platform)
        @if (strlen($socialLinks[$index]) > 0)
        <li class="list-item">
          <p>{{$platform}} : {{ $socialLinks[$index] }}</p>
        </li>
        @endif
      @endforeach
    </ul>
  @endif
  @if(count($family->events) > 0)
    <h2>Events</h2>
    <ul class="list">
      @foreach ($family->events as $event) 
        <li class="list-item">
          <a class="list-link" href="/events/{{$event->id}}">{{ $event->name }}</a>
        </li>
      @endforeach
    </ul>
  @endif
  <a class="btn" href="/families/{{ $family->id }}/edit">Edit Family</a>
@endsection