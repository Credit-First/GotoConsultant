@extends('layout.public')
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
?>
<div class="full-cart category">
    <div class="container">
        <div class="col-12 px-3 category-header">
            <div class="img-sec mr-3">
                <img src="{{$category->category_icon}}" alt="icon">
            </div>
            <div class="des-sec">
                @if($lang == 'en')
                <h1>{{$category->category_name}}</h1>
                <p>{{$category->category_description}}</p>
                @else
                <h1>{{$category->category_name_no}}</h1>
                <p>{{$category->category_description_no}}</p>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="full-cart consultant-search">
    <div class="container">
        <div class="col-12 d-flex px-3 flex-column">
            <div class="pages-top-sec">
                <div class="form mr-3">
                    <input type="text" name="search" class="search" placeholder="@lang('member.name-keyword')"/>
                </div>
                <div class="sort-section">
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
                    <button id="desktop_filter" class="filter_btn">@lang('member.filter')</button>
                </div>
            </div>
            <div class="filter-sec">
                <div class="filter-header">
                    <p>{{count($consultants)}} @lang('member.results')</p>
                    <button id="show_filter" class="filter_btn reversed">@lang('member.filter')</button>
                </div>
                <div class="filter-body">
                    <div class="form-group">
                        <input type="text" name="search" class="form-control search" placeholder="@lang('member.name-keyword')"/>
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
            @if (count($consultants) == 0)
            <div class="cart-no-result">
                <img src="/images/mascot.svg" />
                <h2>@lang('member.no-result')</h2>
                <p>@lang('member.no-result-des')</p>
            </div>
            @else
            <div class="consultants-view"></div>
            @endif
        </div>
    </div>
</div>
@if($review_count > 0)
<div class="full-cart gd-ppl-words">
    <div class="container">
        <div class="col-12">
            <h2>@lang('home.review-title')</h2>
            <div class="header px-3">
                <p class="customer active">@lang('home.customers')</p>
                <p class="consultant">@lang('home.consultants')</p>
            </div>
            <div class="customer-review review-group active">
                @foreach($review_list as $key=>$review)
                    @if($review->type == 'CUSTOCON')
                        <div class="review">
                            <div class="avatar">
                                @if ($review->customer->profile && $review->customer->profile->avatar)
                                <img src="{{$review->customer->profile->avatar}}">
                                @else
                                <img src="{{asset('images/profile-icon.svg')}}">
                                @endif
                            </div>
                            <div class="description mt-3">
                                <p class="mb-3">"{{$review->description}}"</p>
                                <p><b>{{$review->customer->user->first_name}} {{$review->customer->user->last_name[0]}}.</b></p>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
            <div class="consultant-review review-group">
                @foreach($review_list as $key=>$review)
                    @if($review->type == 'CONTOCUS')
                        <div class="review">
                            <div class="avatar">
                                @if ($review->consultant->profile && $review->consultant->profile->avatar)
                                <img src="{{$review->consultant->profile->avatar}}">
                                @else
                                <img src="{{asset('images/profile-icon.svg')}}">
                                @endif
                            </div>
                            <div class="description mt-3">
                                <p class="mb-3">"{{$review->description}}"</p>
                                <p><b>{{$review->consultant->user->first_name}} {{$review->consultant->user->last_name[0]}}.</b></p>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif
@if($review_count > 0)
<div class="inner-footer">
    <div class="container h-100">
        <div class="col-12 h-100 d-flex flex-column justify-content-center align-items-center">
            <div class="home-info-footer d-flex flex-column align-items-center">
                @if($lang == 'en')
                <h2 class="mb-3">{{$data->footer->en_title}}</h2>
                <p>{!!$data->footer->en_des!!}</p>
                <div class="btn-group mt-3">
                    <a href="{{ url('/'.$data->footer->en_btn_link1) }}"> {{$data->footer->en_btn_title1}}</a>
                    <a href="{{ url('/'.$data->footer->en_btn_link2) }}"> {{$data->footer->en_btn_title2}}</a>
                </div>
                @else
                <h2 class="mb-3">{{$data->footer->no_title}}</h2>
                <p>{!!$data->footer->no_des!!}</p>
                <div class="btn-group mt-3">
                    <a href="{{ url('/'.$data->footer->no_btn_link1) }}"> {{$data->footer->no_btn_title1}}</a>
                    <a href="{{ url('/'.$data->footer->no_btn_link2) }}"> {{$data->footer->no_btn_title2}}</a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endif
@endsection
@section('scripts')
<script>
	const search = @json($search);
    const countries = @json($countries);
    const consultants = @json($consultants);
    const categories = @json($categories);
    const rate_imgs = @json($rate_imgs);
    const btn_imgs = @json($btn_imgs);
    public();
    category(search, countries, consultants, categories, rate_imgs, btn_imgs);
</script>
@endsection