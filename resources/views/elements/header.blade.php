<?php $logo_url = $lang == 'en' ? url('/') : url('/no'); ?>
<nav class="navbar navbar-expand-lg sticky">
  <div class="container">
    <div class="col-12 d-flex">
      <a class="navbar-brand" href="{{ $logo_url }}">
        <img src="{{ asset('images/color-full-logo.svg') }}" alt="logo"/>
      </a>
      <div class="ml-auto align-self-center">
        <button class="navbar-toggler public">
          <span></span>
          <span></span>
          <span></span>
        </button>
        <div class="collapse navbar-collapse desktop">
          <ul class="end-nav ml-auto mr-3">
            <li class="nav-item dropdown">
              <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                @lang('header.services')
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                @foreach ($categories as $key => $category)
                  <?php
                    $category_url = $lang == 'en' ? url('/category/'.$category->category_url) : url('/no/kategori/'.$category->category_url);
                    $category_name = $lang == 'en' ? $category->category_name : $category->category_name_no;
                  ?>
                  <a class="dropdown-item" href="{{ $category_url }} ">{{ $category_name }}</a>
                @endforeach
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link link" href="{{ $lang == 'en' ? url('/features') : url('/no/funksjoner') }}">@lang('header.features') </a>
            </li>
            <li class="nav-item">
              <a class="nav-link link" href="{{ $lang == 'en' ? url('/about') : url('/no/om-oss') }}">@lang('header.about_us')</a>
            </li>
            <li class="nav-item">
              <a class="nav-link link" href="{{ $lang == 'en' ? url('/login') : url('/no/logg-inn') }}">@lang('header.login')</a>
            </li>
            <li class="nav-item">
              <a class="nav-link btn" href="{{ $lang == 'en' ? url('/register') : url('/no/registrer') }}">@lang('header.register')</a>
            </li>
            <li class="nav-item">
              <a class="nav-link btn" href="{{ $lang == 'en' ? url('/become-consultant') : url('/no/bli-konsulent') }}">@lang('header.become_consultant') </a>
            </li>
          </ul>
          <div class="end-nav">
            <div class="dropdown">
              <form class="lang-form" method="post" action="{{url('/site-lang')}}">
                {{ csrf_field() }}
                <input type="text" class="selected_lang" name="lang" hidden>
                <input type="text" class="current_address" name="address" hidden>
                <button type="submit" class="btn lang-btn public-btn-country">
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
    </div>
  </div>
</nav>

<section class="navbar-sidebar">
  <div class="navbar-sidebar__overlay"></div>
  <div class="navigation__nav">
    <div class="navigation-header">
      <div class="container">
        <div class="col-12 d-flex">
          <a class="navigation__brand" href="{{ $logo_url }}"><img src="{{ asset('images/color-full-logo.svg')}}" alt="logo"/></a>
          <div class="ml-auto align-self-center">
            <button class="navigation-toggler public">
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
        <div class="nav-item dropdown">
          <a class="dropdown-toggle" data-toggle="collapse" data-target="#side-dropdown-menu" href="#" id="navbarSideDropdown">
            @lang('header.services')
          </a>
        </div>
        <div class="side-dropdown-menu collapse" id="side-dropdown-menu">
          @foreach ($categories as $key => $category)
            <?php
              $category_url = $lang == 'en' ? url('/category/'.$category->category_url) : url('/no/kategori/'.$category->category_url);
              $category_name = $lang == 'en' ? $category->category_name : $category->category_name_no;
            ?>
            <a class="dropdown-item" href="{{ $category_url }} ">{{ $category_name }}</a>
          @endforeach
        </div>
        <div class="nav-item">
          <a href="{{ $lang == 'en' ? url('/features') : url('/no/funksjoner') }}">@lang('header.features') </a>
        </div>
        <div class="nav-item">
          <a href="{{ $lang == 'en' ? url('/about') : url('/no/om-oss') }}">@lang('header.about_us')</a>
        </div>
        <div class="nav-item">
          <a href="{{ $lang == 'en' ? url('/login') : url('/no/logg-inn') }}">@lang('header.login')</a>
        </div>
        <div class="nav-item">
          <a href="{{ $lang == 'en' ? url('/register') : url('/no/registrer') }}">@lang('header.register')</a>
        </div>
        <div class="nav-item">
          <a href="{{ $lang == 'en' ? url('/become-consultant') : url('/no/bli-konsulent') }}">@lang('header.become_consultant') </a>
        </div>
        <div class="nav-item">
          <form class="lang-form" method="post" action="{{url('/site-lang')}}">
            {{ csrf_field() }}
            <input type="text" class="selected_lang" name="lang" hidden>
            <input type="text" class="current_address" name="address" hidden>
            <button type="submit" class="btn public-btn-country">
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
</section>