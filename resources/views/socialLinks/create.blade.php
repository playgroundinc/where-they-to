@extends('layout')

@section('content')
  <h1>Add Social Links</h1>
  <form action="/social-links" method="POST">
  {{ csrf_field() }}
    @if(isset($user_id))
      <input type="hidden" name="user_id" value="{{ $user_id }}">
    @elseif (isset($family_id)) 
      <input type="hidden" name="family_id" value="{{ $family_id }}">
    @endif
    <label for="facebook" class="label">Facebook</label>
    <input class="input" type="text" id="facebook" name="facebook">
    <label for="instagram" class="label">Instagram</label>
    <input class="input" type="text" id="instagram" name="instagram">
    <label for="twitter" class="label">Twitter</label>
    <input class="input" type="text" id="twitter" name="twitter">
    <label for="youtube" class="label">YouTube</label>
    <input class="input" type="text" id="youtube" name="youtube">
    <label for="website" class="label">Website</label>
    <input class="input" type="text" id="website" name="website">
    <input class="btn" type="submit" value="Submit">
  </form>
@endsection