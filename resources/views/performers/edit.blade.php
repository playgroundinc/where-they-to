@extends('layout')

@section('content')
  <h1>Edit Performer profile</h1>
  <form method="POST" action="/performers/{{$performer->id}}">
    {{ csrf_field() }}
    @method('PUT')
    <div>
      <label class="label" for="name">Name</label>
      <input class="input" type="text" name="name" value="{{$performer->name}}">
      <label class="label" for="bio">Bio</label>
      <textarea class="input" name="bio" id="bio" cols="30" rows="10" placeholder="Performer bio">{{$performer->bio}}</textarea>
    </div>
    <label class="label" for="performerType0">Performer Type</label>
    @if (count($performer->performerTypes) > 0)
      @foreach($performer->performerTypes as $index=>$performerType) 
      <select class="input" name="performerType[{{$index}}]" id="performerType{{$index}}">
        @foreach($performerTypes as $index=>$type)
          <option value="{{ $type->id }}" {{ intval($type->id) === intval($performerType->id) ? 'selected' : '' }}>{{ $type->name }}</option>
        @endforeach
      </select>
      @endforeach
    @else 
      <select class="input" name="performerType[0]" id="performerType0">
        @foreach($performerTypes as $index=>$type)
          <option value="{{ $type->id }}" {{ intval($index) === 0 ? 'selected' : '' }}>{{ $type->name }}</option>
        @endforeach
      </select>
    @endif
    <input class="btn" type="submit" value="Update Profile">
  </form>
  <form {{ isset($socialLinks) ? 'action=/social-links/'.$socialLinks->id : 'action=/social-links' }} method="POST">
    {{ csrf_field() }}
    @if (isset($socialLinks)) 
      @method('PUT')
    @else
      <input type="hidden" name="user_id" value="{{$performer->user->id}}">
      <input type="hidden" name="redirect_to" value="performers/{{ $performer->id}}" >
    @endif
    @foreach($platforms as $index=>$platform) 
      <label class="label" for="{{ $index }}">{{ $platform }}</label>
      <input class="input" type="text" name="{{ $index }}" value="{{ $socialLinks[$index] }}">
    @endforeach
    <input class="btn" type="submit" value="{{ isset($socialLinks) ? 'Update Social Links' : 'Add Social Links' }}">
  </form>
  <form action="/performers/{{ $performer->id }}" method="POST">
    {{ csrf_field() }}
    @method('DELETE')
    <input class="btn btn--danger" type="submit" value="Delete Performer">
  </form>
 
@endsection