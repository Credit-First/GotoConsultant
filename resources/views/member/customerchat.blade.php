@extends('layout.member')
@section('title', $title)
@section('description', $description)
@section('content')
<?php $lang = json_encode(["data" => app()->getLocale()]); ?>
<div class="member-wrapper" id="member-content" style="height: calc(100vh - 65px) !important;">
    @include('elements.member_sidebar')
    <div class="content-wrapper chat">
        <div id="chat-component">
            <customer-component
                :consultants="{{ $consultants }}"
                :customers="{{ $customers }}"
                :vat-Percent="{{ $vatPercent }}"
                :contacted-consultants="{{ json_encode($contactedConsultants) }}"
                :auth-user="{{ $authCustomer }}"
                :selected-id="{{ $single }}"
                :access-key="{{ json_encode(['key' => config('app.CURRENCY_LAYER_KEY')]) }}"
                :find-route="{{ json_encode(['route' => route('find-consultant')]) }}"
                :lang="{{ $lang }}"
            >
            </customer-component>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="https://media.twiliocdn.com/sdk/js/chat/v3.3/twilio-chat.min.js"></script>
<script src="{{ asset('js/app.js')}}"></script>
@endsection
