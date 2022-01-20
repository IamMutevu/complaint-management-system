@extends('layouts.app')

@section('content')
<div class="jumbotron">
  <h1 class="display-4">Hello there!</h1>
  <p class="lead">This is a your dashboard. You can get an overview of your interactions with the system.</p>
  <hr class="my-4">
  <p>It is our pleasure for us to improve our services based on your feedback.</p>
  <a class="btn btn-primary btn-lg" href="{{ route('complaints')}}" role="button">File a complaint</a>
</div> 
@endsection
