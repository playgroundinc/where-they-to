@extends ('layout')
@section('content')
  <h1>{{ $performer->name }}</h1>
  <div>{{ $performer->bio }}</div>
  @foreach($platforms as $platform)
    @if (strlen($socialLinks[$platform]) > 0)
      {{ $platform }} : {{ $socialLinks[$platform] }}
    @endif
  @endforeach
  @if (isset($family)) 
    <div>
      <h2>Family:</h2>
      <a href="/families/{{ $family->id }}">{{ $family->name }}</a>
    </div>
  @endif
  <a href="/performers/{{$performer->id}}/edit">Edit Profile</a>
@endsection