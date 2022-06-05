<nav class="navbar navbar-expand-lg sticky">
  <a class="navbar-brand" href="{{ $lang == 'en' ? url('/admin-dashboard') : url('/no/admin-dashbord') }}"><img src="{{ asset('images/color-full-logo.svg')}}" alt="logo"/></a>
  <div class="ml-auto align-self-center">
    <button class="navbar-toggler private">
      @if(isset($user_info->profile) && isset($user_info->profile->avatar))
        <div class="avatar-pic" style="background-image: url('{{ $user_info->profile->avatar }}'); background-size: cover;"></div>
      @else
        <div class="avatar-pic"></div>
      @endif
      <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" class="svg-inline--fa fa-angle-right fa-w-8 fa-lg"><path fill="#595959" d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z" class=""></path></svg>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
      <div class="end-nav ml-auto">
        <div class="dropdown">
          <button type="button" class="btn nav-right dropdown-toggle user-btn" data-toggle="dropdown">
            @if(isset($user_info->profile) && isset($user_info->profile->avatar))
              <div class="avatar-pic" style="background-image: url('{{ $user_info->profile->avatar }}'); background-size: cover;"></div>
            @else
              <div class="avatar-pic"></div>
            @endif
            <span>{{auth()->user()->first_name}} {{auth()->user()->last_name}}</span>
          </button>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="{{ $lang == 'en' ? url('/dashboard') : url('/no/oversikt') }}">@lang('member.dashboard')</a>
            <a class="dropdown-item" href="{{ $lang == 'en' ? url('/customers') : url('/no/kunder') }}">@lang('admin_sidebar.customers')</a>
            <a class="dropdown-item" href="{{ $lang == 'en' ? url('/consultants') : url('/no/konsulenter') }}">@lang('admin_sidebar.consultants')</a>
            <a class="dropdown-item" href="{{ $lang == 'en' ? url('/categories') : url('/no/kategorier') }}">@lang('admin_sidebar.categories')</a>
            <a class="dropdown-item" href="{{ $lang == 'en' ? url('/pages') : url('/no/sider') }}">@lang('admin_sidebar.pages')</a>
            <a class="dropdown-item" href="{{ $lang == 'en' ? url('/admin-transaction') : url('/no/admin-transaksjoner') }}">@lang('admin_sidebar.transactions')</a>
            <a class="dropdown-item" href="{{ $lang == 'en' ? url('/settings') : url('/no/innstillinger') }}">@lang('admin_sidebar.settings')</a>
            <a class="dropdown-item" href="{{ url('/logout')}}">@lang('admin_sidebar.logout')</a>
          </div>
        </div>
        <div class="dropdown">
          <form class="admin-lang-form" method="post" action="{{url('/site-lang')}}">
            {{ csrf_field() }}
            <input type="text" class="admin_selected_lang" name="lang" hidden>
            <input type="text" class="admin_current_address" name="address" hidden>
            <button type='submit' class="btn lang-btn admin-btn-country">
              @if($lang == 'en')
                <img src="{{ asset('images/norsk.svg')}}" />
              @else
                <img src="{{ asset('images/english.svg')}}" />
              @endif
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</nav>

<section class="navbar-sidebar">
  <div class="navbar-sidebar__overlay"></div>
  <div class="navigation__nav">
    <div class="navigation-header">
      <div class="container">
        <div class="col-12 d-flex">
          <a class="navigation__brand" href="{{ $lang == 'en' ? url('/admin-dashboard') : url('/no/admin-dashbord') }}"><img src="{{ asset('images/color-full-logo.svg')}}" alt="logo"/></a>
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
          <a href="{{ $lang == 'en' ? url('/customers') : url('/no/kunder') }}">@lang('admin_sidebar.customers')</a>
        </div>
        <div class="{{ $active == '2' ? 'active nav-item' : 'nav-item' }}">
          <a href="{{ $lang == 'en' ? url('/consultants') : url('/no/konsulenter') }}">@lang('admin_sidebar.consultants')</a>
        </div>
        <div class="{{ $active == '3' ? 'active nav-item' : 'nav-item' }}">
          <a href="{{ $lang == 'en' ? url('/categories') : url('/no/kategorier') }}">@lang('admin_sidebar.categories')</a>
        </div>
        <div class="{{ $active == '4' ? 'active nav-item' : 'nav-item' }}">
          <a href="{{ $lang == 'en' ? url('/pages') : url('/no/sider') }}">@lang('admin_sidebar.pages')</a>
        </div>
        <div class="{{ $active == '5' ? 'active nav-item' : 'nav-item' }}">
          <a href="{{ $lang == 'en' ? url('/admin-transaction') : url('/no/admin-transaksjoner') }}">@lang('admin_sidebar.transactions')</a>
        </div>
        <div class="{{ $active == '6' ? 'active nav-item' : 'nav-item' }}">
          <a href="{{ $lang == 'en' ? url('/settings') : url('/no/innstillinger') }}">@lang('admin_sidebar.settings')</a>
        </div>
        <div class="nav-item">
          <a href="{{url('/logout')}}">@lang('member.log_out')</a>
        </div>
        <div class="nav-item">
          <form class="admin-lang-form" method="post" action="{{url('/site-lang')}}">
            {{ csrf_field() }}
            <input type="text" class="admin_selected_lang" name="lang" hidden>
            <input type="text" class="admin_current_address" name="address" hidden>
            <button type='submit' class="btn admin-btn-country">
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