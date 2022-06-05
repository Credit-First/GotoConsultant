@extends('layout.private')
@section('title', 'GoToConsult - Pages')
@section('content')
<?php $lang = app()->getLocale();?>
<div class="admin-wrapper">
  @include('elements.admin_sidebar')
  <div class="content-wrapper adminprof">
    <div class="single-page">
      <div class="pages-heading">
        <h2>@lang('member.dashboard')</h2>
        <div class="filter-tag dashboard ml-auto">
          <div class="form-group">
            <label for="start_date">@lang('member.start_date'):</label>
            <input type="text" class="form-control date-picker" id="start_date" name="start_date" readonly>
          </div>
          <div class="form-group">
            <label for="end_date">@lang('member.end_date'):</label>
            <input type="text" class="form-control date-picker" id="end_date" name="end_date" readonly>
          </div>
          <button id="filter">@lang('member.filter')</button>
        </div>
      </div>
      <div class="page-dashboard admin">
        <div class="current-bal page-border">
          <div class="icon-box pr-3">
            <img src="{{asset('images/customer-icon.svg')}}" alt="no-image"/>
          </div>
          <div class="balance-status">
            <h3>@lang('admin_sidebar.customers')</h3>
            <div class="underline-bar"></div>
            <div class="balance-value">
              <span>{{$customers}} @lang('member.registrations')</span>
              <a href="{{ $lang == 'en' ? url('/customers') : url('/no/kunder') }}">@lang('member.view-customers')</a>
            </div>
          </div>
        </div>
        <div class="mobile-step2">
          <div class="d-flex justify-content-center pb-3">
              <img src="images/customer-icon.svg">
          </div>
          <div class="d-flex align-items-center flex-column">
              <h3>@lang('admin_sidebar.customers')</h3>
              <div class="underline-bar"></div>
              <span class="updated_balance">{{$customers}} @lang('member.registrations')</span>
          </div>
          <a href="{{ $lang == 'en' ? url('/customers') : url('/no/kunder') }}" class="btn add-credit-btn">@lang('member.view-customers')</a>
        </div>
        <div class="current-bal page-border">
          <div class="icon-box pr-3">
            <img src="{{asset('images/consultants-icon.svg')}}" alt="no-image"/>
          </div>
          <div class="balance-status">
            <h3>@lang('admin_sidebar.consultants')</h3>
            <div class="underline-bar"></div>
            <div class="balance-value">
              <span>{{$consultants}} @lang('member.registrations')</span>
              <a href="{{ $lang == 'en' ? url('/consultants') : url('/no/konsulenter') }}">@lang('member.view-consultants')</a>
            </div>
          </div>
        </div>
        <div class="mobile-step2">
          <div class="d-flex justify-content-center pb-3">
              <img src="images/earnings-icon.svg">
          </div>
          <div class="d-flex align-items-center flex-column">
              <h3>@lang('admin_sidebar.consultants')</h3>
              <div class="underline-bar"></div>
              <span class="updated_balance"> {{$consultants}} @lang('member.registrations')</span>
          </div>
          <a href="{{ $lang == 'en' ? url('/customers') : url('/no/kunder') }}" class="btn add-credit-btn">@lang('member.view-consultants')</a>
        </div>
        <div class="current-bal page-border">
          <div class="icon-box pr-3">
            <img src="{{asset('images/earnings-icon.svg')}}" alt="no-image"/>
          </div>
          <div class="balance-status">
            <h3>@lang('admin.earnings')</h3>
            <div class="underline-bar"></div>
            <div class="balance-value">
              <?php
                $fmt = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
                $fmt->setTextAttribute(NumberFormatter::CURRENCY_CODE, 'NOK');
                $fmt->setAttribute( $fmt::FRACTION_DIGITS, 2 );
                $cost = str_replace(',', ' ', $fmt->formatCurrency($earning, 'NOK'));
              ?>
              <span>{{$cost}}</span>
              <a href="{{ $lang == 'en' ? url('/admin-transaction') : url('/no/admin-transaksjoner') }}" class="btn add-credit-btn">@lang('member.view-transactions')</a>
            </div>
          </div>
        </div>
        <div class="mobile-step2">
          <div class="d-flex justify-content-center pb-3">
              <img src="images/customer-icon.svg">
          </div>
          <div class="d-flex align-items-center flex-column">
              <h3>@lang('admin.earnings')</h3>
              <div class="underline-bar"></div>
              <span class="updated_balance"> NOK</span>
          </div>
          <a href="{{ $lang == 'en' ? url('/admin-transaction') : url('/no/admin-transaksjoner') }}" class="btn add-credit-btn">@lang('member.view-transactions')</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
<script>
	const search = @json($search);
  dashboard(search);
</script>
@endsection