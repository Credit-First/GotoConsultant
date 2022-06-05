@extends('layout.private')
@section('title', 'GoToConsult - Create Customer')
@section('content')
<?php $lang = app()->getLocale();?>
<div class="admin-wrapper">
    @include('elements.admin_sidebar')
    <div class="content-wrapper adminprof">
        <div class="single-page">
            <div class="page-heading">
                <a href="{{ $lang == 'en' ? url('/customers') : url('/no/kunder') }}"><img src="{{ asset('images/back-pink.svg')}}" alt="icon"/></a>
                <h2>@lang('admin.create_customer')</h2>
            </div>
            <div class="profile-uploader">
                <div class="imageupload log-setting-up">
                    <h2>@lang('admin.profile_image')</h2>
                    <div class="d-flex">
                        <label class="btn btn-file">
                            <div class="avatar"></div>
                            <button class="btn up-img">@lang('member.upload_image')</button>
                            <input type="file" id="upload_file" name="image-file">
                            <input type="hidden" id="avatar">
                        </label>
                    </div>
                </div>
            </div>
            <div class="page-setting">
                <h2>@lang('admin.user_settings')</h2>
                <div class="page-seting-content">
                    <label>@lang('admin.first_name')</label>
                    <input type="text" id="first_name" class="first_name">
                    <div class="alert" id="first_name_error"></div>
                    <label>@lang('admin.last_name')</label>
                    <input type="text" id="last_name" class="last_name">
                    <div class="alert" id="last_name_error"></div>
                    <label>@lang('admin.email')</label>
                    <input type="text" id="email" class="email">
                    <div class="alert" id="email_error"></div>
                    <label>@lang('admin.phone')</label>
                    <input type="text" id="phone" class="phone">
                    <div class="alert" id="phone_error"></div>
                    <label>@lang('admin.password')</label>
                    <input type="password" id="password">
                    <div class="alert" id="password_error"></div>
                    <input type="hidden" id="hidden_id" >
                    <button class="sp-f cs save-btn btn" id="profile_save">@lang('admin.save')</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
	createCustomer();
</script>
@endsection