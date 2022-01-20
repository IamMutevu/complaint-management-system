@extends('layouts.app')

@section('content')
<div class="jumbotron">
  <h1 class="display-4">Hello!</h1>
  <p class="lead">This is your dashboard. It provides you with an overview of what is happening in the system</p>
  <hr class="my-4">
  <p>You can view complaints filed by patients here</p>
  <a class="btn btn-primary btn-lg" href="{{ route('complaints')}}" role="button">View complaints</a>
</div> 
@endsection
