@extends('layout.private')
@section('title', 'GoToConsult - Edit Page')
@section('content')
<?php $lang = app()->getLocale();?>
<div class="admin-wrapper">
    @include('elements.admin_sidebar')
    <div class="content-wrapper adminprof">
        <div class="single-page">
            <div class="page-heading">
                <a href="{{ $lang == 'en' ? url('/pages') : url('/no/sider') }}"><img src="{{ asset('images/back-pink.svg')}}" alt="icon"/></a>
                <h2>@lang('admin.edit_page')</h2>
            </div>
            <div class="page-setting">
                <h2>@lang('admin.page_settings')</h2>
                <div class="page-seting-content">
                    <input type="hidden" id="hidden_id" value="{{$page->id}}">
                    <label>@lang('admin.page_name')</label>
                    <input type="text" name="page_name" id="page_name" value="{{$page->page_name}}"/>
                    <div class="alert" id="page_name_error"></div>
                    <label>@lang('admin.page_url')</label>
                    <div class="link-input d-flex">
                        <a href="#">https://gotoconsult.com/</a>
                        <input type="text" name="page_url" id="page_url" value="{{$page->page_url}}"/>
                        <div class="alert" id="page_url_error"></div>
                    </div>
                    <button type="button" id="page_save" class="sp-f save-btn btn cs" >@lang('admin.save')</button>
                </div>
            </div>
            @if($page->id == 63)
            <div class="page-setting meta-info double-multi">
                <div class="profile-uploader">
                    <div class="imageupload log-setting-up">
                        <label class="btn btn-file">
                            @lang('admin.banner_desktop_image')
                            <input type="file" class="banner_desktop_file" name="image-file">
                        </label>
                        <label class="btn btn-file">
                            @lang('admin.banner_mobile_image')
                            <input type="file" class="banner_mobile_file" name="image-file">
                        </label>
                    </div>
                </div>
                <div class="page-setting meta-info multi">
                    <div class="admin page-seting-content">
                        <h2>Header Part (English)</h2>
                        <label>Title</label>
                        <input type="text" id="header_en_title" value="{{$page_body->en_header->title}}" >
                        <label>Description</label>
                        <input type="text" id="header_en_description" value="{{$page_body->en_header->description}}" >
                        <label>Button</label>
                        <input type="text" id="header_en_button1" value="{{$page_body->en_header->button_title1}}" >
                        <label>Button Link</label>
                        <input type="text" id="header_en_button_link1" value="{{$page_body->en_header->button_link1}}" >
                        <label>Button</label>
                        <input type="text" id="header_en_button2" value="{{$page_body->en_header->button_title2}}" >
                        <label>Button Link</label>
                        <input type="text" id="header_en_button_link2" value="{{$page_body->en_header->button_link2}}" >
                        <button class="sp-f cs save-btn btn" id="en_header_save">@lang('admin.save')</button>
                    </div>
                    <div class="admin page-seting-content">
                        <h2>Header Part (Norwegian)</h2>
                        <label>Title</label>
                        <input type="text" id="header_no_title" value="{{$page_body->no_header->title}}" >
                        <label>Description</label>
                        <input type="text" id="header_no_description" value="{{$page_body->no_header->description}}" >
                        <label>Button</label>
                        <input type="text" id="header_no_button1" value="{{$page_body->no_header->button_title1}}" >
                        <label>Button Link</label>
                        <input type="text" id="header_no_button_link1" value="{{$page_body->no_header->button_link1}}" >
                        <label>Button</label>
                        <input type="text" id="header_no_button2" value="{{$page_body->no_header->button_title2}}" >
                        <label>Button Link</label>
                        <input type="text" id="header_no_button_link2" value="{{$page_body->no_header->button_link2}}" >
                        <button class="sp-f cs save-btn btn" id="no_header_save">@lang('admin.save')</button>
                    </div>
                </div>
            </div>
            <div class="page-setting toggle-content">
                <h2>Description with Image</h2>
                <button class="sp-f btn add" id="home_help_add"><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="plus-square" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-plus-square fa-w-14 fa-lg"><path fill="currentColor" d="M352 240v32c0 6.6-5.4 12-12 12h-88v88c0 6.6-5.4 12-12 12h-32c-6.6 0-12-5.4-12-12v-88h-88c-6.6 0-12-5.4-12-12v-32c0-6.6 5.4-12 12-12h88v-88c0-6.6 5.4-12 12-12h32c6.6 0 12 5.4 12 12v88h88c6.6 0 12 5.4 12 12zm96-160v352c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V80c0-26.5 21.5-48 48-48h352c26.5 0 48 21.5 48 48zm-48 346V86c0-3.3-2.7-6-6-6H54c-3.3 0-6 2.7-6 6v340c0 3.3 2.7 6 6 6h340c3.3 0 6-2.7 6-6z" class=""></path></svg></button>
                <div class="help-group">
                    @foreach($page_body->help_list as $key => $item)
                    <div class="panel panel-default" id="home_help_panel{{$key}}">
                        <a class="remove_help_item remove_btn" data-key={{$key}}><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="trash-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-trash-alt fa-w-14 fa-lg"><path fill="currentColor" d="M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z"></path></svg></a>
                        <div class="panel-heading">
                            <div class="toggle-input" data-toggle="collapse" href="#help_collapse{{$key}}">
                                <span class="glyphicon glyphicon-menu-right"></span>
                                <input type="text" id="help_en_title{{$key}}" value="{{$item->en_title}}" >
                            </div>
                        </div>
                        <div id="help_collapse{{$key}}" class="panel-collapse collapse">
                            <div class="panel-body">
                                <input type="file" class="help_file" data-id="{{$key}}" accept="image/*">
                                <input type='hidden' id="help_path{{$key}}" value="{{$item->path}}">
                                <label>Description (English)</label>
                                <textarea rows="5" cols="150" class="form-control" id="help_en_des{{$key}}">{{$item->en_des}}</textarea>
                                <label>Title (Norwegian)</label>
                                <input type="text" id="help_no_title{{$key}}" value="{{$item->no_title}}" >
                                <label>Description (Norwegian)</label>
                                <textarea rows="5" cols="150" class="form-control" id="help_no_des{{$key}}">{{$item->no_des}}</textarea>                                    
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <button class="sp-f cs save-btn btn" id="home_help_save">@lang('admin.save')</button>
            </div>
            <div class="page-setting page-seting-content meta-info">
                <h2>Benefit Part</h2>
                <label>Title (English)</label>
                <input type="text" id="en_benefit_title" value="{{$page_body->benefit_list->en_title}}" >
                <label>Title (Norwegian)</label>
                <input type="text" id="no_benefit_title" value="{{$page_body->benefit_list->no_title}}" >
                <button class="sp-f cs save-btn btn benefit_title_save">@lang('admin.save')</button>
            </div>
            <div class="page-setting toggle-content">
                <h2>Benefit Item List</h2>
                <button class="sp-f btn add" id="home_benefit_add"><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="plus-square" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-plus-square fa-w-14 fa-lg"><path fill="currentColor" d="M352 240v32c0 6.6-5.4 12-12 12h-88v88c0 6.6-5.4 12-12 12h-32c-6.6 0-12-5.4-12-12v-88h-88c-6.6 0-12-5.4-12-12v-32c0-6.6 5.4-12 12-12h88v-88c0-6.6 5.4-12 12-12h32c6.6 0 12 5.4 12 12v88h88c6.6 0 12 5.4 12 12zm96-160v352c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V80c0-26.5 21.5-48 48-48h352c26.5 0 48 21.5 48 48zm-48 346V86c0-3.3-2.7-6-6-6H54c-3.3 0-6 2.7-6 6v340c0 3.3 2.7 6 6 6h340c3.3 0 6-2.7 6-6z" class=""></path></svg></button>
                <div class="benefit-group">
                    @foreach($page_body->benefit_list->arr as $key => $item)
                    <div class="panel panel-default" id="home_benefit_panel{{$key}}">
                        <a class="remove_benefit_item remove_btn" data-key={{$key}}><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="trash-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-trash-alt fa-w-14 fa-lg"><path fill="currentColor" d="M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z"></path></svg></a>
                        <div class="panel-heading">
                            <div class="toggle-input" data-toggle="collapse" href="#benefit_collapse{{$key}}">
                                <span class="glyphicon glyphicon-menu-right"></span>
                                <input type="text" id="benefit_en_title{{$key}}" value="{{$item->en_title}}" >
                            </div>
                        </div>
                        <div id="benefit_collapse{{$key}}" class="panel-collapse collapse">
                            <div class="panel-body">
                                <input type="file" class="icon_file" data-key="{{$key}}" accept="image/*">
                                <input type="hidden" id="benefit_icon{{$key}}" value="{{$item->path}}">
                                <label>Title (Norwegian)</label>
                                <input type="text" id="benefit_no_title{{$key}}" value="{{$item->no_title}}" >
                                <label>Description (English)</label>
                                <textarea rows="5" cols="150" class="form-control" id="benefit_en_des{{$key}}">{{$item->en_des}}</textarea>
                                <label>Description (Norwegian)</label>
                                <textarea rows="5" cols="150" class="form-control" id="benefit_no_des{{$key}}">{{$item->no_des}}</textarea>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <button class="sp-f cs save-btn btn" id="home_benefit_save">@lang('admin.save')</button>
            </div>
            <div class="page-setting page-seting-content meta-info">
                <h2>Review Part</h2>
                <label>Title (English)</label>
                <input type="text" id="en_review_title" value="{{$page_body->reviews->en_title}}" >
                <label>Title (Norwegian)</label>
                <input type="text" id="no_review_title" value="{{$page_body->reviews->no_title}}" >
                <button class="sp-f cs save-btn btn review_title_save">@lang('admin.save')</button>
            </div>
            <div class="page-setting toggle-content meta-info">
                <h2>Footer</h2>
                <div class="page-seting-content">
                    <div class="d-flex flex-column">
                        <label>Title (English)</label>
                        <input type="text" id="home_footer_en_title" value="{{$page_body->footer->en_title}}" >
                    </div>
                    <div class="d-flex flex-column">
                        <label>Title (Norwegian)</label>
                        <input type="text" id="home_footer_no_title" value="{{$page_body->footer->no_title}}" >
                    </div>
                </div>
                <div class="d-flex flex-column">
                    <div class="d-flex flex-column">
                        <label>Description (English)</label>
                        <textarea rows="5" cols="150" class="form-control" id="home_footer_en_des">{{$page_body->footer->en_des}}</textarea>
                    </div>
                    <div class="d-flex flex-column">
                        <label>Description (Norwegian)</label>
                        <textarea rows="5" cols="150" class="form-control" id="home_footer_no_des">{{$page_body->footer->no_des}}</textarea>
                    </div>
                </div>
                <div class="page-seting-content multi">
                    <div class="sub-page-setting">
                        <div class="d-flex flex-column">
                            <label>Button Title (English)</label>
                            <input type="text" id="home_footer_en_btn_title1" value="{{$page_body->footer->en_btn_title1}}" >
                        </div>
                        <div class="d-flex flex-column">
                            <label>Button Link (English)</label>
                            <input type="text" id="home_footer_en_btn_link1" value="{{$page_body->footer->en_btn_link1}}" >
                        </div>
                    </div>
                    <div class="sub-page-setting">
                        <div class="d-flex flex-column">
                            <label>Button Title (Norwegian)</label>
                            <input type="text" id="home_footer_no_btn_title1" value="{{$page_body->footer->no_btn_title1}}" >
                        </div>
                        <div class="d-flex flex-column">
                            <label>Button Link (Norwegian)</label>
                            <input type="text" id="home_footer_no_btn_link1" value="{{$page_body->footer->no_btn_link1}}" >
                        </div>
                    </div>
                </div>
                <div class="page-seting-content multi">
                    <div class="sub-page-setting">
                        <div class="d-flex flex-column">
                            <label>Button Title (English)</label>
                            <input type="text" id="home_footer_en_btn_title2" value="{{$page_body->footer->en_btn_title2}}" >
                        </div>
                        <div class="d-flex flex-column">
                            <label>Button Link (English)</label>
                            <input type="text" id="home_footer_en_btn_link2" value="{{$page_body->footer->en_btn_link2}}" >
                        </div>
                    </div>
                    <div class="sub-page-setting">
                        <div class="d-flex flex-column">
                            <label>Button Title (Norwegian)</label>
                            <input type="text" id="home_footer_no_btn_title2" value="{{$page_body->footer->no_btn_title2}}" >
                        </div>
                        <div class="d-flex flex-column">
                            <label>Button Link (Norwegian)</label>
                            <input type="text" id="home_footer_no_btn_link2" value="{{$page_body->footer->no_btn_link2}}" >
                        </div>
                    </div>
                </div>
                <button class="sp-f cs save-btn btn" id="home_footer_save">@lang('admin.save')</button>
            </div>
            @elseif($page->id == 1)
            <div class="page-setting page-seting-content meta-info">
                <h2>Review Part</h2>
                <label>Title (English)</label>
                <input type="text" id="en_review_title" value="{{$page_body->review_list->en_title}}" >
                <label>Title (Norwegian)</label>
                <input type="text" id="no_review_title" value="{{$page_body->review_list->no_title}}" >
                <button class="sp-f cs save-btn btn review_title_save">@lang('admin.save')</button>
            </div>
            <div class="page-setting toggle-content">
                <h2>Review Item List</h2>
                <button class="sp-f btn add" id="cat_review_add"><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="plus-square" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-plus-square fa-w-14 fa-lg"><path fill="currentColor" d="M352 240v32c0 6.6-5.4 12-12 12h-88v88c0 6.6-5.4 12-12 12h-32c-6.6 0-12-5.4-12-12v-88h-88c-6.6 0-12-5.4-12-12v-32c0-6.6 5.4-12 12-12h88v-88c0-6.6 5.4-12 12-12h32c6.6 0 12 5.4 12 12v88h88c6.6 0 12 5.4 12 12zm96-160v352c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V80c0-26.5 21.5-48 48-48h352c26.5 0 48 21.5 48 48zm-48 346V86c0-3.3-2.7-6-6-6H54c-3.3 0-6 2.7-6 6v340c0 3.3 2.7 6 6 6h340c3.3 0 6-2.7 6-6z" class=""></path></svg></button>
                <div class="cat-review-group">
                    @foreach($page_body->review_list->arr as $key => $item)
                    <div class="panel panel-default" id="cat_review_panel{{$key}}">
                        <a class="remove_review_item remove_btn" data-key={{$key}}><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="trash-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-trash-alt fa-w-14 fa-lg"><path fill="currentColor" d="M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z"></path></svg></a>
                        <div class="panel-heading">
                            <div class="toggle-input" data-toggle="collapse" href="#cat_review_collapse{{$key}}">
                                <span class="glyphicon glyphicon-menu-right"></span>
                                <input type="text" id="cat_author{{$key}}" value="{{$item->name}}" >
                            </div>
                        </div>
                        <div id="cat_review_collapse{{$key}}" class="panel-collapse collapse">
                            <div class="panel-body">
                                <input type="file" class="cat_review_file" data-key="{{$key}}" accept="image/*">
                                <input type="hidden" id="cat_review_path{{$key}}" value="{{$item->path}}">
                                <label>Description (English)</label>
                                <textarea rows="5" cols="150" class="form-control" id="cat_review_en_des{{$key}}">{{$item->en_des}}</textarea>
                                <label>Description (Norwegian)</label>
                                <textarea rows="5" cols="150" class="form-control" id="cat_review_no_des{{$key}}">{{$item->no_des}}</textarea>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <button class="sp-f cs save-btn btn" id="cat_review_save">@lang('admin.save')</button>
            </div>
            @elseif($page->id == 2)
            <div class="page-setting meta-info multi">
                <div class="admin page-seting-content">
                    <h2>Header Part (English)</h2>
                    <label>Title</label>
                    <input type="text" id="header_en_title" value="{{$page_body->en_header->title}}" >
                    <label>Description</label>
                    <textarea rows="3" cols="100" class="form-control" id="header_en_description">{{$page_body->en_header->description}}</textarea>
                    <button class="sp-f cs save-btn btn" id="en_header_save">@lang('admin.save')</button>
                </div>
                <div class="admin page-seting-content">
                    <h2>Header Part (Norwegian)</h2>
                    <label>Title</label>
                    <input type="text" id="header_no_title" value="{{$page_body->no_header->title}}" >
                    <label>Description</label>
                    <textarea rows="3" cols="100" class="form-control" id="header_no_description">{{$page_body->no_header->description}}</textarea>
                    <button class="sp-f cs save-btn btn" id="no_header_save">@lang('admin.save')</button>
                </div>
            </div>
            <div class="flex-row">
                <div class="page-setting toggle-content">
                    <h2>Constulatation Platform Item</h2>
                    <button class="sp-f btn add" id="platform_add"><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="plus-square" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-plus-square fa-w-14 fa-lg"><path fill="currentColor" d="M352 240v32c0 6.6-5.4 12-12 12h-88v88c0 6.6-5.4 12-12 12h-32c-6.6 0-12-5.4-12-12v-88h-88c-6.6 0-12-5.4-12-12v-32c0-6.6 5.4-12 12-12h88v-88c0-6.6 5.4-12 12-12h32c6.6 0 12 5.4 12 12v88h88c6.6 0 12 5.4 12 12zm96-160v352c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V80c0-26.5 21.5-48 48-48h352c26.5 0 48 21.5 48 48zm-48 346V86c0-3.3-2.7-6-6-6H54c-3.3 0-6 2.7-6 6v340c0 3.3 2.7 6 6 6h340c3.3 0 6-2.7 6-6z" class=""></path></svg></button>
                    <div class="platform-group">
                        @foreach($page_body->list as $key => $item)
                        <div class="panel panel-default" id="platform_panel{{$key}}">
                            <a class="remove_plat_item remove_btn" data-key={{$key}}><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="trash-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-trash-alt fa-w-14 fa-lg"><path fill="currentColor" d="M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z"></path></svg></a>
                            <div class="panel-heading">
                                <div class="toggle-input" data-toggle="collapse" href="#plat_collapse{{$key}}">
                                    <span class="glyphicon glyphicon-menu-right"></span>
                                    <input type="text" id="en_platform_item_title{{$key}}" value="{{$item->en_title}}" >
                                </div>
                            </div>
                            <div id="plat_collapse{{$key}}" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <input type="file" class="become_consult_file" data-key="{{$key}}" accept="image/*">
                                    <input type='hidden' id="become_consult_icon{{$key}}" value="{{$item->path}}">
                                    <label>Description (English)</label>
                                    <textarea rows="5" cols="150" class="form-control" id="en_platform_des{{$key}}">{{$item->en_txt}}</textarea>
                                    <label>Title (Norwegian)</label>
                                    <input type="text" id="no_platform_item_title{{$key}}" value="{{$item->no_title}}" >
                                    <label>Description (Norwegian)</label>
                                    <textarea rows="5" cols="150" class="form-control" id="no_platform_des{{$key}}">{{$item->no_txt}}</textarea>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <button class="sp-f cs save-btn btn" id="become_plat_save">@lang('admin.save')</button>
                </div>
            </div>
            @elseif($page->id == 3)
            <div class="page-setting meta-info double-multi">
                <div class="profile-uploader">
                    <div class="imageupload log-setting-up">
                        <label class="btn btn-file">
                            @lang('admin.banner_desktop_image')
                            <input type="file" class="banner_desktop_file" name="image-file">
                        </label>
                        <label class="btn btn-file">
                            @lang('admin.banner_mobile_image')
                            <input type="file" class="banner_mobile_file" name="image-file">
                        </label>
                    </div>
                </div>
                <div class="admin page-seting-content">
                    <h2>Header Part (English)</h2>
                    <label>Title</label>
                    <input type="text" id="header_en_title" value="{{$page_body->en_header->title}}" >
                    <label>Description</label>
                    <textarea rows="5" cols="150" class="form-control" id="header_en_description">{{$page_body->en_header->description}}</textarea>
                    <button class="sp-f cs save-btn btn" id="en_header_save">@lang('admin.save')</button>
                </div>
                <div class="admin page-seting-content">
                    <h2>Header Part (Norwegian)</h2>
                    <label>Title</label>
                    <input type="text" id="header_no_title" value="{{$page_body->no_header->title}}" >
                    <label>Description</label>
                    <textarea rows="5" cols="150" class="form-control" id="header_no_description">{{$page_body->no_header->description}}</textarea>
                    <button class="sp-f cs save-btn btn" id="no_header_save">@lang('admin.save')</button>
                </div>
            </div>
            <div class="page-setting page-seting-content meta-info">
                <h2>Article Part</h2>
                <label>Title (English)</label>
                <input type="text" id="en_article_title" value="{{$page_body->article_list->en_title}}" >
                <label>Title (Norwegian)</label>
                <input type="text" id="no_article_title" value="{{$page_body->article_list->no_title}}" >
                <button class="sp-f cs save-btn btn article_title_save">@lang('admin.save')</button>
            </div>
            <div class="page-setting toggle-content meta-info">
                <h2>Article Items</h2>
                <button class="sp-f btn add" id="about_article_add"><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="plus-square" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-plus-square fa-w-14 fa-lg"><path fill="currentColor" d="M352 240v32c0 6.6-5.4 12-12 12h-88v88c0 6.6-5.4 12-12 12h-32c-6.6 0-12-5.4-12-12v-88h-88c-6.6 0-12-5.4-12-12v-32c0-6.6 5.4-12 12-12h88v-88c0-6.6 5.4-12 12-12h32c6.6 0 12 5.4 12 12v88h88c6.6 0 12 5.4 12 12zm96-160v352c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V80c0-26.5 21.5-48 48-48h352c26.5 0 48 21.5 48 48zm-48 346V86c0-3.3-2.7-6-6-6H54c-3.3 0-6 2.7-6 6v340c0 3.3 2.7 6 6 6h340c3.3 0 6-2.7 6-6z" class=""></path></svg></button>
                <div class="article-group">
                    @foreach($page_body->article_list->arr as $key => $item)
                    <div class="panel panel-default" id="about_article_panel{{$key}}">
                        <a class="remove_article_item remove_btn" data-key={{$key}}><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="trash-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-trash-alt fa-w-14 fa-lg"><path fill="currentColor" d="M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z"></path></svg></a>
                        <div class="panel-heading">
                            <div class="toggle-input" data-toggle="collapse" href="#article_collapse{{$key}}">
                                <span class="glyphicon glyphicon-menu-right"></span>
                                <input type="text" id="article_en_title{{$key}}" value="{{$item->en_title}}" >
                            </div>
                        </div>
                        <div id="article_collapse{{$key}}" class="panel-collapse collapse">
                            <div class="panel-body">
                                <input type="file" class="article_file" data-key="{{$key}}" accept="image/*">
                                <input type="hidden" id="article_icon{{$key}}" value="{{$item->icon}}">
                                <label>Description (English)</label>
                                <textarea rows="5" cols="150" class="form-control" id="article_en_des{{$key}}">{{$item->en_des}}</textarea>
                                <label>Title (Norwegian)</label>
                                <input type="text" id="article_no_title{{$key}}" value="{{$item->no_title}}" >
                                <label>Description (Norwegian)</label>
                                <textarea rows="5" cols="150" class="form-control" id="article_no_des{{$key}}">{{$item->no_des}}</textarea>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <button class="sp-f cs save-btn btn" id="about_article_save">@lang('admin.save')</button>
            </div>
            <div class="page-setting meta-info">
                <div class="admin page-seting-content">
                    <h2>Story Part</h2>
                    <input type="file" class="story_file" accept="image/*">
                    <input type="hidden" id="story_path" value="{{$page_body->story->path}}">
                    <label>Title (English)</label>
                    <input type="text" id="en_story_title" value="{{$page_body->story->en_title}}" >
                    <label>Title (Norwegian)</label>
                    <input type="text" id="no_story_title" value="{{$page_body->story->no_title}}" >
                    <label>Description (English)</label>
                    <textarea rows="5" cols="150" class="form-control" id="en_story_des">{{$page_body->story->en_des}}</textarea>
                    <label>Description (Norwegian)</label>
                    <textarea rows="5" cols="150" class="form-control" id="no_story_des">{{$page_body->story->no_des}}</textarea>
                    <button class="sp-f cs save-btn btn" id="about_story_save">@lang('admin.save')</button>
                </div>
            </div>
            <div class="page-setting toggle-content meta-info">
                <h2>Article Items</h2>
                <button class="sp-f btn add" id="about_team_add"><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="plus-square" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-plus-square fa-w-14 fa-lg"><path fill="currentColor" d="M352 240v32c0 6.6-5.4 12-12 12h-88v88c0 6.6-5.4 12-12 12h-32c-6.6 0-12-5.4-12-12v-88h-88c-6.6 0-12-5.4-12-12v-32c0-6.6 5.4-12 12-12h88v-88c0-6.6 5.4-12 12-12h32c6.6 0 12 5.4 12 12v88h88c6.6 0 12 5.4 12 12zm96-160v352c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V80c0-26.5 21.5-48 48-48h352c26.5 0 48 21.5 48 48zm-48 346V86c0-3.3-2.7-6-6-6H54c-3.3 0-6 2.7-6 6v340c0 3.3 2.7 6 6 6h340c3.3 0 6-2.7 6-6z" class=""></path></svg></button>
                <div class="team-group">
                    @foreach($page_body->team as $key => $item)
                    <div class="panel panel-default" id="about_team_panel{{$key}}">
                        <a class="remove_team_item remove_btn" data-key={{$key}}><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="trash-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-trash-alt fa-w-14 fa-lg"><path fill="currentColor" d="M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z"></path></svg></a>
                        <div class="panel-heading">
                            <div class="toggle-input" data-toggle="collapse" href="#team_collapse{{$key}}">
                                <span class="glyphicon glyphicon-menu-right"></span>
                                <input type="text" id="team_member_name{{$key}}" value="{{$item->name}}" >
                            </div>
                        </div>
                        <div id="team_collapse{{$key}}" class="panel-collapse collapse">
                            <div class="panel-body">
                                <input type="file" class="team_member_file" data-key="{{$key}}" accept="image/*">
                                <input type="hidden" id="team_member_avatar{{$key}}" value="{{$item->avatar}}">
                                <label>Job (English)</label>
                                <input type="text" id="en_team_job{{$key}}" value="{{$item->en_job}}" >
                                <label>Job (Norwegian)</label>
                                <input type="text" id="no_team_job{{$key}}" value="{{$item->no_job}}" >
                                <label>Bio (English)</label>
                                <textarea rows="5" cols="150" class="form-control" id="en_team_bio{{$key}}">{{$item->en_bio}}</textarea>
                                <label>Bio (Norwegian)</label>
                                <textarea rows="5" cols="150" class="form-control" id="no_team_bio{{$key}}">{{$item->no_bio}}</textarea>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <button class="sp-f cs save-btn btn" id="about_team_member_save">@lang('admin.save')</button>
            </div>
            <div class="page-setting page-seting-content meta-info">
                <h2>Get Started Part</h2>
                <label>Title (English)</label>
                <input type="text" id="en_get_started_title" value="{{$page_body->get_started->en_title}}" >
                <label>Title (Norwegian)</label>
                <input type="text" id="no_get_started_title" value="{{$page_body->get_started->no_title}}" >
                <button class="sp-f cs save-btn btn about_get_started_save">@lang('admin.save')</button>
            </div>
            <div class="page-setting toggle-content meta-info">
                <h2>Get Started Items</h2>
                <button class="sp-f btn add" id="about_started_add"><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="plus-square" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-plus-square fa-w-14 fa-lg"><path fill="currentColor" d="M352 240v32c0 6.6-5.4 12-12 12h-88v88c0 6.6-5.4 12-12 12h-32c-6.6 0-12-5.4-12-12v-88h-88c-6.6 0-12-5.4-12-12v-32c0-6.6 5.4-12 12-12h88v-88c0-6.6 5.4-12 12-12h32c6.6 0 12 5.4 12 12v88h88c6.6 0 12 5.4 12 12zm96-160v352c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V80c0-26.5 21.5-48 48-48h352c26.5 0 48 21.5 48 48zm-48 346V86c0-3.3-2.7-6-6-6H54c-3.3 0-6 2.7-6 6v340c0 3.3 2.7 6 6 6h340c3.3 0 6-2.7 6-6z" class=""></path></svg></button>
                <div class="started-group">
                    @foreach($page_body->get_started->arr as $key => $item)
                    <div class="panel panel-default" id="about_started_panel{{$key}}">
                        <a class="remove_started_item remove_btn" data-key={{$key}}><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="trash-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-trash-alt fa-w-14 fa-lg"><path fill="currentColor" d="M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z"></path></svg></a>
                        <div class="panel-heading">
                            <div class="toggle-input" data-toggle="collapse" href="#started_collapse{{$key}}">
                                <span class="glyphicon glyphicon-menu-right"></span>
                                <input type="text" id="started_en_title{{$key}}" value="{{$item->en_title}}" >
                            </div>
                        </div>
                        <div id="started_collapse{{$key}}" class="panel-collapse collapse">
                            <div class="panel-body">
                                <label>Description (English)</label>
                                <textarea rows="5" cols="150" class="form-control" id="started_en_des{{$key}}">{{$item->en_des}}</textarea>
                                <label>Title (Norwegian)</label>
                                <input type="text" id="started_no_title{{$key}}" value="{{$item->no_title}}" >
                                <label>Description (Norwegian)</label>
                                <textarea rows="5" cols="150" class="form-control" id="started_no_des{{$key}}">{{$item->no_des}}</textarea>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <button class="sp-f cs save-btn btn" id="about_started_save">@lang('admin.save')</button>
            </div>
            @elseif($page->id == 4)
            <div class="page-setting meta-info">
                <div class="admin page-seting-content">
                    <h2>Header Part</h2>
                    <input type="file" class="faq_file" accept="image/*">
                    <input type="hidden" id="faq_path">
                    <label>Title (English)</label>
                    <input type="text" id="faq_header_en_title" value="{{$page_body->header->en_title}}" >
                    <label>Title (Norwegian)</label>
                    <input type="text" id="faq_header_no_title" value="{{$page_body->header->no_title}}" >
                    <label>Description (English)</label>
                    <textarea rows="5" cols="150" class="form-control" id="faq_header_en_des">{{$page_body->header->en_des}}</textarea>
                    <label>Description (Norwegian)</label>
                    <textarea rows="5" cols="150" class="form-control" id="faq_header_no_des">{{$page_body->header->no_des}}</textarea>
                    <button class="sp-f cs save-btn btn" id="faq_header_save">@lang('admin.save')</button>
                </div>
            </div>
            <div class="page-setting meta-info">
                <div class="admin page-seting-content">
                    <h2>Question Header Part</h2>
                    <label>Title (English)</label>
                    <input type="text" id="faq_question_header_en_title" value="{{$page_body->question_header->en_title}}" >
                    <label>Title (Norwegian)</label>
                    <input type="text" id="faq_question_header_no_title" value="{{$page_body->question_header->no_title}}" >
                    <label>Message Title (English)</label>
                    <input type="text" id="faq_question_message_en_title" value="{{$page_body->question_header->en_msg_title}}" >
                    <label>Message (Norwegian)</label>
                    <input type="text" id="faq_question_message_no_title" value="{{$page_body->question_header->no_msg_title}}" >
                    <button class="sp-f cs save-btn btn" id="faq_question_header_save">@lang('admin.save')</button>
                </div>
            </div>
            <div class="page-setting toggle-content">
                <h2>Questions</h2>
                <button class="sp-f btn add" id="faq_question_add"><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="plus-square" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-plus-square fa-w-14 fa-lg"><path fill="currentColor" d="M352 240v32c0 6.6-5.4 12-12 12h-88v88c0 6.6-5.4 12-12 12h-32c-6.6 0-12-5.4-12-12v-88h-88c-6.6 0-12-5.4-12-12v-32c0-6.6 5.4-12 12-12h88v-88c0-6.6 5.4-12 12-12h32c6.6 0 12 5.4 12 12v88h88c6.6 0 12 5.4 12 12zm96-160v352c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V80c0-26.5 21.5-48 48-48h352c26.5 0 48 21.5 48 48zm-48 346V86c0-3.3-2.7-6-6-6H54c-3.3 0-6 2.7-6 6v340c0 3.3 2.7 6 6 6h340c3.3 0 6-2.7 6-6z" class=""></path></svg></button>
                <div class="question-group">
                    @foreach($page_body->questions as $key => $item)
                    <div class="panel panel-default" id="faq_panel{{$key}}">
                        <a class="remove_question_item remove_btn" data-key={{$key}}><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="trash-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-trash-alt fa-w-14 fa-lg"><path fill="currentColor" d="M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z"></path></svg></a>
                        <div class="panel-heading">
                            <div class="toggle-input" data-toggle="collapse" href="#faq_collapse{{$key}}">
                                <span class="glyphicon glyphicon-menu-right"></span>
                                <input type="text" id="faq_question_en_que{{$key}}" value="{{$item->en_que}}" >
                            </div>
                        </div>
                        <div id="faq_collapse{{$key}}" class="panel-collapse collapse">
                            <div class="panel-body">
                                <label>Answer (English)</label>
                                <textarea rows="5" cols="150" class="form-control" id="faq_question_en_asw{{$key}}">{{$item->en_asw}}</textarea>
                                <label>Question (Norwegian)</label>
                                <input type="text" id="faq_question_no_que{{$key}}" value="{{$item->no_que}}" >
                                <label>Answer (Norwegian)</label>
                                <textarea rows="5" cols="150" class="form-control" id="faq_question_no_asw{{$key}}">{{$item->no_asw}}</textarea>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <button class="sp-f cs save-btn btn" id="faq_question_save">@lang('admin.save')</button>
            </div>
            @elseif($page->id == 7)
            <div class="page-setting meta-info">
                <div class="admin page-seting-content">
                    <h2>Form Header Part</h2>
                    <input type="file" class="login_file" accept="image/*">
                    <input type="hidden" id="login_path" value="{{$page_body->header->path}}">
                    <label>Title (English)</label>
                    <input type="text" id="login_header_en_title" value="{{$page_body->header->en_title}}" >
                    <label>Title (Norwegian)</label>
                    <input type="text" id="login_header_no_title" value="{{$page_body->header->no_title}}" >
                    <label>Description (English)</label>
                    <textarea rows="2" cols="100" class="form-control" id="login_header_en_des">{{$page_body->header->en_des}}</textarea>
                    <label>Description (Norwegian)</label>
                    <textarea rows="2" cols="100" class="form-control" id="login_header_no_des">{{$page_body->header->no_des}}</textarea>
                    <button class="sp-f cs save-btn btn" id="login_header_save">@lang('admin.save')</button>
                </div>
            </div>
            @elseif($page->id == 8)
            <div class="page-setting meta-info">
                <div class="admin page-seting-content">
                    <h2>Form Header Part</h2>
                    <label>Title (English)</label>
                    <input type="text" id="register_header_en_title" value="{{$page_body->header->en_title}}" >
                    <label>Title (Norwegian)</label>
                    <input type="text" id="register_header_no_title" value="{{$page_body->header->no_title}}" >
                    <label>Description (English)</label>
                    <textarea rows="2" cols="100" class="form-control" id="register_header_en_des">{{$page_body->header->en_des}}</textarea>
                    <label>Description (Norwegian)</label>
                    <textarea rows="2" cols="100" class="form-control" id="register_header_no_des">{{$page_body->header->no_des}}</textarea>
                    <button class="sp-f cs save-btn btn" id="register_header_save">@lang('admin.save')</button>
                </div>
            </div>
            <div class="page-setting toggle-content">
                <h2>Items</h2>
                <button class="sp-f btn add" id="register_list_add"><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="plus-square" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-plus-square fa-w-14 fa-lg"><path fill="currentColor" d="M352 240v32c0 6.6-5.4 12-12 12h-88v88c0 6.6-5.4 12-12 12h-32c-6.6 0-12-5.4-12-12v-88h-88c-6.6 0-12-5.4-12-12v-32c0-6.6 5.4-12 12-12h88v-88c0-6.6 5.4-12 12-12h32c6.6 0 12 5.4 12 12v88h88c6.6 0 12 5.4 12 12zm96-160v352c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V80c0-26.5 21.5-48 48-48h352c26.5 0 48 21.5 48 48zm-48 346V86c0-3.3-2.7-6-6-6H54c-3.3 0-6 2.7-6 6v340c0 3.3 2.7 6 6 6h340c3.3 0 6-2.7 6-6z" class=""></path></svg></button>
                <div class="register-item-group">
                    @foreach($page_body->list as $key => $item)
                    <div class="panel panel-default" id="register_panel{{$key}}">
                        <a class="remove_register_item remove_btn" data-key={{$key}}><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="trash-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-trash-alt fa-w-14 fa-lg"><path fill="currentColor" d="M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z"></path></svg></a>
                        <div class="panel-heading">
                            <div class="toggle-input" data-toggle="collapse" href="#reg_collapse{{$key}}">
                                <span class="glyphicon glyphicon-menu-right"></span>
                                <input type="text" id="register_item_en_title{{$key}}" value="{{$item->en_title}}" >
                            </div>
                        </div>
                        <div id="reg_collapse{{$key}}" class="panel-collapse collapse">
                            <div class="panel-body">
                                <input type="file" class="register_item_file" data-key="{{$key}}" accept="image/*">
                                <input type="hidden" id="register_item_path{{$key}}" value="{{$item->path}}">
                                <label>Title (Norwegian)</label>
                                <input type="text" id="register_item_no_title{{$key}}" value="{{$item->no_title}}" >
                                <label>Text (English)</label>
                                <input type="text" id="register_item_en_text{{$key}}" value="{{$item->en_txt}}" >
                                <label>Text (Norwegian)</label>
                                <input type="text" id="register_item_no_text{{$key}}" value="{{$item->no_txt}}" >
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <button class="sp-f cs save-btn btn" id="register_item_save">@lang('admin.save')</button>
            </div>
            <!-- Feature Page -->
            @elseif($page->id == 10)
            <div class="page-setting meta-info double-multi">
                <div class="profile-uploader">
                    <div class="imageupload log-setting-up">
                        <label class="btn btn-file">
                            @lang('admin.banner_desktop_image')
                            <input type="file" class="banner_desktop_file" name="image-file">
                        </label>
                        <label class="btn btn-file">
                            @lang('admin.banner_mobile_image')
                            <input type="file" class="banner_mobile_file" name="image-file">
                        </label>
                    </div>
                </div>
                <div class="admin page-seting-content">
                    <h2>Header Part (English)</h2>
                    <label>Title</label>
                    <input type="text" id="header_en_title" value="{{$page_body->en_header->title}}" >
                    <label>Description</label>
                    <textarea rows="5" cols="150" class="form-control" id="header_en_description">{{$page_body->en_header->description}}</textarea>
                    <label>Button</label>
                    <input type="text" id="header_en_button1" value="{{$page_body->en_header->button_title1}}" >
                    <label>Button Link</label>
                    <input type="text" id="header_en_button_link1" value="{{$page_body->en_header->button_link1}}" >
                    <label>Button</label>
                    <input type="text" id="header_en_button2" value="{{$page_body->en_header->button_title2}}" >
                    <label>Button Link</label>
                    <input type="text" id="header_en_button_link2" value="{{$page_body->en_header->button_link2}}" >
                    <button class="sp-f cs save-btn btn" id="en_header_save">@lang('admin.save')</button>
                </div>
                <div class="admin page-seting-content">
                    <h2>Header Part (Norwegian)</h2>
                    <label>Title</label>
                    <input type="text" id="header_no_title" value="{{$page_body->no_header->title}}" >
                    <label>Description</label>
                    <textarea rows="5" cols="150" class="form-control" id="header_no_description">{{$page_body->no_header->description}}</textarea>
                    <label>Button</label>
                    <input type="text" id="header_no_button1" value="{{$page_body->no_header->button_title1}}" >
                    <label>Button Link</label>
                    <input type="text" id="header_no_button_link1" value="{{$page_body->no_header->button_link1}}" >
                    <label>Button</label>
                    <input type="text" id="header_no_button2" value="{{$page_body->no_header->button_title2}}" >
                    <label>Button Link</label>
                    <input type="text" id="header_no_button_link2" value="{{$page_body->no_header->button_link2}}" >
                    <button class="sp-f cs save-btn btn" id="no_header_save">@lang('admin.save')</button>
                </div>
            </div>
            <div class="page-setting page-seting-content meta-info">
                <h2>Service Part</h2>
                <label>Title (English)</label>
                <input type="text" id="en_service_title" value="{{$page_body->services->en_title}}" >
                <label>Title (Norwegian)</label>
                <input type="text" id="no_service_title" value="{{$page_body->services->no_title}}" >
                <button class="sp-f cs save-btn btn service_title_save">@lang('admin.save')</button>
            </div>
            <div class="page-setting toggle-content meta-info">
                <h2>Service Items</h2>
                <button class="sp-f btn add" id="feature_service_add"><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="plus-square" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-plus-square fa-w-14 fa-lg"><path fill="currentColor" d="M352 240v32c0 6.6-5.4 12-12 12h-88v88c0 6.6-5.4 12-12 12h-32c-6.6 0-12-5.4-12-12v-88h-88c-6.6 0-12-5.4-12-12v-32c0-6.6 5.4-12 12-12h88v-88c0-6.6 5.4-12 12-12h32c6.6 0 12 5.4 12 12v88h88c6.6 0 12 5.4 12 12zm96-160v352c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V80c0-26.5 21.5-48 48-48h352c26.5 0 48 21.5 48 48zm-48 346V86c0-3.3-2.7-6-6-6H54c-3.3 0-6 2.7-6 6v340c0 3.3 2.7 6 6 6h340c3.3 0 6-2.7 6-6z" class=""></path></svg></button>
                <div class="service-group">
                    @foreach($page_body->services->arr as $key => $item)
                    <div class="panel panel-default" id="feature_service_panel{{$key}}">
                        <a class="remove_service_item remove_btn" data-key={{$key}}><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="trash-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-trash-alt fa-w-14 fa-lg"><path fill="currentColor" d="M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z"></path></svg></a>
                        <div class="panel-heading">
                            <div class="toggle-input" data-toggle="collapse" href="#service_collapse{{$key}}">
                                <span class="glyphicon glyphicon-menu-right"></span>
                                <input type="text" id="service_en_title{{$key}}" value="{{$item->en_title}}" >
                            </div>
                        </div>
                        <div id="service_collapse{{$key}}" class="panel-collapse collapse">
                            <div class="panel-body">
                                <input type="file" class="service_file" data-key="{{$key}}" accept="image/*">
                                <input type="hidden" id="service_file_path{{$key}}" value="{{$item->path}}">
                                <label>Title (Norwegian)</label>
                                <input type="text" id="service_no_title{{$key}}" value="{{$item->no_title}}" >
                                <label>Description (English)</label>
                                <textarea rows="5" cols="150" class="form-control" id="service_en_des{{$key}}">{{$item->en_des}}</textarea>
                                <label>Description (Norwegian)</label>
                                <textarea rows="5" cols="150" class="form-control" id="service_no_des{{$key}}">{{$item->no_des}}</textarea>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <button class="sp-f cs save-btn btn" id="feature_service_save">@lang('admin.save')</button>
            </div>
            <div class="page-setting meta-info multi">
                <div class="admin page-seting-content">
                    <h2>Consultant Part</h2>
                    <input type="file" class="consultant_file" accept="image/*">
                    <input type="hidden" id="consultant_file_path" value="{{$page_body->consultant->path}}">
                    <label>Title (English)</label>
                    <input type="text" id="en_consultant_title" value="{{$page_body->consultant->en_title}}" >
                    <label>Title (Norwegian)</label>
                    <input type="text" id="no_consultant_title" value="{{$page_body->consultant->no_title}}" >
                    <label>Description (English)</label>
                    <textarea rows="5" cols="150" class="form-control" id="consultant_en_des">{{$page_body->consultant->en_des}}</textarea>
                    <label>Description (Norwegian)</label>
                    <textarea rows="5" cols="150" class="form-control" id="consultant_no_des">{{$page_body->consultant->no_des}}</textarea>
                    <button class="sp-f cs save-btn btn consultant_save">@lang('admin.save')</button>
                </div>
                <div class="admin page-seting-content">
                    <h2>Session Part</h2>
                    <input type="file" class="session_file" accept="image/*">
                    <input type="hidden" id="session_file_path" value="{{$page_body->session->path}}">
                    <label>Title (English)</label>
                    <input type="text" id="en_session_title" value="{{$page_body->session->en_title}}" >
                    <label>Title (Norwegian)</label>
                    <input type="text" id="no_session_title" value="{{$page_body->session->no_title}}" >
                    <label>Description (English)</label>
                    <textarea rows="5" cols="150" class="form-control" id="session_en_des">{{$page_body->session->en_des}}</textarea>
                    <label>Description (Norwegian)</label>
                    <textarea rows="5" cols="150" class="form-control" id="session_no_des">{{$page_body->session->no_des}}</textarea>
                    <button class="sp-f cs save-btn btn session_save">@lang('admin.save')</button>
                </div>
            </div>
            <div class="page-setting meta-info multi">
                <div class="admin page-seting-content">
                    <h2>Wallet Part</h2>
                    <input type="file" class="wallet_file" accept="image/*">
                    <input type="hidden" id="wallet_file_path" value="{{$page_body->wallet->path}}">
                    <label>Title (English)</label>
                    <input type="text" id="en_wallet_title" value="{{$page_body->wallet->en_title}}" >
                    <label>Title (Norwegian)</label>
                    <input type="text" id="no_wallet_title" value="{{$page_body->wallet->no_title}}" >
                    <label>Description (English)</label>
                    <textarea rows="5" cols="150" class="form-control" id="wallet_en_des">{{$page_body->wallet->en_des}}</textarea>
                    <label>Description (Norwegian)</label>
                    <textarea rows="5" cols="150" class="form-control" id="wallet_no_des">{{$page_body->wallet->no_des}}</textarea>
                    <button class="sp-f cs save-btn btn wallet_save">@lang('admin.save')</button>
                </div>
                <div class="admin page-seting-content">
                    <h2>Profile Part</h2>
                    <input type="file" class="profile_file" accept="image/*">
                    <input type="hidden" id="profile_file_path" value="{{$page_body->profile->path}}">
                    <label>Title (English)</label>
                    <input type="text" id="en_profile_title" value="{{$page_body->profile->en_title}}" >
                    <label>Title (Norwegian)</label>
                    <input type="text" id="no_profile_title" value="{{$page_body->profile->no_title}}" >
                    <label>Description (English)</label>
                    <textarea rows="5" cols="150" class="form-control" id="profile_en_des">{{$page_body->profile->en_des}}</textarea>
                    <label>Description (Norwegian)</label>
                    <textarea rows="5" cols="150" class="form-control" id="profile_no_des">{{$page_body->profile->no_des}}</textarea>
                    <button class="sp-f cs save-btn btn profile_save">@lang('admin.save')</button>
                </div>
                <div class="admin page-seting-content">
                    <h2>Transaction Part</h2>
                    <input type="file" class="transaction_file" accept="image/*">
                    <input type="hidden" id="transaction_file_path" value="{{$page_body->transactions->path}}">
                    <label>Title (English)</label>
                    <input type="text" id="en_transaction_title" value="{{$page_body->transactions->en_title}}" >
                    <label>Title (Norwegian)</label>
                    <input type="text" id="no_transaction_title" value="{{$page_body->transactions->no_title}}" >
                    <label>Description (English)</label>
                    <textarea rows="5" cols="150" class="form-control" id="transaction_en_des">{{$page_body->transactions->en_des}}</textarea>
                    <label>Description (Norwegian)</label>
                    <textarea rows="5" cols="150" class="form-control" id="transaction_no_des">{{$page_body->transactions->no_des}}</textarea>
                    <button class="sp-f cs save-btn btn transaction_save">@lang('admin.save')</button>
                </div>
            </div>
            <div class="page-setting page-seting-content meta-info">
                <h2>Review Part</h2>
                <label>Title (English)</label>
                <input type="text" id="en_feature_review_title" value="{{$page_body->reviews->en_title}}" >
                <label>Title (Norwegian)</label>
                <input type="text" id="no_feature_review_title" value="{{$page_body->reviews->no_title}}" >
                <button class="sp-f cs save-btn btn feature_review_title_save">@lang('admin.save')</button>
            </div>
            @endif
            <div class="page-setting meta-info">
                <h2>@lang('admin.meta_information')</h2>
                <div class="page-seting-content">
                    <label>@lang('admin.meta_title')</label>
                    <input type="text" id="meta_title" value="{{$page->meta_title}}" >
                    <div class="alert" id="meta_title_error"></div>
                    <label>@lang('admin.meta_description')</label>
                    <textarea rows="4" cols="150" class="form-control" id="meta_description">{{$page->meta_description}}</textarea>
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
	editPage();
</script>
@endsection