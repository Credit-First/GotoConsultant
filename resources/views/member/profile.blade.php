@extends('layout.profile_member')
@section('title', $title)
@section('description', $description)
@section('content')
    <?php
    use Jenssegers\Agent\Agent as Agent;
    $agent = new Agent();
    $lang_ = app()->getLocale();
    $lang = json_encode(['data' => app()->getLocale()]);
    ?>
    <div class="member-wrapper" id="member-content">
        @include('elements.member_sidebar')
        <div class="content-wrapper">
            <div class="single-page">
                <div class="pages-heading">
                    <h2>@lang('member.profile')</h2>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="profile-card-left">
                                <div class="profile-header">
                                    @if ($user_profile->profile && $user_profile->profile->cover_img)
                                        <div class="profile-cover"
                                            style="background-image: url('{{ $user_profile->profile->cover_img }}'); background-position: center; background-repeat: no-repeat; background-size: cover;">
                                        @else
                                            <div class="profile-cover">
                                                <img src="{{ asset('images/white-logo.svg') }}" />
                                    @endif
                                    @if ($request_type == 'own')
                                        <button class="btn-edit-profile">@lang('member.edit-profile')</button>
                                    @endif
                                </div>
                                <div class="profile-card profile-sub-header">
                                    @if (!is_null($user_profile->profile) && !is_null($user_profile->profile->avatar))
                                        <div class="avatar-pic"
                                            style="background-image: url('{{ $user_profile->profile->avatar }}'); background-position: center; background-repeat: no-repeat; background-size: cover;">
                                        @else
                                            <div class="avatar-pic">
                                                <img src="{{ asset('images/white-logo.svg') }}" />
                                    @endif
                                </div>
                                <div class="detail-info">
                                    @if ($user_profile->user->role == 'consultant' && $agent->isMobile())
                                        {{ $user_profile->hourly_rate }} p/m
                                    @endif
                                    <div class="status" id="profile-status">
                                        <h2>{{ $user_profile->user->first_name }} {{ $user_profile->user->last_name }}</h2>
                                        <status-component :user-profile="{{ $user_profile->user }}"></status-component>
                                    </div>
                                    <div class="star-images">
                                        @if ($user_profile['rate'] == 5)
                                            <ul class="d-flex">
                                                <li><img src="{{ asset('images/home/star-dg.png') }}" alt="no-img" /></li>
                                                <li><img src="{{ asset('images/home/star-dg.png') }}" alt="no-img" /></li>
                                                <li><img src="{{ asset('images/home/star-dg.png') }}" alt="no-img" /></li>
                                                <li><img src="{{ asset('images/home/star-dg.png') }}" alt="no-img" /></li>
                                                <li><img src="{{ asset('images/home/star-dg.png') }}" alt="no-img" /></li>
                                            </ul>
                                        @elseif($user_profile['rate'] == 4)
                                            <ul class="d-flex">
                                                <li><img src="{{ asset('images/home/star-g.png') }}" alt="no-img" /></li>
                                                <li><img src="{{ asset('images/home/star-g.png') }}" alt="no-img" /></li>
                                                <li><img src="{{ asset('images/home/star-g.png') }}" alt="no-img" /></li>
                                                <li><img src="{{ asset('images/home/star-g.png') }}" alt="no-img" /></li>
                                                <li><img src="{{ asset('images/home/star-w.png') }}" alt="no-img" /></li>
                                            </ul>
                                        @elseif($user_profile['rate'] == 3)
                                            <ul class="d-flex">
                                                <li><img src="{{ asset('images/home/star-y.png') }}" alt="no-img" /></li>
                                                <li><img src="{{ asset('images/home/star-y.png') }}" alt="no-img" /></li>
                                                <li><img src="{{ asset('images/home/star-y.png') }}" alt="no-img" /></li>
                                                <li><img src="{{ asset('images/home/star-w.png') }}" alt="no-img" /></li>
                                                <li><img src="{{ asset('images/home/star-w.png') }}" alt="no-img" /></li>
                                            </ul>
                                        @elseif($user_profile['rate'] == 2)
                                            <ul class="d-flex">
                                                <li><img src="{{ asset('images/home/star-o.png') }}" alt="no-img" /></li>
                                                <li><img src="{{ asset('images/home/star-o.png') }}" alt="no-img" /></li>
                                                <li><img src="{{ asset('images/home/star-w.png') }}" alt="no-img" /></li>
                                                <li><img src="{{ asset('images/home/star-w.png') }}" alt="no-img" /></li>
                                                <li><img src="{{ asset('images/home/star-w.png') }}" alt="no-img" /></li>
                                            </ul>
                                        @elseif($user_profile['rate'] == 1)
                                            <ul class="d-flex">
                                                <li><img src="{{ asset('images/home/star-r.png') }}" alt="no-img" /></li>
                                                <li><img src="{{ asset('images/home/star-w.png') }}" alt="no-img" /></li>
                                                <li><img src="{{ asset('images/home/star-w.png') }}" alt="no-img" /></li>
                                                <li><img src="{{ asset('images/home/star-w.png') }}" alt="no-img" /></li>
                                                <li><img src="{{ asset('images/home/star-w.png') }}" alt="no-img" /></li>
                                            </ul>
                                        @else
                                            <ul class="d-flex">
                                                <li><img src="{{ asset('images/home/star-w.png') }}" alt="no-img" /></li>
                                                <li><img src="{{ asset('images/home/star-w.png') }}" alt="no-img" /></li>
                                                <li><img src="{{ asset('images/home/star-w.png') }}" alt="no-img" /></li>
                                                <li><img src="{{ asset('images/home/star-w.png') }}" alt="no-img" /></li>
                                                <li><img src="{{ asset('images/home/star-w.png') }}" alt="no-img" /></li>
                                            </ul>
                                        @endif
                                        <?php $rate = $user_profile['rate'] ? number_format((float) $user_profile['rate'], 1) : number_format(0, 1); ?>
                                        <p>{{ $rate }}</p>
                                    </div>
                                    @if ($user_profile->profile)
                                        <div class="details">
                                            @if ($user_profile->user->role == 'consultant')
                                                @if ($user_profile->profile->profession)
                                                    <span>
                                                        <img src="{{ asset('images/portfolio.svg') }}" alt="no-img" />
                                                        @foreach ($categories as $category)
                                                            @if ($user_profile->profile->profession === $category->category_name)
                                                                {{ $lang_ == 'en' ? $category->category_name : $category->category_name_no }}
                                                            @endif
                                                        @endforeach
                                                    </span>
                                                @endif
                                                @if ($user_profile->profile->college && !$agent->isMobile())
                                                    <span>
                                                        <img src="{{ asset('images/mortarboard.svg') }}" alt="no-img" />
                                                        {{ $user_profile->profile->college }}
                                                    </span>
                                                @endif
                                            @endif
                                            @if (!$agent->isMobile())
                                                @if (!is_null($user_profile->profile->from))
                                                    <span>
                                                        <img src="{{ asset('images/pin.svg') }}" alt="no-img" />
                                                        @lang('member.from') {{ $user_profile->profile->from }}
                                                    </span>
                                                @endif
                                                @if (!is_null($user_profile->profile->country))
                                                    <span>
                                                        <img src="{{ asset('images/home.svg') }}" alt="no-img" />
                                                        @lang('member.lives-in') {{ $user_profile->profile->region }},
                                                        {{ $user_profile->profile->country }}
                                                    </span>
                                                @endif
                                                @if (!is_null($user_profile->profile->timezone))
                                                    <span>
                                                        <img src="{{ asset('images/clock.svg') }}" alt="no-img" />
                                                        {{ $user_profile->profile->gmt }} {{ $user_profile->profile->timezone }}
                                                    </span>
                                                @endif
                                            @else
                                                @if (!is_null($user_profile->profile->from))
                                                    <span>
                                                        <img src="{{ asset('images/pin.svg') }}" alt="no-img" />
                                                        @lang('member.from') {{ $user_profile->profile->from }}
                                                    </span>
                                                @endif
                                                @if (!$agent->isMobile())
                                                    @if (!is_null($user_profile->profile->country))
                                                        <span>
                                                            <img src="{{ asset('images/home.svg') }}" alt="no-img" />
                                                            @lang('member.lives-in') {{ $user_profile->profile->region }},
                                                            {{ $user_profile->profile->country }}
                                                        </span>
                                                    @endif
                                                    @if (!is_null($user_profile->profile->timezone))
                                                        <span>
                                                            <img src="{{ asset('images/clock.svg') }}" alt="no-img" />
                                                            {{ $user_profile->profile->gmt }}
                                                            {{ $user_profile->profile->timezone }}
                                                        </span>
                                                    @endif
                                                @endif
                                            @endif
                                        </div>
                                    @else
                                        <div class="no-details">
                                            @lang('member.no-details')
                                            <button class="btn-edit-profile btn-no-info">@lang('member.edit-details')</button>
                                        </div>
                                    @endif
                                </div>
                                </div>
                                <div class="mobile-tab-view">
                                    <div class="tab about active">
                                        <img src="{{ asset('images/profile-icon-w.svg') }}" alt="">@lang('member.about')
                                    </div>
                                    <div class="tab sessions">
                                        <img src="{{ asset('images/comment.svg') }}" alt="">@lang('member.sessions')
                                    </div>
                                    <div class="tab reviews">
                                        <img src="{{ asset('images/star.svg') }}" alt="">@lang('member.reviews')
                                    </div>
                                </div>
                                </div>
                                <div class="profile-card about">
                                    <div class="header">
                                        <h3>@lang('member.about-me')</h3>
                                        <p>
                                            @if ($user_profile->user->role == 'consultant')
                                                @lang('member.consultant-membership') {{ $user_profile->user->created_at }}
                                            @else
                                                @lang('member.customer-membership') {{ $user_profile->user->created_at }}
                                            @endif
                                        </p>
                                    </div>
                                    <div class="body">
                                        @if ($user_profile->profile && !is_null($user_profile->profile->description))
                                            {!! $user_profile->profile->description !!}
                                        @else
                                            <p>@lang('member.no-about-us')</p>
                                        @endif
                                    </div>
                                </div>
                                @if ($user_profile->user->role == 'consultant' && $request_type == 'own')
                                    <div class="profile-card about">
                                        <form method="post" action="{{ route('availablehours') }}">
                                            @csrf
                                            <div class="header">
                                                <h3>Available Hours</h3>
                                                <button type="submit" class="btn btn-save">Update</button>
                                            </div>
                                            <div class="body">
                                                <div class="day-schedule-header d-flex justify-content-between mb-2">
                                                    <div class="day-status">
                                                        <span class="caption">
                                                            <i class="book-time-available"></i>
                                                            <span>Available</span>
                                                        </span>
                                                        <span class="caption ml-3">
                                                            <i class="book-time-not-available"></i>
                                                            <span>Not available</span>
                                                        </span>
                                                    </div>
                                                    <div class="timezone">
                                                        @if (!is_null($user_profile->profile->timezone))
                                                            <img src="{{ asset('images/clock.svg') }}" alt="no-img" width="12px" />
                                                            {{ $user_profile->profile->timezone }} {{ $user_profile->profile->gmt }}
                                                        @endif
                                                    </div>
                                                </div>
                                                <div id="day-schedule"></div>
                                                <input type="hidden" name="timetable" id="timetable"
                                                    value="{{ $user_profile->profile->timetable }}" />
                                            </div>
                                        </form>
                                    </div>
                                @endif
                                <div class="profile-card sessions">
                                    <div class="rate-charts">
                                        <div class="chart-sec">
                                            <div class="header">
                                                <h3>@lang('member.completed-sessions')</h3>
                                            </div>
                                            <div class="chart-body">
                                                @if ($chart_info['no_data'])
                                                    <p>@lang('member.no-statistics')</p>
                                                @else
                                                    <div class="completed-session-chart" id="completed-session-chart"></div>
                                                @endif
                                            </div>
                                        </div>
                                        @if (Auth::check() && auth()->user()->role == 'consultant' && !$chart_info['no_data'])
                                            <div class="chart-sec">
                                                <div class="header">
                                                    <h3>@lang('member.response-rate')</h3>
                                                </div>
                                                <div class="chart-body">
                                                    <div class="response-rate-chart" id="response-rate-chart"></div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="profile-card reviews">
                                    <div class="header">
                                        <h3>@lang('member.reviews')</h3>
                                    </div>
                                    <div class="body review-sec">
                                        <?php $count = count($review_info); ?>
                                        @if ($count > 0)
                                            @foreach ($review_info as $key => $review)
                                                @if ($key == 0)
                                                    <div class="review-group">
                                                    @elseif($key % 2 == 0)
                                                    </div>
                                                    <div class="review-group">
                                                @endif
                                                <div class="review" style="{{ $key > 5 ? 'display: none' : '' }}">
                                                    <div class="review-header">
                                                        <div class="review-personal-info">
                                                            @if ($review->type == 'CUSTOCON' && !is_null($review->customer->profile) && !is_null($review->customer->profile->avatar))
                                                                <div class="review-avatar mr-3"
                                                                    style="background-image: url('{{ $review->customer->profile->avatar }}'); background-position: center; background-repeat: no-repeat; background-size: cover;">
                                                                </div>
                                                            @elseif($review->type == 'CONTOCUS' && !is_null($review->consultant->profile) && !is_null($review->consultant->profile->avatar))
                                                                <div class="review-avatar mr-3"
                                                                    style="background-image: url('{{ $review->consultant->profile->avatar }}'); background-position: center; background-repeat: no-repeat; background-size: cover;">
                                                                </div>
                                                            @else
                                                                <div class="review-avatar mr-3">
                                                                    <img src="{{ asset('images/white-logo.svg') }}" />
                                                                </div>
                                                            @endif
                                                            <div class="review-info">
                                                                @if ($review->type == 'CUSTOCON' && $review->customer->user)
                                                                    <p class="m-0"><b>{{ $review->customer->user->first_name }}
                                                                            {{ $review->customer->user->last_name }}</b></p>
                                                                @elseif($review->type == 'CONTOCUS' && $review->consultant->user)
                                                                    <p class="m-0"><b>{{ $review->consultant->user->first_name }}
                                                                            {{ $review->consultant->user->last_name }}</b></p>
                                                                @endif
                                                                <?php
                                                                $newDate = date('M d, Y', strtotime($review->created_at));
                                                                $newDate = $lang_ != 'en' ? str_replace('May', 'Mai', $newDate) : $newDate;
                                                                $newDate = $lang_ != 'en' ? str_replace('Oct', 'Okt', $newDate) : $newDate;
                                                                $newDate = $lang_ != 'en' ? str_replace('Dec', 'Des', $newDate) : $newDate;
                                                                ?>
                                                                <p class="m-0">
                                                                    @if ($review->session < 2)
                                                                        {{ $review->session }} @lang('member.session')
                                                                    @else
                                                                        {{ $review->session }} @lang('member.sessions')
                                                                    @endif
                                                                    &#183; {{ $newDate }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="review-rate d-flex">
                                                            @if ($review->rate > 4.5)
                                                                <div class="rate-stars d-flex pr-2">
                                                                    <img src="{{ asset('images/home/star-dg.png') }}" alt="no-image" />
                                                                    <img src="{{ asset('images/home/star-dg.png') }}" alt="no-image" />
                                                                    <img src="{{ asset('images/home/star-dg.png') }}" alt="no-image" />
                                                                    <img src="{{ asset('images/home/star-dg.png') }}" alt="no-image" />
                                                                    <img src="{{ asset('images/home/star-dg.png') }}" alt="no-image" />
                                                                </div>
                                                            @elseif($review->rate > 3.5)
                                                                <div class="rate-stars d-flex pr-2">
                                                                    <img src="{{ asset('images/home/star-g.png') }}" alt="no-image" />
                                                                    <img src="{{ asset('images/home/star-g.png') }}" alt="no-image" />
                                                                    <img src="{{ asset('images/home/star-g.png') }}" alt="no-image" />
                                                                    <img src="{{ asset('images/home/star-g.png') }}" alt="no-image" />
                                                                    <img src="{{ asset('images/home/star-w.png') }}" alt="no-image" />
                                                                </div>
                                                            @elseif($review->rate > 2.5)
                                                                <div class="rate-stars d-flex pr-2">
                                                                    <img src="{{ asset('images/home/star-y.png') }}" alt="no-image" />
                                                                    <img src="{{ asset('images/home/star-y.png') }}" alt="no-image" />
                                                                    <img src="{{ asset('images/home/star-y.png') }}" alt="no-image" />
                                                                    <img src="{{ asset('images/home/star-w.png') }}" alt="no-image" />
                                                                    <img src="{{ asset('images/home/star-w.png') }}" alt="no-image" />
                                                                </div>
                                                            @elseif($review->rate > 1.5)
                                                                <div class="rate-stars d-flex pr-2">
                                                                    <img src="{{ asset('images/home/star-o.png') }}" alt="no-image" />
                                                                    <img src="{{ asset('images/home/star-o.png') }}" alt="no-image" />
                                                                    <img src="{{ asset('images/home/star-w.png') }}" alt="no-image" />
                                                                    <img src="{{ asset('images/home/star-w.png') }}" alt="no-image" />
                                                                    <img src="{{ asset('images/home/star-w.png') }}" alt="no-image" />
                                                                </div>
                                                            @elseif($review->rate > 0.5)
                                                                <div class="rate-stars d-flex pr-2">
                                                                    <img src="{{ asset('images/home/star-r.png') }}" alt="no-image" />
                                                                    <img src="{{ asset('images/home/star-w.png') }}" alt="no-image" />
                                                                    <img src="{{ asset('images/home/star-w.png') }}" alt="no-image" />
                                                                    <img src="{{ asset('images/home/star-w.png') }}" alt="no-image" />
                                                                    <img src="{{ asset('images/home/star-w.png') }}" alt="no-image" />
                                                                </div>
                                                            @else
                                                                <div class="rate-stars d-flex pr-2">
                                                                    <img src="{{ asset('images/home/star-w.png') }}" alt="no-image" />
                                                                    <img src="{{ asset('images/home/star-w.png') }}" alt="no-image" />
                                                                    <img src="{{ asset('images/home/star-w.png') }}" alt="no-image" />
                                                                    <img src="{{ asset('images/home/star-w.png') }}" alt="no-image" />
                                                                    <img src="{{ asset('images/home/star-w.png') }}" alt="no-image" />
                                                                </div>
                                                            @endif
                                                            {{ $review->rate }}.0
                                                        </div>
                                                    </div>
                                                    <div class="review-body">
                                                        {{ $review->description }}
                                                    </div>
                                                </div>
                                                @if ($key == $count - 1)
                                    </div>
                                    @endif
                                    @endforeach
                                    @if ($count > 6)
                                        <div id="loadMore" style="">
                                            <a href="#">@lang('member.view-more')</a>
                                        </div>
                                    @endif
                                @else
                                    <p>@lang('member.no-reviews')</p>
                                @endif
                            </div>
                            </div>
                            <div class="modal fade" id="edit-profile-modal" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3>@lang('member.edit-profile')</h3>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                                    aria-hidden="true">×</span></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="edit-cover-photo">
                                                <div class="imageupload">
                                                    <label class="btn cover-file">
                                                        <img src="{{ asset('images/photo-camera.svg') }}" />
                                                        <input type="file" id="upload_cover" name="image-file">
                                                    </label>
                                                    @if ($user_profile->profile && $user_profile->profile->cover_img)
                                                        <label class="btn delete-file">
                                                            <img src="{{ asset('images/trash.svg') }}" />
                                                        </label>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="edit-profile-photo my-3">
                                                <div class="preview-profile-photo">
                                                    @if (!is_null($user_profile->profile) && !is_null($user_profile->profile->avatar))
                                                        <img src="{{ asset('images/white-logo.svg') }}" />
                                                    @endif
                                                </div>
                                                <div class="profile-photo">
                                                    <label>@lang('member.edit-profile-photo')</label>
                                                    <p>@lang('member.edit-profile-photo-text')</p>
                                                    <label class="btn upload-profile-photo">
                                                        @lang('admin.upload')
                                                        <input type="file" id="upload_profile" name="image-file">
                                                    </label>
                                                    @if (!is_null($user_profile->profile) && !is_null($user_profile->profile->avatar))
                                                        <label class="btn upload-profile-photo" id="delete_profile_avatar">
                                                            @lang('member.delete')
                                                        </label>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="basic-info">
                                                <label>@lang('member.profile_settings')</label>
                                                <form class="basic-form">
                                                    <div class="row m-0">
                                                        <div class="form-group">
                                                            <label>@lang('member.first_name')</label>
                                                            <input type="text" id="first_name" name="first_name"
                                                                value="{{ $user_profile->user->first_name }}" required />
                                                        </div>
                                                        <div class="form-group">
                                                            <label>@lang('member.last_name')</label>
                                                            <input type="text" id="last_name" name="last_name"
                                                                value="{{ $user_profile->user->last_name }}" required />
                                                        </div>
                                                    </div>
                                                    <div class="row m-0">
                                                        <div class="form-group">
                                                            <label>@lang('member.email')</label>
                                                            <input type="text" id="email" name="email"
                                                                value="{{ $user_profile->user->email }}" required />
                                                        </div>
                                                        <div class="form-group">
                                                            <label>@lang('member.phone')</label>
                                                            <input type="text" id="phone" name="phone"
                                                                value="{{ $user_profile->user->phone }}" required />
                                                        </div>
                                                    </div>
                                                    @if ($user_profile->user->role == 'consultant')
                                                        <div class="row m-0">
                                                            <div class="form-group">
                                                                <label>Skype</label>
                                                                <input type="text" id="skype" name="skype"
                                                                    value="{{ $user_profile->profile->skype }}" required />
                                                            </div>
                                                            <div class="form-group"></div>
                                                        </div>
                                                        <div class="row m-0">
                                                            <div class="form-group">
                                                                <label>@lang('member.profession')</label>
                                                                <select class="profession" name="profession" required>
                                                                    @foreach ($categories as $category)
                                                                        @if ($lang_ == 'en')
                                                                            <option
                                                                                @if ($user_profile->profile && $user_profile->profile->profession == $category->category_name) {{ 'selected' }} @endif
                                                                                value="{{ $category->category_name }}">
                                                                                {{ $category->category_name }}</option>
                                                                        @else
                                                                            <option
                                                                                @if ($user_profile->profile && $user_profile->profile->profession == $category->category_name_no) {{ 'selected' }} @endif
                                                                                value="{{ $category->category_name }}">
                                                                                {{ $category->category_name_no }}</option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>@lang('member.college')</label>
                                                                <select class="university-list" name="university" required></select>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <div class="row m-0">
                                                        <div class="form-group">
                                                            <label>@lang('member.timezone')</label>
                                                            <select id="timezone" name="timezone" required></select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>@lang('member.from')</label>
                                                            @if (!is_null($user_profile->profile) && !is_null($user_profile->profile->from))
                                                                <select class="crs-country" id="from" name="from"
                                                                    data-region-id="hiddien_region"
                                                                    data-default-value="{{ $user_profile->profile->from }}"></select>
                                                                <select id="hiddien_region" hidden></select>
                                                            @else
                                                                <select class="crs-country" id="from" name="from"
                                                                    data-region-id="hiddien_region"></select>
                                                                <select id="hiddien_region" hidden></select>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="row m-0">
                                                        <div class="form-group">
                                                            <label>@lang('member.country')</label>
                                                            @if (!is_null($user_profile->profile) && !is_null($user_profile->profile->country))
                                                                <select class="crs-country" id="country" name="country"
                                                                    data-region-id="region"
                                                                    data-default-value="{{ $user_profile->profile->country }}"
                                                                    required></select>
                                                            @else
                                                                <select class="crs-country" id="country" name="country"
                                                                    data-region-id="region" required></select>
                                                            @endif
                                                        </div>
                                                        <div class="form-group">
                                                            <label>@lang('member.region')</label>
                                                            @if (!is_null($user_profile->profile) && !is_null($user_profile->profile->region))
                                                                <select id="region" name="region"
                                                                    data-default-value="{{ $user_profile->profile->region }}"
                                                                    required></select>
                                                            @else
                                                                <select id="region" name="region" required></select>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="row m-0 about">
                                                        <div class="form-group">
                                                            <label>@lang('member.about-me')</label>
                                                            <textarea id="description" name="description"></textarea>
                                                        </div>
                                                    </div>
                                                    <input type="submit" class="btn-save" id="profile_save" value="@lang('member.save')">
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            @if ($user_profile->user->role == 'consultant' && $request_type != 'own')
                                <div class="profile-card available-hours">
                                    <div class="profile-book-plan">
                                        @forelse($plans as $plan)
                                        <ul class="plan-list">
                                            <li class="d-flex flex flex-row justify-content-between plan active" data-id="{{$plan->id}}">
                                                <div class="plan-info">
                                                    <h5>{{$plan->title}}</h5>
                                                    <span>{{sizeof($plan->sessions)}} sessions</span>
                                                </div>
                                                <div class="plan-price">
                                                    <span>NOK {{number_format($plan->price, 2)}} +</span>
                                                </div>
                                            </li>
                                        </ul>
                                        @empty
                                        <p>{{ $user_profile->user->first_name }} {{ $user_profile->user->last_name }} has no plans. Please wait until he is available with the plans.</p>
                                        @endforelse
                                        <p class="mt-2">NOTE: You can book "{{ $user_profile->user->first_name }} {{ $user_profile->user->last_name }}" plan by clicking the available time slot the below.</p>
                                    </div>
                                    <hr/>
                                    <div class="body">
                                        <div class="day-schedule-header d-flex justify-content-between mb-2">
                                            <div class="day-status">
                                                <span class="caption">
                                                    <i class="book-time-available"></i>
                                                    <span>Available</span>
                                                </span>
                                                <span class="caption ml-3">
                                                    <i class="book-time-not-available"></i>
                                                    <span>Not available</span>
                                                </span>
                                            </div>
                                            <div class="timezone">
                                                @if (!is_null($user_profile->profile->timezone))
                                                    <img src="{{ asset('images/clock.svg') }}" alt="no-img" width="12px" />
                                                    {{ $user_profile->profile->timezone }} {{ $user_profile->profile->gmt }}
                                                @endif
                                            </div>
                                        </div>
                                        <div id="day-schedule" class="small"></div>
                                        <input type="hidden" name="timetable" id="timetable"
                                            value="{{ $user_profile->profile->timetable }}" />
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal modal-booking fade" id="modal-booking" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="headline">
                            <h5 class="modal-title" id="exampleModalLabel">Select your plan</h5>
                            <div class="steps">
                                <div class="step-circle active"></div>
                                <div class="step-circle"></div>
                                <div class="step-circle"></div>
                            </div>
                        </div>
                        <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="plan-container">
                                @forelse($plans as $plan)
                                <ul class="plan-list">
                                    <li class="plan" data-id="{{$plan->id}}">
                                        <div class="plan-info">
                                            <h5>{{$plan->title}}</h5>
                                            <span>{{sizeof($plan->sessions)}} sessions</span>
                                        </div>
                                        <div class="plan-price">
                                            <span>NOK {{number_format($plan->price, 2)}} +</span>
                                        </div>
                                    </li>
                                </ul>
                                @empty
                                <p>This consultant has no plans. Please wait until he is available with the plans.</p>
                                @endforelse
                            </div>
                            <div class="session-container text-center d-none">
                                <h3>Sessions rules</h3>
                                <p>Sessions must be scheduled in advance.</p>
                                <p>Date and time for at least ONE session should be selected to purchase a Package.</p>
                                <p>Sessions must be scheduled within six months of purchase date.</p>
                                <div class="plan-sessions">
                                    @foreach($plans as $plan)
                                        @foreach($plan->sessions as $session)
                                            <div data-plan-id={{$plan->id}} class="plan-session-container d-none">
                                                <h2>{{$session->duration}} min</h2>
                                                <div class="plan-session" data-id={{$session->id}} data-price={{number_format($session->price, 2)}} data-title={{$session->title}}>
                                                    <span>{{$session->title}}</span>
                                                    <span>NOK {{number_format($session->price, 2)}}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endforeach
                                </div>
                            </div>
                            <div class="communication-container text-center d-none">
                                <p>Your consultant can use any of the these communication tools.</p>
                                <p>Which communication tool would you like to use for your session?</p>

                                <div class="communication-tool-container">
                                    <div class="communication-tool" data-type="gtc">
                                        <img src="{{asset("images/color-full-logo.svg")}}"/>
                                    </div>
                                    <div class="communication-tool" data-type="skype">
                                        <img class="skype" src="{{asset("images/skype-logo.png")}}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <div style="display: flex;column-gap: 20px;">
                            <img class="plan-footer-avatar" src="{{!is_null($user_profile->profile->avatar) ? $user_profile->profile->avatar : asset('images/user.png')}}"/>
                            <input id="booking_profile_id" value="${consultant.profile_id}" hidden/>
                            <div class="bookin-detail">
                                <span style="display: flex; align-items:center; margin-right: 10px" id="booking-price"></span>
                                <span style="display: flex; align-items:center; margin-right: 10px" id="booking-title"></span>
                                <span style="display: flex; align-items:center; margin-right: 10px" id="booking-date"></span>
                                <span style="display: flex; align-items:center; margin-right: 10px" id="booking-tool"></span>
                            </div>
                        </div>
                        <div class="btn-groups">
                            <button type="button" class="btn btn-preview mr-1 d-none">Previous</button>
                            <button type="button" class="btn btn-next">Next</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <form id="from-booking" action="{{ route('booking') }}" method="POST">
            @csrf
            <input id="inp-booking-data" type="hidden" name="data"/>
        </form>
    </div>
    </div>
    </div>
    <svg width="0" height="0" version="1.1" xmlns="http://www.w3.org/2000/svg">
        <defs>
            <linearGradient id="MyGradient" x1="0%" y1="0%" x2="0%" y2="100%">
                <stop offset="5%" stop-color="#6c9cff" />
                <stop offset="95%" stop-color="#8773ff" />
            </linearGradient>
        </defs>
    </svg>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.5.2/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://unpkg.com/gijgo@1.9.11/js/gijgo.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.4.11/d3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.11/c3.js"></script>
    <script src="{{ asset('js/intlTelInput.min.js') }}"></script>
    <script src="{{ asset('js/jquery.crs.min.js') }}"></script>
    <script src="{{ asset('js/mark-your-calendar.js') }}"></script>
    <script src="{{ asset('js/timezones.full.min.js') }}"></script>
    <script src="{{ asset('js/member-gotoconsult.js') }}"></script>
    <script>
        var myAvaliablity = Array(7).fill(['0:00', '1:00', '2:00', '3:00', '4:00', '5:00', '6:00', '7:00', '8:00', '9:00',
            '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00',
            '21:00', '22:00', '23:00'
        ]);
        var selectedDates = $("#timetable").val().split(",");
        var nonAvailableSlots = [];
        var today = new Date();
        for(i=0;i<24;i++){
            var pattern = " " + i + ":00";
            var isContained = 0;
            for(j=0;j<selectedDates.length;j++){
                var obs_date = new Date(selectedDates[j]);
                if(obs_date >= today && selectedDates[j].includes(pattern))
                    isContained = 1;
            }
            if(isContained !== 1)
                nonAvailableSlots.push(i + ":00");
        }

        var selectedConsultantId = parseInt("{{$user_id}}");
        var selectedPlanId = 0;
        var selectedSessionPrice = null;
        var selectedSesionTitle = null;
        var selectedSessionId = 0;
        var selectedBookingDate = null;
        var selectedCommunicationWay = null;

        var step = 1;

        $(document).ready(function() {
            $("#day-schedule").markyourcalendar({
                availability: myAvaliablity,
                weekdays: ['Sun', 'Mon', 'Tue', 'Wed', 'Thurs', 'Fri', 'Sat'],
                startDate: new Date(),
                isMultiple: true,
                selectedDates: selectedDates,
                onClickNavigator: function(ev, instance) {
                    instance.setAvailability(myAvaliablity);
                    initSchedulerB();
                },
                onClick: (ev, data) => {
                    @if ($request_type != 'own')
                    selectedBookingDate = $(ev.target).attr("data-date");
                    $("#modal-booking").modal("show");
                    $("#booking-date").html(`<span style="font-weight: bold">Booked Date: &nbsp;</span>` + selectedBookingDate);
                    @else
                    selectedDates = data;
                    $("#timetable").val(selectedDates);
                    @endif
                }
            });
            initSchedulerB();

            $(".btn-next").on('click', function(){
                step++;
                $(".step-circle.active").removeClass('active');
                $(`.step-circle:nth-child(${step})`).addClass('active');

                if(step === 2){
                    $(".btn-preview").removeClass('d-none');
                    $('#exampleModalLabel').html("Session options");
                    $('.plan-container').addClass('d-none');
                    $('.session-container').removeClass('d-none');
                }

                if(step === 3){
                    $('#exampleModalLabel').html("Communication Tool");
                    $('.session-container').addClass('d-none');
                    $('.communication-container').removeClass('d-none');
                }

                if(step === 4){
                    const data = {  
                        'profileID': $('#booking_profile_id').val(),
                        'consultantID': selectedConsultantId,
                        'planID': selectedPlanId,
                        'sessionID': selectedSessionId, 
                        'date': selectedBookingDate,
                        'communicationType': selectedCommunicationWay
                    }
                    $('#inp-booking-data').val(JSON.stringify(data));
                    $('#from-booking').submit();
                }
            });

            $(".btn-preview").on('click', function(){
                step--;
                $(".step-circle.active").removeClass('active');
                $(`.step-circle:nth-child(${step})`).addClass('active');

                if(step === 1){
                    $(".btn-preview").addClass('d-none');
                    $('#exampleModalLabel').html("Selecet your plan");
                    $('.plan-container').removeClass('d-none');
                    $('.session-container').addClass('d-none');
                }

                if(step === 2){
                    $('#exampleModalLabel').html("Session options");
                    $('.session-container').removeClass('d-none');
                    $('.communication-container').addClass('d-none');
                }
            });

            $("li.plan").on('click', function() {
                $("li.plan.active").removeClass('active');
                $(this).addClass('active');

                selectedPlanId = $(this).attr("data-id");
                $(`div.plan-session-container[data-plan-id='${selectedPlanId}']`).removeClass("d-none");
            });

            $(".plan-session").on('click', function() {
                $(".plan-session.active").removeClass('active');
                $(this).addClass('active');

                selectedSessionId = $(this).attr("data-id");
                selectedSessionPrice = $(this).attr("data-price");
                selectedSessionTitle = $(this).attr("data-title");

                $("#booking-price").html(`<span style="font-weight: bold">Price: &nbsp;</span>NOK ` + selectedSessionPrice);
                $("#booking-title").html(`<span style="font-weight: bold">Session: &nbsp;</span>` + selectedSessionTitle);
            });

            $(".communication-tool").on('click', function() {
                $(".communication-tool.active").removeClass('active');
                $(this).addClass('active');

                selectedCommunicationWay = $(this).attr("data-type");
                selectedCommunicationWay = selectedCommunicationWay === 'gtc' ? 'GotoConsult' : selectedCommunicationWay;
                selectedCommunicationWay = selectedCommunicationWay === 'skype' ? 'Skype' : selectedCommunicationWay;
                $("#booking-tool").html(`<span style="font-weight: bold">Communication: &nbsp;</span>` + selectedCommunicationWay);
            });
        });

        function initSchedulerB() {
            @if ($request_type != 'own')
                $(`a.myc-available-time`).addClass('disabled');
                for(i=0;i<nonAvailableSlots.length;i++){
                    $("a.myc-available-time[data-time='"+nonAvailableSlots[i]+"']").addClass('d-none');
                }
            @endif
            selectedDates.forEach((ele) => {
                var date = ele.split(" ")[0];
                var time = ele.split(" ")[1];
                $(`a.myc-available-time[data-date='${date}'][data-time='${time}']`).addClass('selected');
                $(`a.myc-available-time[data-date='${date}'][data-time='${time}']`).removeClass('disabled');
            });
        }
    </script>
    <script>
        public();
        const user_profile = @json($user_profile);
        const review_info = @json($review_info);
        const chart_info = @json($chart_info);
        const img_group = {
            "profile-icon-w": @json(asset('images/profile-icon-w.svg')),
            "comment-w": @json(asset('images/comment-w.svg')),
            "star-w": @json(asset('images/star-w.svg')),
            "profile-icon": @json(asset('images/profile-icon.svg')),
            "comment": @json(asset('images/comment.svg')),
            "star": @json(asset('images/star.svg'))
        };
        profile(user_profile, review_info, chart_info, img_group);
    </script>
@endsection
