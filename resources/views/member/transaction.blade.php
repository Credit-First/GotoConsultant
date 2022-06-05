@extends('layout.member')
@section('title', $title)
@section('description', $description)
@section('content')
<?php
  use Jenssegers\Agent\Agent as Agent;
  $agent = new Agent();
  $agentType = ( $agent->isTablet() ? 'tablet' : $agent->isMobile() ) ? 'mobile' : 'desktop';
?>
<div class="member-wrapper">
  @include('elements.member_sidebar')
  <div class="content-wrapper">
    <div class="single-page">
      <div class="pages-heading">
        <h2>@lang('member.my-transaction')</h2>
      </div>
      <div class="pages-top-sec my-transaction">
        <div class="sort-section member">
          <div class="dropdown-box">
            <label for="consultant">@if($user_info->user->role === 'customer') @lang('member.consultant'): @else @lang('member.users'): @endif</label>
            <select id="consultant" name="consultant" class="form-control consultant">
              <option {{$search['consultant'] == 'All' ? 'selected' : ''}}>@lang('member.all')</option>
              @foreach($consultants as $consultant)
              <option value="{{$consultant->user->id}}" {{$consultant->user->id == $search['consultant'] ? 'selected' : ''}}>
                {{$consultant->user->first_name}} {{$consultant->user->last_name}}
              </option>
              @endforeach
            </select>
          </div>
          @if(Auth::user()->role == 'consultant')
          <div class="dropdown-box">
            <label for="type">Type: </label>
            <select id="earn_type" name="type" class="form-control">
              <option value="All" selected>@lang('member.all')</option>
              <option value="earn" {{$search['type'] == 'earn' ? 'selected' : ''}}>@lang('member.customer-earnings')</option>
              <option value="spend" {{$search['type'] == 'spend' ? 'selected' : ''}}>@lang('member.consultant-earnings')</option>
            </select>
          </div>
          @endif
          <div class="dropdown-box">
            <label for="date">@lang('member.date'): </label>
            <input type="text" class="form-control date-picker" id="desktop_date" readonly>
          </div>
          <div class="ml-auto">
            <button id="desktop_filter" class="filter_btn">@lang('member.filter')</button>
          </div>
        </div>
      </div>
      <div class="filter-sec">
        <div class="filter-header">
          <p>{{count($transactions)}} @lang('member.results')</p>
          <button id="show_filter" class="filter_btn">@lang('member.filter')</button>
        </div>
        <div class="filter-body">
          <div class="form-group">
            <input type="text" class="form-control search" placeholder="@lang('member.transaction-keyword')"/>
          </div>
          <div class="dropdown-box">
            <label>@lang('member.consultant'):</label>
            <select class="consultant">
              <option selected>@lang('member.all')</option>
              @foreach($consultants as $consultant)
                <option value="{{$consultant->user->id}}" {{$consultant->user->id == $search['consultant'] ? 'selected' : ''}}>
                  {{$consultant->user->first_name}} {{$consultant->user->last_name}}
                </option>
              @endforeach
            </select>
          </div>
          @if(Auth::user()->role == 'consultant')
          <div class="dropdown-box">
            <label>Type:</label>
            <select class="earn_type">
              <option value="All" selected>@lang('member.all')</option>
              <option value="earn" {{$search['type'] == 'earn' ? 'selected' : ''}}>@lang('member.customer-earnings')</option>
              <option value="spend" {{$search['type'] == 'spend' ? 'selected' : ''}}>@lang('member.consultant-earnings')</option>
            </select>
          </div>
          @endif
          <div class="dropdown-box">
            <label>@lang('member.date'):</label>
            <input type="text" class="form-control date-picker" id="mobile_date" readonly>
          </div>
          <button id="mobile_filter" class="filter_btn reversed">@lang('member.filter')</button>
        </div>
      </div>
      <div class="status-section transaction">
        <table class="table table-borderless" id="transactions">
          <thead class="table-header">
            <th>@lang('member.consultant')</th>
            <th>ID nr</th>
            <th>@lang('member.price')</th>
            <th>@lang('member.vat_amount')</th>
            <th>@lang('member.total_amount')</th>
            <th>@lang('member.date-time')</th>
            <th>@lang('member.time-spent')</th>
          </thead>
          <tbody>
            @foreach ($transactions as $transaction)
            <?php
              $fmt = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
              $fmt->setTextAttribute(NumberFormatter::CURRENCY_CODE, 'NOK');
              $fmt->setAttribute( $fmt::FRACTION_DIGITS, 2 );
              $amount = str_replace(',', ' ', $fmt->formatCurrency($transaction->amount, 'NOK'));
              $vat_amount = !empty($transaction->vat_amount) ? str_replace(',', ' ', $fmt->formatCurrency($transaction->vat_amount, 'NOK')) : '0';
              $total_amount = str_replace(',', ' ', $fmt->formatCurrency($transaction->total_amount, 'NOK'));
            ?>
            <tr>
              <td>
                <div class="d-flex align-items-center">
                  <div class="avatar"></div>
                  @if(isset($transaction->consultant))
                  <span>{{$transaction->consultant->user->first_name}} {{$transaction->consultant->user->last_name}}</span>
                  @elseif (isset($transaction->customer))
                  <span>{{$transaction->customer->user->first_name}} {{$transaction->customer->user->last_name}}</span>
                  @endif
                </div>
              </td>
              <td>{{$transaction->transaction_id}}</td>
              <td>{{$amount}}</td>
              <td>{{$vat_amount}}</td>
              <td>{{$total_amount}}</td>
              <td>{{$transaction->created_at}}</td>
              <td>{{$transaction->time_spent}} @lang('member.minute')</td>
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
  const search = @json($search);
  const transactions = @json($transactions);
  const agent = @json($agentType);
  transaction(search, transactions, agent);
</script>
@endsection
