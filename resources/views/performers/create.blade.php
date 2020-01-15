@extends('layout')

@section('content')
  <h1>Create a Performer profile</h1>
  <form method="POST" action="/performers">
    {{ csrf_field() }}
    <div>
      <input type="hidden" name="user_id" value={{ $user_id }}>
      <label for="name" class="label">Name</label>
      <input class="input" type="text" name="name">
      <label for="bio" class="label">Performer Bio</label>
      <textarea class="input" name="bio" id="bio" cols="30" rows="10"></textarea>
    </div>
    <label class="label" for="performerType">Type</label>
    <select class="input" name="performerType" id="performerType"> 
      @foreach($performerTypes as $index=>$type)
        <option value="{{ $type->id }}" {{ intval($index) === 0 ? 'selected' : '' }}>{{ $type->name }}</option>
      @endforeach
    </select>
    <input class="btn" type="submit" value="Create Profile">
  </form>

  <h1>Add Social Links</h1>
  <form action="/social-links" method="POST">
  {{ csrf_field() }}
    <input type="hidden" name="user_id" value={{ $id ?? null}}>
    <label for="facebook" class="label">Facebook</label>
    <input class="input" type="text" id="facebook" name="facebook" placeholder="Facebook URL">
    <label for="instagram" class="label">Instagram</label>
    <input class="input" type="text" id="instagram" name="instagram" placeholder="Instagram Handle">
    <label for="twitter" class="label">Twitter</label>
    <input class="input" type="text" id="twitter" name="twitter" placeholder="Twitter Handle">
    <label for="youtube" class="label">YouTube</label>
    <input class="input" type="text" id="youtube" name="youtube" placeholder="Youtube">
    <label for="website" class="label">Website</label>
    <input class="input" type="text" id="website" name="website" placeholder="Website">
    <input class="btn" type="submit" value="Submit">
  </form>
@endsection