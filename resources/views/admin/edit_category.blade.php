@extends('layout.private')
@section('title', 'GoToConsult - Edit Category')
@section('content')
<?php $lang = app()->getLocale();?>
<div class="admin-wrapper">
    @include('elements.admin_sidebar')
    <div class="content-wrapper adminprof">
        <div class="single-page">
            <div class="page-heading">
                <a href="{{ $lang == 'en' ? url('/categories') : url('/no/kategorier') }}"><img src="{{ asset('images/back-pink.svg')}}" alt="icon"/></a>
                <h2>@lang('admin.edit_category')</h2>
            </div>
            <div class="profile-uploader">
                <div class="imageupload log-setting-up">
                    <h2>@lang('admin.profile_image')</h2>
                    <div class="d-flex">
                        <label class="btn btn-file">
                            <div class="avatar category"></div>
                            <button class="btn up-img">@lang('member.upload_image')</button>
                            <input type="file" id="upload_file" name="image-file">
                            <input type="hidden" id="avatar">
                        </label>
                        <button class="sp-f save-btn btn ml-3" id="image_save">Save</button>
                    </div>
                </div>
            </div>
            <div class="page-setting">
                <h2>@lang('admin.category_settings')</h2>
                <div class="page-seting-content">
                    <label>@lang('admin.en_category_name')</label>
                    <input type="text" id="category_name" class="category_name" value="{{$category->category_name}}">
                    <label>@lang('admin.no_category_name')</label>
                    <input type="text" id="category_name_no" class="category_name" value="{{$category->category_name_no}}">
                    <label>@lang('admin.category_url')</label>
                    <div class="link-input d-flex">
                        <a href="#">https://gotoconsult.com/category/</a>
                        <input type="text" id="category_url" class="category_url" value="{{$category->category_url}}">
                    </div>
    
                    <label>@lang('admin.category_vat')</label>
                    <input type="text" id="category_vat" class="category_vat" value="{{$category->vat}}">
                    
                    <label>@lang('admin.en_category_description')</label>
                    <textarea id="category_description" class="category_description">{{$category->category_description}} </textarea>
                    <label>@lang('admin.no_category_description')</label>
                    <textarea id="category_description_no" class="category_description">{{$category->category_description_no}} </textarea>
                    <button class="sp-f cs save-btn btn" id="profile_save">@lang('admin.save')</button>
                </div>
            </div>
            <div class="page-setting meta-info">
                <h2>@lang('admin.meta_information')</h2>
                <div class="page-seting-content">
                    <label>@lang('admin.meta_title')</label>
                    <input type="text" id="meta_title" class="meta_title" value="{{$category->meta_title}}">
                    <div class="alert" id="meta_title_error"></div>
                    <label>@lang('admin.meta_description')</label>
                    <textarea rows="4" id="meta_description" class="meta_description" >{{$category->meta_description}}</textarea>
                    <div class="alert" id="meta_description_error"></div>
                    <button class="sp-f cs save-btn btn" id="meta_save">@lang('admin.save')</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
	const category = @json($category);
    editCategory(category);
</script>
@endsection
