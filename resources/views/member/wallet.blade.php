@extends('layout.member')
@section('title', $title)
@section('description', $description)
@section('content')
<?php
	use Jenssegers\Agent\Agent as Agent;
	$agent = new Agent();
	$count = count($credits); $percent = $agent->isMobile() ? 2 : 4;
	$cards = json_decode($user_info->user->stripe_cards);
	if (isset($cards)) {
		$cardCount = count($cards);
	} else { 
		$cardCount = 0;
	}
?>
<div class="member-wrapper">
	@include('elements.member_sidebar')
	<div class="content-wrapper">
		<div class="single-page">
			<div class="pages-heading">
				<h2>@lang('member.wallet')</h2>
			</div>
			<div class="prepaid-card-full">
				<div class="prepaid-card-left">
					<div class="pay-method">
						<h3>@lang('member.choose_card')</h3>
						@foreach($credits as $key=>$item)
							@if($key == 0)
							<div class="choose-group d-flex">
							@elseif ($key % $percent ==0)
							</div><div class="choose-group d-flex">
							@endif
							@if($key != $count -1)
							<div class="choose-item">
								<div class="{{$key == 0 ? 'credit active': 'credit'}}" id="{{$item['id']}}">
									<?php
										$fmt = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
										if ($currency == 'USD') {
											$fmt->setTextAttribute(NumberFormatter::CURRENCY_CODE, 'USD');
											$fmt->setAttribute( $fmt::FRACTION_DIGITS, 2 );
											$cost = str_replace('$', '', $fmt->formatCurrency($item['amount'], 'USD'));
										} else if ($currency == 'EUR') {
											$fmt->setTextAttribute(NumberFormatter::CURRENCY_CODE, 'EUR');
											$fmt->setAttribute( $fmt::FRACTION_DIGITS, 2 );
											$cost = str_replace('€', '', $fmt->formatCurrency($item['amount'], 'EUR'));
										} else {
											$fmt->setTextAttribute(NumberFormatter::CURRENCY_CODE, 'NOK');
											$fmt->setAttribute( $fmt::FRACTION_DIGITS, 2 );
											$cost = $fmt->formatCurrency($item['amount'], 'NOK');
										}
									?>
									<span class="cost" data-cost="{{$item['amount']}}">@if($currency != 'NOK'){{$currency}}@endif&nbsp;{{$cost}}</span>
								</div>
							</div>
							@else
							<div class="choose-item custom">
								<div class="custom">
									<span class="cost">@lang('member.other')</span>
								</div>
								<div class="credit display-none" id="card8">
									<input type="text" value="" id="custom_card" />
								</div>
							</div>
							@endif
							@if ($key == $count -1)
							</div>
							@endif
						@endforeach

					</div>
					<div class="pay-method">
						<h3>@lang('member.payment_method')</h3>
						<div class="payment-option">
							<div class="flex-row">
								<label class="container">
									<input type="radio" name="card_type" value="stripe" checked/>
									<span class="checkmark"></span>
									<span class="text">Stripe</span>
								</label>
							</div>
							<div class="pay-cust-credit stripe">
								<div id="credit-form">
									@if($cardCount > 0)
									<form action="/charge" method="post" id="payment-form">
										@foreach ($cards as $key => $card)
										<div class="form-row">
											<label>
												<span class="checkbox"><input type="radio" class="payment-source" name="card" value="{{$key}}"></span>
												<div id="saved-card{{$key}}"><span class="hidden">**** **** ****</span> {{$card->last4}}</div>
											</label>
											<div id="card-errors{{$key}}" class="card-message" role="alert"></div>
										</div>
										@endforeach
										<div class="form-row">
											<div class="form-group">
												<span><input type="radio" class="payment-source" name="card" value="new_card" checked></span>
												<div id="card-element"></div>
											</div>
											<div id="card-errors" class="card-message" role="alert"></div>
											<div class="extra-form">
												<div class="check-form mt-3">
													<label class="container">
														@lang('member.save_payment')
														<input type="checkbox" id="save-card-stripe" />
														<span class="checkmark"></span>
													</label>
												</div>
											</div>
										</div>
									</form>
									@else
									<form action="/charge" method="post" id="payment-form">
										<div class="form-row">
											<div id="card-element"></div>
											<div id="card-errors" class="card-message" role="alert"></div>
										</div>
									</form>
									<div class="extra-form p-0">
										<div class="check-form mt-3">
											<label class="container">
												@lang('member.save_payment')
												<input type="checkbox" id="save-card-stripe" />
												<span class="checkmark"></span>
											</label>
										</div>
									</div>
									@endif
								</div>
							</div>
						</div>
						<div class="payment-option-border"></div>
					</div>
					<p>@lang('member.wallet-des1')<br/>
					@lang('member.wallet-des2')</p>
					<div class="pay-method table">
						<div class="filter">
							<h3>@lang('member.payment_transactions')</h3>
							<div class="filter-box desktop">
								<img src="{{asset('images/filter.svg')}}" alt="no-image"/>
							</div>
						</div>
						<div class="filter-tag desktop">
							<div class="form-group">
								<label for="start_date">@lang('member.start_date')</label>
								<input type="text" class="form-control date-picker" id="start_date" name="start_date" readonly>
							</div>
							<div class="form-group">
								<label for="end_date">@lang('member.end_date')</label>
								<input type="text" class="form-control date-picker" id="end_date" name="end_date" readonly>
							</div>
							<div class="form-group">
								<label for="transaction_type">@lang('member.transaction_type')</label>
								<select id="transaction_type" name="transaction_type" class="form-control">
										<option value="Credit">Credit</option>
										<option value="Klarna">Klarna</option>
								</select>
							</div>
							<button id="go-search">@lang('member.filter')</button>
						</div>
						<div class="status-section">
							<table id="transaction-table" class="table table-striped table-bordered transaction" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th>Transaction ID</th>
										<th>Amount</th>
										<th>Date</th>
										<th>Time</th>
										<th>Payment Type</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody>
									@foreach($transactions as $transaction)
									<?php
										$date = explode(" ", $transaction->created_at)[0];
										$time = explode(" ", $transaction->created_at)[1];
										$fmt = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
										if ($transaction->currency == 'USD') {
											$fmt->setTextAttribute(NumberFormatter::CURRENCY_CODE, 'USD');
											$fmt->setAttribute( $fmt::FRACTION_DIGITS, 2 );
											$transaction_amount = str_replace('$', '', $fmt->formatCurrency($transaction->amount, 'USD'));
										} else if ($transaction->currency == 'EUR') {
											$fmt->setTextAttribute(NumberFormatter::CURRENCY_CODE, 'EUR');
											$fmt->setAttribute( $fmt::FRACTION_DIGITS, 2 );
											$transaction_amount = str_replace('€', '', $fmt->formatCurrency($transaction->amount, 'EUR'));
										} else {
											$fmt->setTextAttribute(NumberFormatter::CURRENCY_CODE, 'NOK');
											$fmt->setAttribute( $fmt::FRACTION_DIGITS, 2 );
											$transaction_amount = $fmt->formatCurrency($transaction->amount, 'NOK');
										}
									?>
									<tr>
										<td>{{$transaction->transaction_id}}</td>
										<td>
											@if($transaction->currency != 'NOK'){{$transaction->currency}}@endif&nbsp;{{$transaction_amount}}
										</td>
										<td>{{$date}}</td>
										<td>{{$time}}</td>
										<td>{{$transaction->type}}</td>
										<td>{{$transaction->status == 'successed' ? 'success' : $transaction->status}}</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="mobile-step2">
					<div class="d-flex justify-content-center pb-3">
						<img src="{{asset('images/earnings-icon.svg')}}" alt="no-image"/>
					</div>
					<div class="d-flex align-items-center flex-column">
						<h3>@lang('member.my_balance')</h3>
						<div class="underline-bar"></div>
						<?php
							$fmt = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
							$fmt->setTextAttribute(NumberFormatter::CURRENCY_CODE, 'NOK');
							$fmt->setAttribute( $fmt::FRACTION_DIGITS, 2 );
							$cost = $fmt->formatCurrency($balance, 'NOK');
							$cost_number = str_replace('NOK', '', $cost);
						?>
						<p id="my_balance2"><span class="pr-1">NOK</span>{{$cost_number}}</p>
					</div>
					<button class="btn add-credit-btn">@lang('member.add-credits')</button>
				</div>
				<div class="prepaid-card-right">
					<div class="sticky-sec">
						<div class="current-bal">
							<div class="icon-box pr-2">
								<img src="{{asset('images/earnings-icon.svg')}}" alt="no-image"/>
							</div>
							<div class="balance-status">
								<h3>@lang('member.my_balance')</h3>
								<div class="underline-bar"></div>
								<p id="my_balance"><span class="pr-1">NOK</span>{{$cost_number}}</p>
							</div>
						</div>
						<div class="current-bal credit-box">
							<div class="credit-section">
								<h3>@lang('member.gotoconsult-credit')</h3>
								<div class="underline-bar"></div>
								<span class="selected-credit"></span>
							</div>
							<div class="credit-section-border"></div>
							<div class="credit-section">
								<div class="credit-sub-section">
									<p>@lang('member.subtotal')</p>
									<p class="selected-credit"></p>
								</div>
								<div class="credit-sub-section">
									<p>@lang('member.processing-fee')</p>
									<?php
										if ($currency == 'USD') {
											$fmt->setTextAttribute(NumberFormatter::CURRENCY_CODE, 'USD');
											$fmt->setAttribute( $fmt::FRACTION_DIGITS, 2 );
											$cost_fee = str_replace('$', '', $fmt->formatCurrency(0, 'USD'));
										} else if ($currency == 'EUR') {
											$fmt->setTextAttribute(NumberFormatter::CURRENCY_CODE, 'EUR');
											$fmt->setAttribute( $fmt::FRACTION_DIGITS, 2 );
											$cost_fee = str_replace('€', '', $fmt->formatCurrency(0, 'EUR'));
										} else {
											$fmt->setTextAttribute(NumberFormatter::CURRENCY_CODE, 'NOK');
											$fmt->setAttribute( $fmt::FRACTION_DIGITS, 2 );
											$cost_fee = $fmt->formatCurrency(0, 'NOK');
										}
									?>
									<p>@if($currency != 'NOK'){{$currency}}@endif&nbsp;{{$cost_fee}}</p>
								</div>
							</div>
							<div class="credit-section-border"></div>
							<div class="credit-section">
								<div class="credit-sub-section">
									<p>@lang('member.total')</p>
									<p class="selected-credit"></p>
								</div>
								<button class="btn ac-btn pay-btn sumbit-total"></button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="mobile-wallet-payment">
		<div class="d-flex justify-content-between">
			<p>@lang('member.subtotal')</p>
			<p class="selected-credit"></p>
		</div>
		<div class="d-flex justify-content-between">
			<p class="processing-question">@lang('member.processing-fee')<img src="{{asset('images/question.svg')}}" alt="no-image"/></p>
			<p>{{$currency}} 0.00</p>
		</div>
		<div class="d-flex justify-content-between">
			<p>@lang('member.total')</p>
			<p class="selected-credit"></p>
		</div>
		<button class="btn next-btn has-spinner"></button>
	</div>
	<div class="mobile-wallet-transaction">
		<div class="filter">
			<h3>@lang('member.payment_transactions')</h3>
			<div class="filter-box mobile">
				<img src="{{asset('images/filter.svg')}}" alt="no-image"/>
			</div>
		</div>
		<div class="filter-tag mobile">
			<div class="form-group">
				<label for="mobile_start_date">@lang('member.start_date')</label>
				<input type="text" class="form-control date-picker" id="mobile_start_date" name="mobile_start_date" readonly>
			</div>
			<div class="form-group">
				<label for="mobile_end_date">@lang('member.end_date')</label>
				<input type="text" class="form-control date-picker" id="mobile_end_date" name="mobile_end_date" readonly>
			</div>
			<div class="form-group">
				<label for="mobile_transaction_type">@lang('member.transaction_type')</label>
				<select id="mobile_transaction_type" name="mobile_transaction_type" class="form-control">
					<option disabled selected>@lang('member.all')</option>
					<option value="credit">Credit</option>
					<option value="klarna">Klarna</option>
				</select>
			</div>
			<button id="mobile-go-search">@lang('member.filter')</button>
		</div>
		<div class="mobile-transaction-table"></div>
	</div>
	<div class="modal fade" id="payment-confirmation" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				<div class="step">
					<img src="{{asset('images/earnings-icon.svg')}}" alt="no-image"/>
					<h2>@lang('member.purchase_complete')</h2>
					<p id="pay-modal-amount"></p>
					<div class="btn-group">
						<a class="btn btn-redirect" href="{{ $lang == 'en' ? url('/find-consultant') : url('/no/finn-konsulent') }}">@lang('member.find_consultant')</a>
						<a class="btn btn-close" data-dismiss="modal" aria-label="Close">@lang('member.close')</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script>
	var amount = @json($amount);
	var is_popup = @json($is_popup);
	var currency = @json($currency);  
	var search = @json($search);
	var currency_key = @json( config('app.CURRENCY_LAYER_KEY') );
	var stripe_key = @json( config('app.STRIPE_CLIENT_KEY') ) ;

	wallet(amount, is_popup, currency, search, currency_key, stripe_key);
</script>
@endsection