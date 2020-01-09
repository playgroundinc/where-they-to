@extends ('layout')

@section('content')
  <h1>{{ $performer->name }}</h1>
  <div>{{ $performer->bio }}</div>
@endsection