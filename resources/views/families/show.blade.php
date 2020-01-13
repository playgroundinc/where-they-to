@extends('layout')

@section('content')
  <h1>{{ $family->name }}</h1>
  <p>{{ $family->description }}</p>
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

  <a href="/families/{{ $family->id }}/edit">Edit Family</a>
@endsection