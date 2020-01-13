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
    <input type="text" id="facebook" name="facebook" placeholder="Facebook URL">
    <input type="text" id="instagram" name="instagram" placeholder="Instagram Handle">
    <input type="text" id="twitter" name="twitter" placeholder="Twitter Handle">
    <input type="text" id="youtube" name="youtube" placeholder="Youtube">
    <input type="text" id="website" name="website" placeholder="Website">
    <input type="submit" value="Submit">
  </form>
@endsection