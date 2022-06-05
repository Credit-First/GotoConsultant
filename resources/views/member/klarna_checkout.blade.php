@extends('layout.member')
@section('title', "Klarna Checkout")
@section('description', "Klarna Checkout API")
@section('content')
<div class="member-wrapper">
  @include('elements.member_sidebar')
  <div class="content-wrapper">
    {!! $html_snippet !!}
  </div>
</div>
@endsection