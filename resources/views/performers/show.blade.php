@extends ('layout')
@section('content')
{{ $performer }}
  <h1>{{ $performer->name }}</h1>
  <div>
    <h2>Bio</h2>
    <p>{{ $performer->bio }}</p>
  </div>
  <h2>Social Links</h2>
  <ul>
  @foreach($platforms as $platform)
    @if (strlen($socialLinks[$platform]) > 0)
      <li>{{ $platform }} : {{ $socialLinks[$platform] }}</li>
    @endif
  @endforeach
  </ul>
  @if (isset($family)) 
    <div>
      <h2>Family:</h2>
      <a href="/families/{{ $family->id }}">{{ $family->name }}</a>
    </div>
  @endif
  <div>
    <a href="/performers/{{$performer->id}}/edit">Edit Profile</a>
  </div>
@endsection