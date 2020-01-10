@extends ('layout')
@section('content')
  {{ $socialLinks }}
  <h1>{{ $performer->name }}</h1>
  <div>{{ $performer->bio }}</div>
  @foreach($platforms as $platform)
    @if (strlen($socialLinks[$platform]) > 0)
      {{ $platform }} : {{ $socialLinks[$platform] }}
    @endif
  @endforeach
@endsection