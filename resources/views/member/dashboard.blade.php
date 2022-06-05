@extends('layout.member')
@section('title', $title)
@section('description', $description)
@section('content')
    <?php
    use Jenssegers\Agent\Agent as Agent;
    $agent = new Agent();
    $agentType = ($agent->isTablet() ? 'tablet' : $agent->isMobile()) ? 'mobile' : 'desktop';
    $rate_imgs = [asset('images/home/star-dg.png'), asset('images/home/star-g.png'), asset('images/home/star-y.png'), asset('images/home/star-o.png'), asset('images/home/star-r.png'), asset('images/home/star-w.png')];
    $btn_imgs = [asset('images/home/ph.svg'), asset('images/home/ph-y.svg'), asset('images/home/ph-g.svg'), asset('images/home/video.svg'), asset('images/home/video-y.svg'), asset('images/home/video-g.svg'), asset('images/home/msg.svg'), asset('images/home/msg-y.svg'), asset('images/home/msg-g.svg')];
    $educatedIcon = asset('images/mortarboard-w.svg');
    ?>
    <div class="member-wrapper">
        @include('elements.member_sidebar')
        <div class="content-wrapper">
            <div class="single-page">
                <div class="pages-heading">
                    <h2>@lang('member.dashboard')</h2>
                </div>
                <div class="page-dashboard">
                    <div class="profile-header">
                        <div class="profile-sec page-border">
                            @if (!is_null($user_info->profile) && !is_null($user_info->profile->avatar))
                                <div class="avatar-pic"
                                    style="background-image: url('{{ $user_info->profile->avatar }}'); background-size: cover;">
                                    @if (!is_null($user_info->company))
                                        <span><img src="{{ asset('images/mortarboard-w.svg') }}" alt="no-img" /></span>
                                    @endif
                                </div>
                            @else
                                <div class="avatar-pic">
                                    @if (!is_null($user_info->company))
                                        <span><img src="{{ asset('images/mortarboard-w.svg') }}" alt="no-img" /></span>
                                    @endif
                                </div>
                            @endif
                            <div class="detail-info">
                                <h3>{{ $user_info->user->first_name }} {{ $user_info->user->last_name }}</h3>
                                <div class="star-images">
                                    @if ($user_info['rate'] == 5)
                                        <ul class="d-flex">
                                            <li><img src="{{ asset('images/home/star-dg.png') }}" alt="no-img" /></li>
                                            <li><img src="{{ asset('images/home/star-dg.png') }}" alt="no-img" /></li>
                                            <li><img src="{{ asset('images/home/star-dg.png') }}" alt="no-img" /></li>
                                            <li><img src="{{ asset('images/home/star-dg.png') }}" alt="no-img" /></li>
                                            <li><img src="{{ asset('images/home/star-dg.png') }}" alt="no-img" /></li>
                                        </ul>
                                    @elseif($user_info['rate'] == 4)
                                        <ul class="d-flex">
                                            <li><img src="{{ asset('images/home/star-g.png') }}" alt="no-img" /></li>
                                            <li><img src="{{ asset('images/home/star-g.png') }}" alt="no-img" /></li>
                                            <li><img src="{{ asset('images/home/star-g.png') }}" alt="no-img" /></li>
                                            <li><img src="{{ asset('images/home/star-g.png') }}" alt="no-img" /></li>
                                            <li><img src="{{ asset('images/home/star-w.png') }}" alt="no-img" /></li>
                                        </ul>
                                    @elseif($user_info['rate'] == 3)
                                        <ul class="d-flex">
                                            <li><img src="{{ asset('images/home/star-y.png') }}" alt="no-img" /></li>
                                            <li><img src="{{ asset('images/home/star-y.png') }}" alt="no-img" /></li>
                                            <li><img src="{{ asset('images/home/star-y.png') }}" alt="no-img" /></li>
                                            <li><img src="{{ asset('images/home/star-w.png') }}" alt="no-img" /></li>
                                            <li><img src="{{ asset('images/home/star-w.png') }}" alt="no-img" /></li>
                                        </ul>
                                    @elseif($user_info['rate'] == 2)
                                        <ul class="d-flex">
                                            <li><img src="{{ asset('images/home/star-o.png') }}" alt="no-img" /></li>
                                            <li><img src="{{ asset('images/home/star-o.png') }}" alt="no-img" /></li>
                                            <li><img src="{{ asset('images/home/star-w.png') }}" alt="no-img" /></li>
                                            <li><img src="{{ asset('images/home/star-w.png') }}" alt="no-img" /></li>
                                            <li><img src="{{ asset('images/home/star-w.png') }}" alt="no-img" /></li>
                                        </ul>
                                    @elseif($user_info['rate'] == 1)
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
                                    <?php $rate = $user_info['rate'] ? number_format((float) $user_info['rate'], 1) : number_format(0, 1); ?>
                                    <p>{{ $rate }}</p>
                                </div>
                                <div class="detail-profile">
                                    <div class="d-flex mr-3"><img src="/images/user.svg" /><span>@lang('member.user-id')
                                            {{ $user_info->user->id }}</span></div>
                                    <?php
                                    $isProfile = is_null($user_info->profile) ? false : true;
                                    $date = !$isProfile ? new DateTime('now', new DateTimeZone('Europe/Oslo')) : new DateTime('now', new DateTimeZone($user_info->profile->timezone));
                                    $cur_time = $date->format('H:i:A');
                                    ?>
                                    @if ($isProfile)
                                        <div class="d-flex">
                                            <img src="/images/clock.svg" />
                                            <span>{{ $user_info->profile->timezone }}</span>
                                        </div>
                                    @else
                                        <div class="d-flex">
                                            <img src="/images/clock.svg" />
                                            <span>{{ $cur_time }} (Europe/Oslo)</span>
                                        </div>
                                    @endif
                                    <a
                                        href="{{ $lang == 'en' ? url('/profile') : url('/no/profil') }}">@lang('member.edit')</a>
                                </div>
                            </div>
                        </div>
                        @if ($user_info->user->role == 'customer')
                            <div class="current-bal page-border">
                                <div class="icon-box pr-3">
                                    <img src="{{ asset('images/earnings-icon.svg') }}" alt="no-image" />
                                </div>
                                <div class="balance-status">
                                    <h3>@lang('member.my_balance')</h3>
                                    <div class="underline-bar"></div>
                                    <?php
                                    $fmt = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
                                    $fmt->setTextAttribute(NumberFormatter::CURRENCY_CODE, 'NOK');
                                    $fmt->setAttribute($fmt::FRACTION_DIGITS, 2);
                                    $user_balance = str_replace(',', ' ', $fmt->formatCurrency($user_info->user->balance, 'NOK'));
                                    $cost_number = str_replace('NOK', '', $user_balance);
                                    ?>
                                    <div class="balance-value">
                                        <p class="m-0"><span
                                                class="pr-1">NOK</span>{{ $cost_number }}</p>
                                        <a
                                            href="{{ $lang == 'en' ? url('/wallet') : url('/no/lommebok') }}">@lang('member.add-credits')</a>
                                    </div>
                                </div>
                            </div>
                            <div class="mobile-step2">
                                <div class="d-flex justify-content-center pb-3">
                                    <img src="{{ asset('images/earnings-icon.svg') }}">
                                </div>
                                <div class="d-flex align-items-center flex-column">
                                    <h3>@lang('member.my_balance')</h3>
                                    <div class="underline-bar"></div>
                                    <span class="updated_balance">{{ $user_balance }}</span>
                                </div>
                                <button class="btn add-credit-btn">@lang('member.add-credits')</button>
                            </div>
                        @elseif($user_info->user->role == 'consultant')
                            <div class="current-bal page-border">
                                <div class="icon-box pr-3">
                                    <img src="{{ asset('images/earnings-icon.svg') }}" alt="no-image" />
                                </div>
                                <div class="balance-status">
                                    <h3>@lang('member.today_earning')</h3>
                                    <div class="underline-bar"></div>
                                    <div class="balance-value">
                                        <?php
                                        $fmt = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
                                        if ($user_info->currency == 'USD') {
                                            $fmt->setTextAttribute(NumberFormatter::CURRENCY_CODE, 'USD');
                                            $fmt->setAttribute($fmt::FRACTION_DIGITS, 2);
                                            $earning = str_replace('$', 'USD ', $fmt->formatCurrency($earning, 'USD'));
                                            $earning_number = str_replace('USD', '', $earning);
                                            $currency = 'USD';
                                        } elseif ($user_info->currency == 'EUR') {
                                            $fmt->setTextAttribute(NumberFormatter::CURRENCY_CODE, 'EUR');
                                            $fmt->setAttribute($fmt::FRACTION_DIGITS, 2);
                                            $earning = str_replace('€', 'EUR ', $fmt->formatCurrency($earning, 'EUR'));
                                            $earning_number = str_replace('EUR', '', $earning);
                                            $currency = 'EUR';
                                        } else {
                                            $fmt->setTextAttribute(NumberFormatter::CURRENCY_CODE, 'NOK');
                                            $fmt->setAttribute($fmt::FRACTION_DIGITS, 2);
                                            $earning = str_replace(',', ' ', $fmt->formatCurrency($earning, 'NOK'));
                                            $earning_number = str_replace('NOK', '', $earning);
                                            $currency = 'NOK';
                                        }
                                        
                                        ?>
                                        <p class="m-0"><span
                                                class="pr-1">{{ $currency }}</span>{{ $earning_number }}
                                        </p>
                                        <a
                                            href="{{ $lang == 'en' ? url('/transactions') : url('/no/transaksjoner') }}">@lang('member.view_transactions')</a>
                                    </div>
                                </div>
                            </div>
                            <div class="mobile-step2">
                                <div class="d-flex justify-content-center pb-3">
                                    <img src="{{ asset('images/earnings-icon.svg') }}">
                                </div>
                                <div class="d-flex align-items-center flex-column">
                                    <h3>@lang('member.today_earning')</h3>
                                    <div class="underline-bar"></div>
                                    <span class="updated_balance">{{ $earning }}</span>
                                </div>
                                <button class="btn add-credit-btn">@lang('member.view_transactions')</button>
                            </div>
                        @endif
                    </div>
                    @if ($user_info->user->role == 'customer')
                        @if ($count_sessions > 0)
                            <h3>@lang('member.recent-sessions')</h3>
                            <div class="page-border recommend sessions-view"></div>
                        @endif
                        @if ($count_consultants > 0)
                            <h3>@lang('member.recommended-consultants')</h3>
                            <div class="page-border recommend consultants-view"></div>
                            <form id="from-booking" action="{{ route('booking') }}" method="POST">
                                @csrf
                                <input id="inp-booking-data" type="hidden" name="data"/>
                            </form>
                        @endif
                    @elseif($user_info->user->role == 'consultant')
                        @if ($count_sessions > 0)
                            <h3>@lang('member.recent-sessions')</h3>
                            <div class="page-border recommend sessions-view"></div>
                        @endif
                        @if ($count_consultants > 0)
                            <h3>@lang('member.recommended-consultants')</h3>
                            <div class="page-border recommend consultants-view"></div>
                            <form id="from-booking" action="{{ route('booking') }}" method="POST">
                                @csrf
                                <input id="inp-booking-data" type="hidden" name="data"/>
                            </form>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{asset('js/mark-your-calendar.js')}}"></script>
    <script>
        const rate_imgs = @json($rate_imgs);
        const btn_imgs = @json($btn_imgs);
        const educatedIcon = @json($educatedIcon);
        const recommended_consultants = @json($recommended_consultants);
        const recent_sessions = @json($recent_sessions);
        const categories = @json($categories);
        dashboard(rate_imgs, btn_imgs, educatedIcon, recommended_consultants, recent_sessions, categories);
    </script>
@endsection
