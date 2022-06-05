<nav class="navbar navbar-expand-lg private sticky">
  <a class="navbar-brand" href="{{ $lang == 'en' ? url('/dashboard') : url('/no/oversikt') }}"><img src="{{ asset('images/color-full-logo.svg') }}" alt="logo"/></a>
  <div class="ml-auto end-nav">
    <button class="navbar-toggler private">
      @if(isset($user_info->profile) && isset($user_info->profile->avatar))
        <div class="avatar-pic" style="background-image: url('{{ $user_info->profile->avatar }}'); background-size: cover;"></div>
      @else
        <div class="avatar-pic"></div>
      @endif
      <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" class="svg-inline--fa fa-angle-right fa-w-8 fa-lg"><path fill="#595959" d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z" class=""></path></svg>
    </button>
    <a class="nav-link" href="{{ $lang == 'en' ? url('/find-consultant') : url('/no/finn-konsulent') }}">@lang('header.find_consultant')</a>
    <div class="dropdown">
      <button type="button" class="btn nav-right dropdown-toggle user-btn" data-toggle="dropdown">
        @if(isset($user_info->profile) && isset($user_info->profile->avatar))
          <div class="avatar-pic" style="background-image: url('{{ $user_info->profile->avatar }}'); background-size: cover;"></div>
        @else
          <div class="avatar-pic"></div>
        @endif
        <span>{{auth()->user()->first_name}} {{auth()->user()->last_name}}</span>
      </button>
      <div class="dropdown-menu profile-dropdown">
        <a class="dropdown-item" href="{{ $lang == 'en' ? url('/dashboard') : url('/no/oversikt') }}">@lang('member.dashboard')</a>
        <a class="dropdown-item" href="{{ $lang == 'en' ? url('/sessions') : url('/no/moter') }}">@lang('member.my-sessions')</a>
        <a class="dropdown-item" href="{{ $lang == 'en' ? url('/calendar') : url('/no/kalender') }}">@lang('member.calendar')</a>
        <a class="dropdown-item" href="{{ $lang == 'en' ? url('/wallet') : url('/no/lommebok') }}">@lang('member.wallet')</a>
        <a class="dropdown-item" href="{{ $lang == 'en' ? url('/transactions') : url('/no/transaksjoner') }}">@lang('member.my-transaction')</a>
        <a class="dropdown-item" href="{{ $lang == 'en' ? url('/profile') : url('/no/profil') }}">@lang('member.profile')</a>
        <a class="dropdown-item" href="{{ $lang == 'en' ? url('/member-settings') : url('/no/kontoinnstillinger') }}">@lang('member.settings')</a>
        <a class="dropdown-item" href="{{url('/logout')}}">@lang('member.log_out')</a>
      </div>
    </div>
    <div class="dropdown">
      <form class="member-lang-form" method="post" action="{{url('/site-lang')}}">
        {{ csrf_field() }}
        <input type="text" class="member_selected_lang" name="lang" hidden>
        <input type="text" class="member_current_address" name="address" hidden>
        <button type="submit" class="btn lang-btn member-btn-country">
          @if($lang == 'en')
            <img src="{{ asset('images/norsk.svg')}}" />
          @else
            <img src="{{ asset('images/english.svg')}}" />
          @endif
        </button>
      </form>
    </div>
  </div>
</nav>

<section class="navbar-sidebar">
  <div class="navbar-sidebar__overlay"></div>
  <div class="navigation__nav">
    <div class="navigation-header">
      <div class="container">
        <div class="col-12 d-flex">
          <a class="navigation__brand" href="{{ $lang == 'en' ? url('/') : url('/no') }}"><img src="{{ asset('images/color-full-logo.svg')}}" alt="logo"/></a>
          <div class="ml-auto align-self-center">
            <button class="navigation-toggler">
              <span></span>
              <span></span>
              <span></span>
            </button>
          </div>
        </div>
      </div>
    </div>
    <div class="main-content">
      <div class="item-list">
        <div class="{{ $active == '0' ? 'active nav-item' : 'nav-item' }}">
          <a href="{{ $lang == 'en' ? url('/dashboard') : url('/no/oversikt') }}">@lang('member.dashboard')</a>
        </div>
        <div class="{{ $active == '1' ? 'active nav-item' : 'nav-item' }}">
          <a href="{{ $lang == 'en' ? url('/sessions') : url('/no/moter') }}">@lang('member.my-sessions')</a>
        </div>
        <div class="{{ $active == '8' ? 'active nav-item' : 'nav-item' }}">
          <a href="{{ $lang == 'en' ? url('/calendar') : url('/no/kalender') }}">@lang('member.calendar')</a>
        </div>
        <div class="{{ $active == '2' ? 'active nav-item' : 'nav-item' }}">
          <a href="{{ $lang == 'en' ? url('/wallet') : url('/no/lommebok') }}">@lang('member.wallet')</a>
        </div>
        <div class="{{ $active == '3' ? 'active nav-item' : 'nav-item' }}">
          <a href="{{ $lang == 'en' ? url('/transactions') : url('/no/transaksjoner') }}">@lang('member.my-transaction')</a>
        </div>
        <div class="{{ $active == '4' ? 'active nav-item' : 'nav-item' }}">
          <a href="{{ $lang == 'en' ? url('/profile') : url('/no/profil') }}">@lang('member.profile')</a>
        </div>
        <div class="{{ $active == '5' ? 'active nav-item' : 'nav-item' }}">
          <a href="{{ $lang == 'en' ? url('/member-settings') : url('/no/kontoinnstillinger') }}">@lang('member.settings')</a>
        </div>
        <div class="nav-item">
          <a href="{{ $lang == 'en' ? url('/find-consultant') : url('/no/finn-konsulent') }}">@lang('header.find_consultant')</a>
        </div>
        <div class="nav-item">
          <a href="{{url('/logout')}}">@lang('member.log_out')</a>
        </div>
        <div class="nav-item">
          <form class="member-lang-form" method="post" action="{{url('/site-lang')}}">
            {{ csrf_field() }}
            <input type="text" class="member_selected_lang" name="lang" hidden>
            <input type="text" class="member_current_address" name="address" hidden>
            <button type='submit' class="btn member-btn-country">
              @if($lang == 'en')
                <img src="{{ asset('images/norsk.svg')}}" />
                Norsk
              @else
                <img src="{{ asset('images/english.svg')}}" />
                English
              @endif
            </button>
          </form>
        </div>
      </div>    
    </div>
  </div>
</section>