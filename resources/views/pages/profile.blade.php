@extends('layout.public')
@section('title', $title)
@section('description', $description)
@section('content')
<?php
	use Jenssegers\Agent\Agent as Agent;
	$agent = new Agent();
?>
<svg width="0" height="0" version="1.1" xmlns="http://www.w3.org/2000/svg">
  <defs>
    <linearGradient id="MyGradient" x1="0%" y1="0%" x2="0%" y2="100%">
      <stop offset="5%" stop-color="#6c9cff" />
      <stop offset="95%" stop-color="#8773ff" />
    </linearGradient>
  </defs>
</svg>
<div class="container">
  <div class="col-12">
    <div class="profile-card-left single-profile">
      <div class="profile-header">
        @if($user_profile->profile && $user_profile->profile->cover_img)
        <div class="profile-cover" style="background-image: url('{{ $user_profile->profile->cover_img}}'); background-position: center; background-repeat: no-repeat; background-size: cover;">
        @else
        <div class="profile-cover">
          <img src="{{asset('images/white-logo.svg')}}" />
        @endif
        </div>
        <div class="profile-card profile-sub-header">
          @if($user_profile->profile && $user_profile->profile->avatar)
          <div class="avatar-pic" style="background-image: url('{{ $user_profile->profile->avatar}}'); background-position: center; background-repeat: no-repeat; background-size: cover;">
            @if(!is_null($user_profile->company))
							<span><img src="{{ asset('images/mortarboard-w.svg') }}" alt="no-img" /></span>
            @endif
          </div>
          @else
          <div class="avatar-pic">
            <img src="{{asset('images/white-logo.svg')}}" />
            @if(!is_null($user_profile->company))
							<span><img src="{{ asset('images/mortarboard-w.svg') }}" alt="no-img" /></span>
            @endif
          </div>
          @endif
          <div class="detail-info">
            @if($user_profile->user->role == 'consultant' && $agent->isMobile())
            {{$user_profile->hourly_rate}} p/m
            @endif
            <div class="status">
              <h2>{{$user_profile->user->first_name}} {{$user_profile->user->last_name}}</h2>
              @if($user_profile->user->status == "available")
              <label class="available">
                @if(!$agent->isMobile())
                  {{$user_profile->user->status}}
                @endif
              </label>
              @elseif($user_profile->user->status == "offline")
              <label class="offline">
                @if(!$agent->isMobile())
                  {{$user_profile->user->status}}</label>
                @endif
              @else
              <label class="busy">
                @if(!$agent->isMobile())
                  {{$user_profile->user->status}}</label>
                @endif
              @endif
            </div>
            <div class="star-images">
              @if($user_profile['rate'] == 5)
              <ul class="d-flex">
                  <li><img src="{{asset('images/home/star-dg.png')}}" alt="no-img" /></li>
                  <li><img src="{{asset('images/home/star-dg.png')}}" alt="no-img" /></li>
                  <li><img src="{{asset('images/home/star-dg.png')}}" alt="no-img" /></li>
                  <li><img src="{{asset('images/home/star-dg.png')}}" alt="no-img" /></li>
                  <li><img src="{{asset('images/home/star-dg.png')}}" alt="no-img" /></li>
              </ul>
              @elseif($user_profile['rate'] == 4)
              <ul class="d-flex">
                  <li><img src="{{asset('images/home/star-g.png')}}" alt="no-img" /></li>
                  <li><img src="{{asset('images/home/star-g.png')}}" alt="no-img" /></li>
                  <li><img src="{{asset('images/home/star-g.png')}}" alt="no-img" /></li>
                  <li><img src="{{asset('images/home/star-g.png')}}" alt="no-img" /></li>
                  <li><img src="{{asset('images/home/star-w.png')}}" alt="no-img" /></li>
              </ul>
              @elseif($user_profile['rate'] == 3)
              <ul class="d-flex">
                  <li><img src="{{asset('images/home/star-y.png')}}" alt="no-img" /></li>
                  <li><img src="{{asset('images/home/star-y.png')}}" alt="no-img" /></li>
                  <li><img src="{{asset('images/home/star-y.png')}}" alt="no-img" /></li>
                  <li><img src="{{asset('images/home/star-w.png')}}" alt="no-img" /></li>
                  <li><img src="{{asset('images/home/star-w.png')}}" alt="no-img" /></li>
              </ul>
              @elseif($user_profile['rate'] == 2)
              <ul class="d-flex">
                  <li><img src="{{asset('images/home/star-o.png')}}" alt="no-img" /></li>
                  <li><img src="{{asset('images/home/star-o.png')}}" alt="no-img" /></li>
                  <li><img src="{{asset('images/home/star-w.png')}}" alt="no-img" /></li>
                  <li><img src="{{asset('images/home/star-w.png')}}" alt="no-img" /></li>
                  <li><img src="{{asset('images/home/star-w.png')}}" alt="no-img" /></li>
              </ul>
              @elseif($user_profile['rate'] == 1)
              <ul class="d-flex">
                  <li><img src="{{asset('images/home/star-r.png')}}" alt="no-img" /></li>
                  <li><img src="{{asset('images/home/star-w.png')}}" alt="no-img" /></li>
                  <li><img src="{{asset('images/home/star-w.png')}}" alt="no-img" /></li>
                  <li><img src="{{asset('images/home/star-w.png')}}" alt="no-img" /></li>
                  <li><img src="{{asset('images/home/star-w.png')}}" alt="no-img" /></li>
              </ul>
              @else
              <ul class="d-flex">
                  <li><img src="{{asset('images/home/star-w.png')}}" alt="no-img" /></li>
                  <li><img src="{{asset('images/home/star-w.png')}}" alt="no-img" /></li>
                  <li><img src="{{asset('images/home/star-w.png')}}" alt="no-img" /></li>
                  <li><img src="{{asset('images/home/star-w.png')}}" alt="no-img" /></li>
                  <li><img src="{{asset('images/home/star-w.png')}}" alt="no-img" /></li>
              </ul>
              @endif
              <?php $rate = $user_profile['rate'] ? number_format((float)$user_profile['rate'], 1) : number_format(0, 1); ?>
              <p>{{ $rate }}</p>
            </div>
            @if($user_profile->profile)
              <div class="details">
                @if($user_profile->user->role == 'consultant')
                  @if($user_profile->profile->profession)
                    <span>
                      <img src="{{ asset('images/portfolio.svg') }}" alt="no-img" />
                      @foreach($categories as $category)
                        @if($user_profile->profile->profession === $category->category_name)
                        {{$lang == 'en' ? $category->category_name : $category->category_name_no}}
                        @endif
                      @endforeach
                    </span>
                  @endif
                  @if($user_profile->profile->college && !$agent->isMobile())
                    <span>
                      <img src="{{ asset('images/mortarboard.svg') }}" alt="no-img" />
                      {{$user_profile->profile->college}}
                    </span>
                  @endif
                @endif
                @if(!$agent->isMobile())
                  @if(!is_null($user_profile->profile->from))
                    <span>
                      <img src="{{ asset('images/pin.svg') }}" alt="no-img" />
                      @lang('member.from') {{$user_profile->profile->from}}
                    </span>
                  @endif
                  @if(!is_null($user_profile->profile->country))
                    <span>
                      <img src="{{ asset('images/home.svg') }}" alt="no-img" />
                      @lang('member.lives-in') {{$user_profile->profile->region}}, {{$user_profile->profile->country}}
                    </span>
                  @endif
                  @if(!is_null($user_profile->profile->timezone))
                    <span>
                      <img src="{{ asset('images/clock.svg') }}" alt="no-img" />
                      {{$user_profile->profile->timezone}}
                    </span>
                  @endif
                @else
                  @if(!is_null($user_profile->profile->from))
                    <span>
                      <img src="{{asset('images/pin.svg')}}" alt="no-img" />
                      @lang('member.from') {{$user_profile->profile->from}}
                    </span>
                  @endif
                  @if(!$agent->isMobile())
                    @if(!is_null($user_profile->profile->country))
                      <span>
                        <img src="{{asset('images/home.svg')}}" alt="no-img" />
                        @lang('member.lives-in') {{$user_profile->profile->region}}, {{$user_profile->profile->country}}
                      </span>
                    @endif
                    @if(!is_null($user_profile->profile->timezone))
                      <span>
                        <img src="{{ asset('images/clock.svg') }}" alt="no-img" />
                        {{$user_profile->timezone}}
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
            <img src="{{asset('images/profile-icon-w.svg')}}" alt="">@lang('member.about')
          </div>
          <div class="tab sessions">
            <img src="{{asset('images/comment.svg')}}" alt="">@lang('member.sessions')
          </div>
          <div class="tab reviews">
            <img src="{{asset('images/star.svg')}}" alt="">@lang('member.reviews')
          </div>
        </div>
      </div>
      <div class="profile-card about">
        <div class="header">
          <h3>@lang('member.about-me')</h3>
          <p>
            @if($user_profile->user->role == 'consultant')
              @lang('member.consultant-membership') {{$user_profile->user->created_at}}
            @else
              @lang('member.customer-membership') {{$user_profile->user->created_at}}
            @endif
          </p>
        </div>
        <div class="body">
          @if ($user_profile->profile && !is_null($user_profile->profile->description))
          {!!$user_profile->profile->description!!}
          @else
          <p>@lang('member.no-about-us')</p>
          @endif
        </div>
      </div>
      <div class="profile-card sessions">
        <div class="rate-charts">
          <div class="chart-sec">
            <div class="header">
              <h3>@lang('member.completed-sessions')</h3>
            </div>
            <div class="chart-body">
              @if($chart_info['no_data'])
                <p>@lang('member.no-statistics')</p>
              @else
              <div class="completed-session-chart" id="completed-session-chart"></div>
              @endif
            </div>
          </div>
          @if(Auth::check() && auth()->user()->role == 'consultant' && !$chart_info['no_data'])
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
          @if($count > 0)
            @foreach($review_info as $key => $review)
              @if($key == 0)
              <div class="review-group">
              @elseif($key %2 == 0)
              </div>
              <div class="review-group">
              @endif						
              <div class="review" style="{{$key > 5 ? 'display: none' : ''}}">
                <div class="review-header">
                  <div class="review-personal-info">
                    @if($review->type == 'CUSTOCON' && $review->customer->profile && $review->customer->profile->avatar)
                    <div class="review-avatar mr-3" style="background-image: url('{{ $review->customer->profile->avatar }}'); background-position: center; background-repeat: no-repeat; background-size: cover;"></div>
                    @elseif($review->type == 'CONTOCUS' && $review->consultant->profile && $review->consultant->profile->avatar)
                    <div class="review-avatar mr-3" style="background-image: url('{{ $review->consultant->profile->avatar }}'); background-position: center; background-repeat: no-repeat; background-size: cover;"></div>
                    @else
                    <div class="review-avatar mr-3">
                      <img src="{{asset('images/white-logo.svg')}}" />
                    </div>
                    @endif
                    <div class="review-info">
                      @if($review->type == 'CUSTOCON' && $review->customer->user)
                      <p class="m-0"><b>{{$review->customer->user->first_name}} {{$review->customer->user->last_name}}</b></p>
                      @elseif($review->type == 'CONTOCUS' && $review->consultant->user)
                      <p class="m-0"><b>{{$review->consultant->user->first_name}} {{$review->consultant->user->last_name}}</b></p>
                      @endif
                      <?php
                        $newDate = date('M d, Y', strtotime($review->created_at));
                        $newDate = $lang != 'en' ? str_replace("May","Mai", $newDate) : $newDate;
                        $newDate = $lang != 'en' ? str_replace("Oct","Okt", $newDate) : $newDate;
                        $newDate = $lang != 'en' ? str_replace("Dec","Des", $newDate) : $newDate;
                      ?>
                      <p class="m-0">
                        @if($review->session < 2)
                        {{$review->session}} @lang('member.session')
                        @else
                        {{$review->session}} @lang('member.sessions')
                        @endif
                        &#183; {{$newDate}}
                      </p>
                    </div>
                  </div>
                  <div class="review-rate d-flex">
                    @if($review->rate > 4.5)
                    <div class="rate-stars d-flex pr-2">
                      <img src="{{asset('images/home/star-dg.png')}}" alt="no-image"/>
                      <img src="{{asset('images/home/star-dg.png')}}" alt="no-image"/>
                      <img src="{{asset('images/home/star-dg.png')}}" alt="no-image"/>
                      <img src="{{asset('images/home/star-dg.png')}}" alt="no-image"/>
                      <img src="{{asset('images/home/star-dg.png')}}" alt="no-image"/>
                    </div>
                    @elseif($review->rate > 3.5)
                    <div class="rate-stars d-flex pr-2">
                      <img src="{{asset('images/home/star-g.png')}}" alt="no-image"/>
                      <img src="{{asset('images/home/star-g.png')}}" alt="no-image"/>
                      <img src="{{asset('images/home/star-g.png')}}" alt="no-image"/>
                      <img src="{{asset('images/home/star-g.png')}}" alt="no-image"/>
                      <img src="{{asset('images/home/star-w.png')}}" alt="no-image"/>
                    </div>
                    @elseif($review->rate > 2.5)
                    <div class="rate-stars d-flex pr-2">
                      <img src="{{asset('images/home/star-y.png')}}" alt="no-image"/>
                      <img src="{{asset('images/home/star-y.png')}}" alt="no-image"/>
                      <img src="{{asset('images/home/star-y.png')}}" alt="no-image"/>
                      <img src="{{asset('images/home/star-w.png')}}" alt="no-image"/>
                      <img src="{{asset('images/home/star-w.png')}}" alt="no-image"/>
                    </div>
                    @elseif($review->rate > 1.5)
                    <div class="rate-stars d-flex pr-2">
                      <img src="{{asset('images/home/star-o.png')}}" alt="no-image"/>
                      <img src="{{asset('images/home/star-o.png')}}" alt="no-image"/>
                      <img src="{{asset('images/home/star-w.png')}}" alt="no-image"/>
                      <img src="{{asset('images/home/star-w.png')}}" alt="no-image"/>
                      <img src="{{asset('images/home/star-w.png')}}" alt="no-image"/>
                    </div>
                    @elseif($review->rate > 0.5)
                    <div class="rate-stars d-flex pr-2">
                      <img src="{{asset('images/home/star-r.png')}}" alt="no-image"/>
                      <img src="{{asset('images/home/star-w.png')}}" alt="no-image"/>
                      <img src="{{asset('images/home/star-w.png')}}" alt="no-image"/>
                      <img src="{{asset('images/home/star-w.png')}}" alt="no-image"/>
                      <img src="{{asset('images/home/star-w.png')}}" alt="no-image"/>
                    </div>
                    @else
                    <div class="rate-stars d-flex pr-2">
                      <img src="{{asset('images/home/star-w.png')}}" alt="no-image"/>
                      <img src="{{asset('images/home/star-w.png')}}" alt="no-image"/>
                      <img src="{{asset('images/home/star-w.png')}}" alt="no-image"/>
                      <img src="{{asset('images/home/star-w.png')}}" alt="no-image"/>
                      <img src="{{asset('images/home/star-w.png')}}" alt="no-image"/>
                    </div>
                    @endif
                    {{$review->rate}}.0
                  </div>
                </div>
                <div class="review-body">
                  {{$review->description}}
                </div>
              </div>
              @if($key == $count -1)
              </div>
              @endif
            @endforeach
            @if($count > 6)
            <div id="loadMore" style="">
              <a href="#">@lang('member.view-more')</a>
            </div>
            @endif
          @else
            <p>@lang('member.no-reviews')</p>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.4.11/d3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.11/c3.js"></script>
<script>
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
  public();
  profile(user_profile, review_info, chart_info, img_group);
</script>
@endsection