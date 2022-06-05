@extends('layout.member')
@section('title', $title)
@section('description', $description)
@section('content')
<div class="member-wrapper">
  @include('elements.member_sidebar')
  <div class="content-wrapper">
		<div class="single-page">
			<div class="pages-heading">
				<h2>@lang('member.settings')</h2>
			</div>
			<div class="setting-page">
				<div class="profile-uploader">
					<div class="profile-sec contact-sec d-flex flex-column">
						<h3>@lang('member.communication-payment')</h3>
						<div class="setting-content">
							<div class="d-flex flex-column">
								<label class="heading-t">@lang('member.phone')</label>
								<label class="switch">
									<input type="checkbox" id="phone_checkbox" class="phone_checkbox" value='1'
										{{ $user_info->phone_contact == 1 ? 'checked' : '' }}>
									<span class="slider"></span>
									<span class="uncheck"></span>
								</label>
							</div>
							<div class="d-flex flex-column ">
								<label class="heading-t">@lang('member.chat')</label>
								<label class="switch">
									<input type="checkbox" id="chat_checkbox" class="chat_checkbox" value='1'
										{{ $user_info->chat_contact == 1 ? 'checked' : '' }}>
									<span class="slider"></span>
									<span class="uncheck"></span>
								</label>
							</div>
							<div class="d-flex flex-column">
								<label class="heading-t">@lang('member.video')</label>
								<label class="switch">
									<input type="checkbox" id="video_checkbox" class="video_checkbox" value='1'
										{{ $user_info->video_contact == 1 ? 'checked' : '' }}>
									<span class="slider"></span>
									<span class="uncheck"></span>
								</label>
							</div>
						</div>
						@if(auth()->user()->role == 'consultant')
						<div class="select-box">
							<label for="currency">@lang('member.price_minute')</label>
							<input type="text" id="rate" placeholder="Input your hourly rate" value="{{$user_info->hourly_rate}}"/>
						</div>
						@endif
						<div class="select-box">
							<label for="currency">@lang('member.currency')</label>
							<select id="selected-currency" name="currency">
								<option disabled selected>Select the currency</option>
								<option value="NOK">NOK kr</option>
								<option value="USD">USD $</option>
								<option value="EUR">EUR €</option>
							</select>
						</div>
						<button class="sp-f cs btn save-btn" id="profile_save">@lang('member.save')</button>
					</div>
				</div>
				@if(auth()->user()->role == 'consultant')
				<div class="profile-uploader">
					<div class="profile-sec contact-sec d-flex flex-column">
						<div class="select-box">
							<label for="education">@lang('member.education')</label>
							<select id="selected-education" name="education">
								<option disabled selected>@lang('member.select-education')</option>
								@foreach($education as $sel)
									@if ($sel->institution == $user_info->profile->college)
									<option value="{{$sel->institution}}" selected>{{$sel->institution}}</option>
									@else
									<option value="{{$sel->institution}}">{{$sel->institution}}</option>
									@endif
								@endforeach
							</select>
						</div>
					</div>
					<button class="sp-f cs btn save-btn" id="education_save">@lang('member.save')</button>
				</div>
				@endif
				<div class="profile-uploader">
					<div class="profile-sec contact-sec d-flex flex-column">
						<h3 for="currency">@lang('member.saved_payment_method')</h3>
						@if($user_info->user->payment_method)
							@if($user_info->user->payment_method == 'stripe')
								<?php
									$cards = json_decode($user_info->user->stripe_cards);
									if (isset($cards)) {
										$cardCount = count($cards);
									} else {
										$cardCount = 0;
									}
								?>
								<label>@lang('member.stripe-setting')</label>
								@foreach ($cards as $key => $card)
									<div class="form-row pl-2">
										<label>
											<div class="saved-card"><span class="hidden">**** **** ****</span> {{$card->last4}}</div>
										</label>
									</div>
								@endforeach
							@else
							<label>@lang('member.klarna-setting')</label>
							@endif
						@else
						<p>@lang('member.no_saved_payment_method_des')</p>
						@endif
					</div>
				</div>
				@if(auth()->user()->role == 'consultant')
				<div class="profile-uploader">
					<div class="profile-sec contact-sec d-flex flex-column">
						<h3>@lang('member.company_information')</h3>
						<form class="d-flex flex-column">
							<div class="form-group">
								<label>@lang('member.company_name')</label>
								<input type="text" name="company_name" id="company_name" value="{{$user_info->company ? $user_info->company->company_name : ''}}" required>
							</div>
							<div class="form-group">
								<label>@lang('member.organization_number')</label>
								<input type="text" name="organization_number" id="organization_number" value="{{$user_info->company ? $user_info->company->organization_number : ''}}" required>
							</div>
							<div class="form-group">
								<label>@lang('member.bank_account')</label>
								<input type="text" name="bank_account" id="bank_account" value="{{$user_info->company ? $user_info->company->bank_account : ''}}" required>
							</div>
							<div class="form-group">
								<label>@lang('member.first_name')</label>
								<input type="text" name="first_name" id="first_name" value="{{$user_info->company ? $user_info->company->first_name : ''}}" required>
							</div>
							<div class="form-group">
								<label>@lang('member.last_name')</label>
								<input type="text" name="last_name" id="last_name" value="{{$user_info->company ? $user_info->company->last_name : ''}}" required>
							</div>
							<div class="form-group">
								<label>@lang('member.address')</label>
								<input type="text" name="address" id="address" value="{{$user_info->company ? $user_info->company->address : ''}}" required>
							</div>
							<div class="form-group">
								<label>@lang('member.zip_code')</label>
								<input type="text" name="zip_code" id="zip_code" value="{{$user_info->company ? $user_info->company->zip_code : ''}}" required>
							</div>
							<div class="form-group">
								<label>@lang('member.zip_place')</label>
								<input type="text" name="zip_place" id="zip_place" value="{{$user_info->company ? $user_info->company->zip_place : ''}}" required>
							</div>
							<div class="form-group">
								<label>@lang('member.country')</label>
								<input type="text" name="country" id="country" value="{{$user_info->company ? $user_info->company->country : ''}}" required>
							</div>
							<button class="sp-f cs btn save-btn" id="company_save" type="submit">@lang('member.save')</button>
						</form>
					</div>
				</div>
				@endif
				<div class="profile-uploader">
					<div class="profile-sec contact-sec d-flex flex-column">
						<h3>@lang('member.password_settings')</h3>
						<div class="page-seting-content d-flex flex-column">
							<label>@lang('member.old_password')</label>
							<input type="password" id="old_password">
							<div class="alert" id="old_password_error"></div>
							<label>@lang('member.new_password')</label>
							<input type="password" id="new_password">
							<button class="sp-f cs save-btn btn" id="password_save">@lang('member.save')</button>
						</div>
					</div>
				</div>
			</div>
		</div>
  </div>
</div>
@endsection
@section('scripts')
<script>
	var user_info = @json($user_info);
	setting(user_info);
</script>
@endsection
