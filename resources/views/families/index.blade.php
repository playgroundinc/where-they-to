@extends('layout')

@section('content') 
  <h1>All Families</h1>
  <ul class="list">
    @foreach ($families as $family)
      <li class="list-item">
        <a class="list-link" href="/families/{{$family->id}}">{{ $family->name }}</a>
      </li>
    @endforeach
  </ul>
  <a href="/families/create" class="btn">Create New Family</a>
@endsection