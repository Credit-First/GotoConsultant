@extends('layout.public')
@section('title', $title)
@section('description', $description)
@section('content')
<div class="login-page-container">
  <div class="login-sec">
    <h1>@lang('forms.reset_password')</h1>
    <form id="reset-form" class="pt-5" method="POST" action="{{ url('/api/reset-password') }}">
      @csrf
      @if ($alert = Session::get('alert-success'))
        <div class="alert alert-error">
          {{ $alert }}
        </div>
      @endif
      <input type="hidden" value="{{$id}}" name="id" />
      <div class="form-group password-sec">
        <label for="password">@lang('forms.password')</label>
        <input type="password" class="form-control" id="password" name="password" required>
        @if ($errors->has('password'))
        <span class="feedback" role="alert">
          <strong>{{ $errors->first('password') }}</strong>
        </span>
        @endif
      </div>
      <div class="form-group password-sec">
        <label for="confirm_password">@lang('forms.confirm_password')</label>
        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
        @if ($errors->has('confirm_password'))
        <span class="feedback" role="alert">
          <strong>{{ $errors->first('confirm_password') }}</strong>
        </span>
        @endif
      </div>
      <div class="form-btn d-flex">
        <button type="submit" class="btn btn-primary send">@lang('forms.btn-send')</button>
      </div>
    </form>
  </div>
</div>
@endsection
@section('scripts')
<script>
  jQuery(function(){
    public();
    authenticator();
    resetPassword();
	});
</script>
@endsection