@extends('layout')

@section('content') 
  <h1>All Families</h1>
  @foreach ($families as $family)
    <li>
      <a href="/families/{{$family->id}}">{{ $family->name }}</a>
    </li>
  @endforeach
@endsection