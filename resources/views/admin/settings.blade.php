@extends('layout.private')
@section('title', 'GoToConsult - Settings')
@section('content')
<?php $lang = app()->getLocale();?>
<div class="admin-wrapper">
	@include('elements.admin_sidebar')
	<div class="content-wrapper adminprof">
		<div class="single-page">
			<div class="page-heading">
				<h2>@lang('admin.settings')</h2>
			</div>
			<input type="hidden" id="user_id" value="{{auth()->user()->id}}">
			<div class="page-setting setting-info">
				<h2>@lang('admin.mail_settings')</h2>
				<div class="page-seting-content">
					<label>@lang('admin.old_email')</label>
					<input type="text" id="old_mail" value="{{auth()->user()->email}}">
					<div class="alert" id="old_mail_error"></div>
					<label>@lang('admin.new_email')</label>
					<input type="text" id="new_mail">
					<div class="alert" id="new_mail_error"></div>
					<button class="sp-f cs save-btn btn" id="mail_save">@lang('admin.save')</button>
				</div>
			</div>
			<div class="page-setting setting-info">
				<h2>@lang('admin.manage_fee')</h2>
				<div class="page-seting-content">
					<label>@lang('admin.fee_percent')</label>
					<input type="text" id="fee" value="{{auth()->user()->fee}}">
					<button class="sp-f cs save-btn btn" id="private_save">@lang('admin.save')</button>
				</div>
			</div>
			<div class="page-setting setting-info">
				<h2>@lang('admin.password_settings')</h2>
				<div class="page-seting-content">
					<label>@lang('admin.old_password')</label>
					<input type="password" id="old_password">
					<div class="alert" id="old_password_error"></div>
					<label>@lang('admin.new_password')</label>
					<input type="password" id="new_password">
					<div class="alert" id="new_password_error"></div>
					<button class="sp-f cs save-btn btn" id="password_save">@lang('admin.save')</button>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script>
	settings();
</script>
@endsection