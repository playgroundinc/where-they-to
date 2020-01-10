@extends ('layout')

@section('content')
  <h1>{{ $venue->name }}</h1>
  <div>{{ $venue->description }}</div>
  <p>{{ $venue->address }}</p>
  <p>{{ $venue->city }}, {{$venue->province }}</p>
  @foreach($platforms as $platform)
    @if (strlen($socialLinks[$platform]) > 0)
      {{ $platform }} : {{ $socialLinks[$platform] }}
    @endif
  @endforeach
@endsection