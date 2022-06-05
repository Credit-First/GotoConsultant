@extends('layout.private')
@section('title', 'GoToConsult - Consultants')
@section('content')
<?php $lang = app()->getLocale();?>
<div class="admin-wrapper">
    @include('elements.admin_sidebar')
    <div class="content-wrapper adminprof">
        <div class="single-page">
            <div class="pages-heading category-heading">
                <h2 class="mr-auto mt-auto mb-auto">@lang('admin.consultants')</h2>
                <a href="{{ $lang == 'en' ? url('/create-consultant') : url('/no/opprett-konsulent') }}"><button class="btn save-btn">@lang('admin.create_consultant')</button></a>
            </div>
            <div class="admin-table status-section consult-table cust-table table-responsive">
                <table class="table table-borderless responsive" id="example">
                    <thead>
                        <tr class="top">
                            <th>@lang('admin.consultant')</th>
                            <th>@lang('admin.profession')</th>
                            <th>@lang('admin.reg_date')</th>
                            <th>@lang('admin.active')</th>
                            <th>@lang('admin.action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($consultants as $key => $consultant)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar"></div>
                                    <span>{{$consultant->user->first_name}} {{$consultant->user->last_name}}</span>
                                </div>
                            </td>
                            <td>
                                <p data-id="{{$consultant->user->id}}"></p>
                                @foreach($categories as $category)
                                    @if($consultant->profile->profession === $category->category_name)
                                    {{$lang == 'en' ? $category->category_name : $category->category_name_no}}
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                {{$consultant->created_at->format('d.m.Y')}}
                            </td>
                            <td>
                                <div class="jtoggler-control {{$consultant->user->active == 1 ? 'active' : ''}}">
                                    <label class="jtoggler-btn-wrapper {{$consultant->user->active == 0 ? 'active' : ''}}">
                                        <span>@lang('admin.rejected')</span>
                                        <input type="radio" name="active" value="0" data-id="{{$consultant->user->id}}"/>
                                    </label>
                                    <label class="jtoggler-btn-wrapper {{$consultant->user->active == 2 ? 'active' : ''}}">
                                        <input type="radio" name="active" value="2" data-id="{{$consultant->user->id}}"/>
                                    </label>
                                    <label class="jtoggler-btn-wrapper {{$consultant->user->active == 1 ? 'active' : ''}}">
                                        <span>@lang('admin.accepted')</span>
                                        <input type="radio" name="active" value="1" data-id="{{$consultant->user->id}}"/>
                                    </label>
                                    <span class="jtoggler-handle"></span>
                                </div>
                            </td>
                            <td><a style="display:block;line-height:22px;" href="{{ $lang == 'en' ? url('/edit-consultant/'.$consultant->user_id) : url('/no/rediger-konsulent/'.$consultant->user_id) }}" class="">@lang('admin.details') </a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    const data = @json($consultants);
    consultants(data);
</script>
@endsection
