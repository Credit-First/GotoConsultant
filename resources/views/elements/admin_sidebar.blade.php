<?php $lang = app()->getLocale();?>
<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu admin" data-widget="tree">
            <li class="{{$active =='0'?'active':''}}">
				<a href="{{ $lang == 'en' ? url('/admin-dashboard') : url('/no/admin-dashbord') }}">
					@if($active == '0')
					<img src="{{ asset('images/dashboard-icon-w.svg')}}" alt="Dashboard" />
					@else
					<img src="{{ asset('images/dashboard-icon.svg')}}" alt="Dashboard" />
					@endif
					<span>@lang('member.dashboard')</span>
				</a>
			</li>
            <li class="{{ $active == '1' ? 'active' : '' }}">
                <a href="{{ $lang == 'en' ? url('/customers') : url('/no/kunder') }}">
                    @if($active == '1')
					<img src="{{ asset('images/profile-icon-w.svg')}}" alt="profile" />
					@else
					<img src="{{ asset('images/profile-icon.svg')}}" alt="profile" />
					@endif
                    <span>@lang('admin_sidebar.customers')</span>
                </a>
            </li>
            <li class="{{ $active == '2' ? 'active' : '' }}">
                <a href="{{ $lang == 'en' ? url('/consultants') : url('/no/konsulenter') }}">
                    @if($active == '2')
					<img src="{{ asset('images/star-icon-w.svg')}}" alt="profile" />
					@else
					<img src="{{ asset('images/star-icon.svg')}}" alt="profile" />
					@endif
                    <span>@lang('admin_sidebar.consultants')</span>
                </a>
            </li>
            <li class="{{ $active == '3' ? 'active' : '' }}">
                <a href="{{ $lang == 'en' ? url('/categories') : url('/no/kategorier') }}">
                    @if($active == '3')
					<img src="{{ asset('images/list-icon-w.svg')}}" alt="profile" />
					@else
					<img src="{{ asset('images/list-icon.svg')}}" alt="profile" />
					@endif
                    <span>@lang('admin_sidebar.categories')</span>
                </a>
            </li>
            <li class="{{ $active == '4' ? 'active' : '' }}">
                <a href="{{ $lang == 'en' ? url('/pages') : url('/no/sider') }}">
                    @if($active == '4')
					<img src="{{ asset('images/page-icon-w.svg')}}" alt="profile" />
					@else
					<img src="{{ asset('images/page-icon.svg')}}" alt="profile" />
					@endif
                    <span>@lang('admin_sidebar.pages')</span>
                </a>
            </li>
            <li class="{{$active =='5'?'active':''}}">
				<a href="{{ $lang == 'en' ? url('/admin-transaction') : url('/no/admin-transaksjoner') }}" class="side-link">
					@if($active == '5')
					<img src="{{ asset('images/transaction-icon-w.svg')}}" alt="transaction" />
					@else
					<img src="{{ asset('images/transaction-icon.svg')}}" alt="transaction" />
					@endif
					<span>@lang('admin_sidebar.transactions')</span>
				</a>
			</li>
{{--            <li class="{{$active =='6'?'active':''}}">--}}
{{--				<a href="{{ $lang == 'en' ? url('/admin-payout') : url('/no/admin-payout') }}" class="side-link">--}}
{{--					@if($active == '6')--}}
{{--					<img src="{{ asset('images/transaction-icon-w.svg')}}" alt="Payout" />--}}
{{--					@else--}}
{{--					<img src="{{ asset('images/transaction-icon.svg')}}" alt="payout" />--}}
{{--					@endif--}}
{{--					<span>@lang('admin_sidebar.payout')</span>--}}
{{--				</a>--}}
{{--			</li>--}}
            <li class="{{$active =='7'?'active':''}}">
				<a href="{{ $lang == 'en' ? url('/admin-invoices') : url('/no/admin-invoices') }}" class="side-link">
					@if($active == '7')
					<img src="{{ asset('images/transaction-icon-w.svg')}}" alt="Invoices" />
					@else
					<img src="{{ asset('images/transaction-icon.svg')}}" alt="Invoices" />
					@endif
					<span>@lang('admin_sidebar.invoices')</span>
				</a>
			</li>
            <li class="{{ $active == '8' ? 'active' : '' }}">
                <a href="{{ $lang == 'en' ? url('/settings') : url('/no/innstillinger') }}">
                    @if($active == '8')
					<img src="{{ asset('images/settings-icon-w.svg')}}" alt="settings" />
					@else
					<img src="{{ asset('images/settings-icon.svg')}}" alt="settings" />
					@endif
                    <span>@lang('admin_sidebar.settings')</span>
                </a>
            </li>
        </ul>
    </section>
</aside>
