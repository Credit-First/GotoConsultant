@extends('layout.member')
@section('title', $title)
@section('description', $description)
@section('content')
<?php
    $rate_imgs = [
        asset('images/home/star-dg.png'),
        asset('images/home/star-g.png'),
        asset('images/home/star-y.png'),
        asset('images/home/star-o.png'),
        asset('images/home/star-r.png'),
        asset('images/home/star-w.png')
    ];
    $btn_imgs = [
        asset('images/home/ph.svg'),
        asset('images/home/ph-y.svg'),
        asset('images/home/ph-g.svg'),
        asset('images/home/video.svg'),
        asset('images/home/video-y.svg'),
        asset('images/home/video-g.svg'),
        asset('images/home/msg.svg'),
        asset('images/home/msg-y.svg'),
        asset('images/home/msg-g.svg'),
    ];
    $educatedIcon = asset('images/mortarboard-w.svg');
?>
<div class="member-wrapper">
    @include('elements.member_sidebar')
    <div class="content-wrapper">
        <div class="single-page">
            <div class="pages-heading">
                <h2>@lang('member.find_consultant')</h2>
            </div>

            <div class="pages-top-sec">
                <div class="form mr-3">
                    <input type="text" name="search" class="search" placeholder="@lang('member.name-keyword')"/>
                </div>
                <button id="desktop_filter" class="filter_btn">@lang('member.filter') <i class="fa fa-filter"></i></button>

            </div> <!-- pages-top-sec-->

            <div class="sort-section">
                <div class="dropdown-box">
                    <label>@lang('member.category'):</label>
                    <select class="category-sel">
                        <option selected>@lang('member.all')</option>
                        @foreach($categories as $category)
                            <option value="{{$category->category_name}}">
                                @if($lang == 'en')
                                {{$category->category_name}}
                                @else
                                {{$category->category_name_no}}
                                @endif
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="dropdown-box">
                    <label>@lang('member.price'):</label>
                    <select class="price-sel">
                        <option selected>@lang('member.default')</option>
                        <option value="high-low">@lang('member.high-low')</option>
                        <option value="low-high">@lang('member.low-high')</option>
                    </select>
                </div>
                <div class="dropdown-box">
                    <label>@lang('member.status'):</label>
                    <select class="status-sel">
                        <option selected>@lang('member.all')</option>
                        <option value="available">@lang('member.available')</option>
                        <option value="busy">@lang('member.busy')</option>
                        <option value="offline">@lang('member.offline')</option>
                    </select>
                </div>
                <div class="dropdown-box">
                    <label>@lang('member.country'):</label>
                    <select class="country-sel">
                        <option selected>@lang('member.all')</option>
                    </select>
                </div>

                <div class="dropdown-box">
                    <label>@lang('member.education'):</label>
                    <select class="education-sel">
                        <option selected>@lang('member.education_all')</option>
                        <option value="1">
                            @lang('member.only_with_education')
                        </option>
                        <option value="0">
                            @lang('member.only_without_education')
                        </option>
                    </select>
                </div>
            </div>

            <div class="filter-sec">
                <div class="filter-header">
                    <p>{{count($consultants)}} @lang('member.results')sdsdfsdfsdf</p>
                    <button id="show_filter" class="filter_btn reversed">@lang('member.filter')</button>
                </div>
                <div class="filter-body">
                    <div class="form-group">
                        <input type="text" name="search" class="form-control search" placeholder="@lang('member.name-keyword')"/>
                    </div>
                    <div class="dropdown-box">
                        <label>@lang('member.category'):</label>
                        <select class="category-sel">
                            <option selected>@if($lang=='en') All @else Alle @endif</option>
                            @foreach($categories as $category)
                                <option value="{{$category->category_name}}">
                                    @if($lang == 'en')
                                    {{$category->category_name}}
                                    @else
                                    {{$category->category_name_no}}
                                    @endif
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="dropdown-box">
                        <label>@lang('member.price'):</label>
                        <select class="price-sel">
                            <option selected>@lang('member.default')</option>
                            <option value="high-low">@lang('member.high-low')</option>
                            <option value="low-high">@lang('member.low-high')</option>
                        </select>
                    </div>
                    <div class="dropdown-box">
                        <label>@lang('member.status'):</label>
                        <select class="status-sel">
                            <option selected>@lang('member.all')</option>
                            <option value="available">@lang('member.available')</option>
                            <option value="busy">@lang('member.busy')</option>
                            <option value="offline">@lang('member.offline')</option>
                        </select>
                    </div>
                    <div class="dropdown-box">
                        <label>@lang('member.country'):</label>
                        <select class="country-sel">
                            <option selected>@lang('member.all')</option>
                        </select>
                    </div>
                    <button id="mobile_filter" class="filter_btn reversed">@lang('member.show-results')</button>
                </div>
            </div>
            <div class="page-dashboard mt-3">
                @if (count($consultants) == 0)
                <div class="page-border recommend cart-no-result">
                    <img src="/images/mascot.svg" />
                    <h2>@lang('member.no-result')</h2>
                    <p>@lang('member.no-result-des')</p>
                </div>
                @else
                <div class="page-border recommend consultants-view"></div>
                <form id="from-booking" action="{{ route('booking') }}" method="POST">
                    @csrf
                    <input id="inp-booking-data" type="hidden" name="data"/>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{asset('js/mark-your-calendar.js')}}"></script>
<script>
    const search = @json($search);
    const countries = @json($countries);
    const consultants = @json($consultants);

    const categories = @json($categories);

    const rate_imgs = @json($rate_imgs);
    const btn_imgs = @json($btn_imgs);
    const educatedIcon = @json($educatedIcon);
    findConsult(search, countries, consultants, categories, rate_imgs, btn_imgs, educatedIcon);
</script>
@endsection
