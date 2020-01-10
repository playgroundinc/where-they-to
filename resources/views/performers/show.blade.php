@extends ('layout')

@section('content')
  {{ $performer }}
  <h1>{{ $performer->name }}</h1>
  <div>{{ $performer->bio }}</div>
@endsection