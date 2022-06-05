@extends('layout.public')
@section('title', $title)
@section('description', $description)
@section('content')
<div class="login-page-container">
  <div class="login-sec">
    <h1>@lang('forms.forgot_password')</h1>
    <form id="forgot-form" class="pt-5" method="POST" action="{{ url('/send_reset_password_request') }}">
      @csrf
      @if ($alert = Session::get('alert-success'))
      <div class="alert alert-success">
        {{ $alert }}
      </div>
      @elseif ($alert = Session::get('alert-error'))
      <div class="alert alert-error">
        {{ $alert }}
      </div>
      @endif
      <div class="form-group">
        <label for="email">@lang('forms.email')</label>
        <input type="email" class="form-control" id="email"  name="email" required>
        @if ($errors->has('email'))
        <span class="feedback" role="alert">
          <strong>{{ $errors->first('email') }}</strong>
        </span>
        @endif
      </div>
      <div class="form-btn d-flex">
        <button type="submit" class="btn btn-primary send">@lang('forms.btn-send')</button>
      </div>
    </form>
  </div>
  <div class="d-flex justify-content-center text-center pt-2">
    <a class="nav-link" href="{{$lang=='en' ? url('/login') : url('/no/logg-inn')}}">@lang('forms.login_account')</a>
  </div>
</div>
@endsection
@section('scripts')
<script>
    jQuery(function(){
      public();
      authenticator();
      forgotPassword();
	});
</script>
@endsection