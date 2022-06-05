@extends('layout.private')
@section('title', 'GoToConsult - Edit Consultant')
@section('content')
<?php $lang = app()->getLocale();?>
<div class="admin-wrapper">
    @include('elements.admin_sidebar')
    <div class="content-wrapper adminprof">
        <div class="single-page">
            <div class="page-heading">
                <a href="{{ $lang == 'en' ? url('/consultants') : url('/no/konsulenter') }}"><img src="{{ asset('images/back-pink.svg')}}" alt="icon"/></a>
                <h2>@lang('admin.edit_consultant')</h2>
            </div>
            <div class="profile-uploader">
                <div class="imageupload log-setting-up">
                    <h2>@lang('admin.profile_image')</h2>
                    <div class="d-flex">
                        <label class="btn btn-file">
                            <div class="avatar"></div>
                            <button class="btn up-img">@lang('member.upload_image')</button>
                            <input type="file" id="upload_file" name="image-file">
                            <input type="hidden" id="avatar">
                        </label>
                        <button class="sp-f save-btn btn ml-3" id="image_save">Save</button>
                    </div>
                </div>
            </div>
            <div class="page-setting">
                <h2>@lang('admin.user_settings')</h2>
                <div class="page-seting-content extend">
                    <div class="group-box">
                        <div class="form-group">
                            <label>@lang('admin.first_name')</label>
                            <input type="text" id="first_name" class="form-control" value="{{$consultant->user->first_name}}">
                        </div>
                        <div class="form-group">
                            <label>@lang('admin.last_name')</label>
                            <input type="text" id="last_name" class="form-control" value="{{$consultant->user->last_name}}">
                        </div>
                    </div>
                    <div class="group-box">
                        <div class="form-group">
                            <label>@lang('admin.email')</label>
                            <input type="text" id="email" class="form-control" value="{{$consultant->user->email}}" readonly>
                        </div>
                        <div class="form-group">
                            <label>@lang('admin.phone')</label>
                            <input type="text" id="phone" class="form-control" value="{{$consultant->user->phone}}">
                        </div>
                    </div>
                    <button class="sp-f cs save-btn btn" id="profile_save">Save</button>
                </div>
            </div>
            <div class="page-setting">
                <h2>@lang('forms.private-information')</h2>
                <div class="page-seting-content extend">
                    <div class="group-box">
                        <div class="form-group">
                            <label>@lang('forms.birthday')</label>
                            <span onclick="$datepicker.open()"><img src="{{ asset('images/calendar.svg') }}" /></span>
                            <input type="text" class="form-control date-picker" id="birthday" name="birthday" readonly>
                        </div>
                        <div class="form-group">
                            <label>@lang('forms.gender')</label>
                            <select id="gender" name="gender" class="form-control">
                                <option value="male" @if($consultant->user->gender == 'male') {{'selected'}}@endif>Male</option>
                                <option value="female" @if($consultant->user->gender == 'female') {{'selected'}}@endif>Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="group-box">
                        <div class="form-group">
                            <label for="timezone">@lang('forms.timezone')</label>
                            <select id="timezone" class="form-control"></select>
                        </div>
                        <div class="form-group">
                            <label for="from">@lang('forms.from')</label>
                            <select class="crs-country form-control mr-0" id="from" data-region-id="hidden-region" data-default-value="{{$consultant->profile->from}}"></select>
                            <select id="hidden-region" hidden></select>
                        </div>
                    </div>
                    <div class="group-box">
                        <div class="form-group">
                            <label for="country">@lang('forms.living-in')</label>
                            <select class="crs-country form-control" id="country" data-region-id="region" data-default-value="{{$consultant->profile->country}}"></select>
                        </div>
                        <div class="form-group">
                            <label for="region">@lang('forms.choose')</label>
                            <select id="region" class="form-control" data-default-value="{{$consultant->profile->region}}"></select>
                        </div>
                    </div>
                    <div class="group-box">
                        <div class="form-group">
                            <label for="street">@lang('forms.street-address')</label>
                            <input type="text" class="form-control" id="street" value="{{$consultant->profile->street}}">
                        </div>
                        <div class="form-group">
                            <label for="zip_code">@lang('forms.zip-code')</label>
                            <input type="text" class="form-control" id="zip_code" value="{{$consultant->profile->zip_code}}">
                        </div>
                    </div>
                    <button class="sp-f cs save-btn btn" id="private_save">Save</button>
                </div>
            </div>
            <div class="page-setting">
                <h2>@lang('forms.company-information')</h2>
                <div class="page-seting-content extend">
                    <div class="group-box">
                        <div class="form-group">
                            <label for="company_name">@lang('forms.company-name')</label>
                            <input type="text" class="form-control" id="company_name" name="company_name" value="{{$consultant->company->company_name}}">
                        </div>
                        <div class="form-group">
                            <label for="org_number">@lang('forms.organization-number')</label>
                            <input type="text" class="form-control" id="org_number" name="organization_number" value="{{$consultant->company->organization_number}}">
                        </div>
                    </div>
                    <div class="group-box">
                        <div class="form-group mr-0">
                            <label for="bank_account">@lang('forms.bank-account')</label>
                            <input type="text" class="form-control" id="bank_account" name="bank_account" value="{{$consultant->company->bank_account}}">
                        </div>
                    </div>
                    <div class="group-box">
                        <div class="form-group">
                            <label for="cfirst_name">@lang('forms.first_name')</label>
                            <input type="text" class="form-control" id="cfirst_name" name="cfirst_name" value="{{$consultant->company->first_name}}">
                        </div>
                        <div class="form-group">
                            <label for="clast_name">@lang('forms.last_name')</label>
                            <input type="text" class="form-control" id="clast_name"  name="clast_name" value="{{$consultant->company->last_name}}">
                        </div>
                    </div>
                    <div class="group-box">
                        <div class="form-group mr-0">
                            <label for="company_address">@lang('forms.company-address')</label>
                            <input type="text" class="form-control" id="company_address" name="company_address" value="{{$consultant->company->address}}">
                        </div>
                    </div>
                    <div class="group-box three">
                        <div class="form-group">
                            <label for="company_from">@lang('forms.company-in')</label>
                            <select class="crs-country form-control" id="company_from" name="company_from" data-region-id="company_region" data-default-value="{{$consultant->company->country}}"></select>
                        </div>
                        <div class="form-group">
                            <label for="company_region">@lang('forms.choose')</label>
                            <select id="company_region" name="company_region" class="form-control" data-default-value="{{$consultant->company->zip_place}}"></select>
                        </div>
                        <div class="form-group">
                            <label for="czip_code">@lang('forms.zip-code')</label>
                            <input type="text" class="form-control" id="czip_code"  name="czip_code" value="{{$consultant->company->zip_code}}">
                        </div>
                    </div>
                    <button class="sp-f cs save-btn btn" id="company_save">Save</button>
                </div>
            </div>
            <div class="page-setting">
                <h5>@lang('forms.consultant-intro')</h5>
                <div class="page-seting-content extend">
                    <div class="group-box">
                        <div class="form-group mr-0">
                            <select id="profession" class="form-control">
                                @foreach($categories as $data)
                                <option value="{{$data->category_name}}" @if($consultant->profile->profession == $data->category_name) {{'selected'}}@endif>{{$data->category_name}}</option>
                                @endforeach 
                            </select>
                        </div>
                    </div>
                    <div class="rate-sec group-box">
                        <div class="form-group">
                            <input type="text" class="form-control" id="rate" placeholder="{{ __('forms.price-per-minute') }}" name="rate" value="{{$consultant->hourly_rate}}">
                        </div>
                        <div class="form-group">
                            <select name="currency" id="currency" class="form-control">
                                <option value="NOK" @if($consultant->currency == "NOK") {{'selected'}}@endif>NOK</option>
                                <option value="EUR" @if($consultant->currency == "EUR") {{'selected'}}@endif>EUR</option>
                                <option value="USD" @if($consultant->currency == "USD") {{'selected'}}@endif>USD</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group textarea">
                        <label for="consultant_introduction">@lang('forms.about-me')</label>
                        <textarea name="consultant_introduction" id="consultant_introduction" class="form-control" rows="5"></textarea>
                    </div>
                    <button class="sp-f cs btn save-btn" id="consultant_pro_save">@lang('admin.save')</button>
                </div>
            </div>
            <div class="page-setting double-multi">
                <h2>@lang('forms.consultant-back')</h2>
                <div class="page-setting double-multi">
                    <div class="page-seting-content">
                        <h2 class="title">@lang('forms.consultant-edu')</h2>
                        <div class="list">
                            @foreach($educations as $education)
                                <div class="item">
                                    <p><span>@lang('forms.from')/@lang('forms.to'):</span> {{$education->from}} - {{$education->to}}</p>
                                    <p><span>@lang('forms.major'):</span> {{$education->degree}} - {{$education->major}}</p>
                                    <p><span>@lang('forms.institution'):</span> {{$education->institution}}</p>
                                    @if ($education->diploma)
                                    <a href="{{$education->diploma}}" download>Download dimploma <img src="{{asset('images/downloading.svg')}}" /></a>
                                    @endif
                                </div>
                                <div class="underline-bar"></div>
                            @endforeach
                        </div>
                    </div>
                    <div class="page-seting-content">
                        <h2 class="title">@lang('forms.consultant-work')</h2>
                        <div class="list">
                            @foreach ($experiences as $experience)
                                <div class="item">
                                    <p><span>@lang('forms.from')/@lang('forms.to'):</span> {{$experience->from}} - {{$experience->to}}</p>
                                    <p><span>@lang('forms.position'):</span> {{$experience->position}}</p>
                                    <p><span>@lang('forms.company'):</span> {{$experience->company}} - {{$experience->country}}, {{$experience->city}}</p>
                                </div>
                                <div class="underline-bar"></div>
                            @endforeach
                        </div>
                    </div>
                    <div class="page-seting-content">
                        <h2 class="title">@lang('forms.consultant-certificates')</h2>
                        <div class="list">
                            @foreach($certificates as $certificate)
                                <div class="item">
                                    <p><span>@lang('forms.date'):</span> {{$certificate->date}}</p>
                                    <p><span>@lang('forms.certificate-name'):</span> {{$certificate->name}}</p>
                                    <p><span>@lang('forms.institution'):</span> {{$certificate->institution}}</p>
                                    @if ($certificate->diploma)
                                    <a href="{{$certificate->diploma}}" download>Download dimploma <img src="{{asset('images/downloading.svg')}}" /></a>
                                    @endif
                                </div>
                                <div class="underline-bar"></div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="profile-uploader">
                <h2>@lang('admin.contact_settings')</h2>
                <div class="profile-sec">
                    <div class="contact-sec">
                        <label class="heading-t">@lang('admin.phone')</label>
                        <label class="switch">
                            <input type="checkbox"  id="phone_checkbox" class="phone_checkbox" value='1' {{ $consultant->phone_contact == 1 ? 'checked' : '' }}>
                            <span class="slider"></span>
                            <span class="uncheck"></span>
                        </label>
                    </div>
                    <div class="contact-sec">
                        <label class="heading-t">@lang('admin.chat')</label>
                        <label class="switch">
                            <input type="checkbox" id="chat_checkbox" class="chat_checkbox" value='1' {{ $consultant->chat_contact == 1 ? 'checked' : '' }}>
                            <span class="slider"></span>
                            <span class="uncheck"></span>
                        </label>
                    </div>
                    <div class="contact-sec">
                        <label class="heading-t">@lang('admin.video')</label>
                        <label class="switch">
                            <input type="checkbox" id="video_checkbox" class="video_checkbox" value='1' {{ $consultant->video_contact == 1 ? 'checked' : '' }}>
                            <span class="slider"></span>
                            <span class="uncheck"></span>
                        </label>
                    </div>
                </div>
                <button class="sp-f cs btn save-btn" id="contact_save">@lang('admin.save')</button>
            </div>
            <div class="page-setting meta-info">
                <h2>@lang('admin.change_password')</h2>
                <div class="page-seting-content">
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
@endsection
@section('scripts')
<script>
	const consultant = @json($consultant);
    editConsultant(consultant);
</script>
@endsection