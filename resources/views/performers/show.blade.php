@extends ('layout')
@section('content')
  <h1>{{ $performer->name }}</h1>
  <div>{{ $performer->bio }}</div>
  @foreach($platforms as $platform)
    @if (strlen($socialLinks[$platform]) > 0)
      {{ $platform }} : {{ $socialLinks[$platform] }}
    @endif
  @endforeach
  <a href="/performers/{{$performer->id}}/edit">Edit Profile</a>
@endsection