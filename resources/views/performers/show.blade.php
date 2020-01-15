@extends ('layout')
@section('content')
  <h1>{{ $performer->name }}</h1>
  <ul>
  @foreach($performer->performerTypes as $type)
    <li>{{ $type->name }}</li>
  @endforeach
  </ul>
  @if (isset($family)) 
    <div>
      <h2>Family:</h2>
      <a href="/families/{{ $family->id }}">{{ $family->name }}</a>
    </div>
  @endif
  <div>
    <h2>Bio</h2>
    <p>{{ $performer->bio }}</p>
  </div>
  <h2>Social Links</h2>
  <ul class="list">
  @foreach($platforms as $index=>$platform)
    @if (strlen($socialLinks[$index]) > 0)
      <li class="list-item">{{ $platform }} : {{ $socialLinks[$index] }}</li>
    @endif
  @endforeach
  </ul>
  <a class="btn" href="/performers/{{$performer->id}}/edit">Edit Profile</a>

@endsection