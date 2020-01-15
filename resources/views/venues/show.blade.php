@extends ('layout')

@section('content')
  <h1>{{ $venue->name }}</h1>
  <div>
    <h2>Description</h2>
    <p>{{ $venue->description }}</p>
    <h2>Address</h2>
    <p>{{ $venue->address }}</p>
    <p>{{ $venue->city }}, {{$venue->province }}</p>
    <h2>Social Links</h2>
    <ul class="list">
      @foreach($platforms as $index=>$platform)
        @if (strlen($socialLinks[$index]) > 0)
        <li class="list-item">{{ $platform }} : {{ $socialLinks[$index] }}</li>
        @endif
      @endforeach
    </ul>
    <h2>Events</h2>
    <ul>
    @foreach($venue->events as $event)
      <li><a href="/events/{{ $event->id }}">{{ $event->name }}</a></li>
    @endforeach
    </ul>
  </div>
  <a class="btn" href="/venues/{{$venue->id}}/edit">Edit Venue Profile</a>
@endsection