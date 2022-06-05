@extends('layout.private')
@section('title', 'GoToConsult - Edit Customer')
@section('content')
<?php $lang = app()->getLocale();?>
<div class="admin-wrapper">
    @include('elements.admin_sidebar')
    <div class="content-wrapper adminprof">
        <div class="single-page">
            <div class="page-heading">
                <a href="{{ $lang == 'en' ? url('/customers') : url('/no/kunder') }}"><img src="{{ asset('images/back-pink.svg')}}" alt="icon"/></a>
                <h2>@lang('admin.edit_customer')</h2>
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
                        <button class="sp-f save-btn btn ml-3" id="image_save">Save</button>
                    </div>
                </div>
            </div>
            <div class="page-setting">
                <h2>@lang('admin.user_settings')</h2>
                <div class="page-seting-content">
                    <label>@lang('admin.first_name')</label>
                    <input type="text" id="first_name" class="first_name" value="{{$user->first_name}}">
                    <div class="alert" id="first_name_error"></div>
                    <label>@lang('admin.last_name')</label>
                    <input type="text" id="last_name" class="last_name" value="{{$user->last_name}}">
                    <div class="alert" id="last_name_error"></div>
                    <label>@lang('admin.email')</label>
                    <input type="text" id="email" class="email" value="{{$user->email}}" readonly>
                    <div class="alert" id="email_error"></div>
                    <label>@lang('admin.phone')</label>
                    <input type="text" id="phone" class="phone" value="{{$user->phone}}">
                    <div class="alert" id="phone_error"></div>
                    <button class="sp-f cs save-btn btn" id="profile_save">@lang('admin.save')</button>
                </div>
            </div>
            <div class="page-setting meta-info">
                <h2>@lang('admin.change_password')</h2>
                <div class="page-seting-content">
                    <label>@lang('member.old_password')</label>
                    <input type="password" id="old_password">
                    <div class="alert" id="old_password_error"></div>
                    <label>@lang('member.new_password')</label>
                    <input type="password" id="new_password">
                    <button class="sp-f cs save-btn btn" id="password_save">@lang('member.save')</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
	const customer = @json($customer);
    editCustomer(customer);
</script>
@endsection