@extends('layout.private')
@section('title', 'GoToConsult - Customers')
@section('content')
<?php $lang = app()->getLocale();?>
<div class="admin-wrapper">
    @include('elements.admin_sidebar')
    <div class="content-wrapper adminprof">
        <div class="single-page">
            <div class="pages-heading category-heading">
                <h2 class="mr-auto mt-auto mb-auto">@lang('admin.customers')</h2>
                <a href="{{ $lang == 'en' ? url('/create-customer') : url('/no/opprett-kunde') }}"><button class="btn save-btn">@lang('admin.create_customer')</button></a>
            </div>
            <div class="admin-table status-section consult-table cust-table table-responsive">
                <table class="table table-borderless responsive" id="example">
                    <thead>
                        <tr class="top">
                            <th>@lang('admin.customer')</th>
                            <th>@lang('admin.reg_date')</th>
                            <th>@lang('admin.active')</th>
                            <th>@lang('admin.action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customers as $key => $data)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar"></div>
                                    <span>{{$data->user->first_name}} {{$data->user->last_name}}</span>
                                </div>
                            </td>
                            <td>
                                <p class="hidden_id" data-id="{{$data->user->id}}"></p>
                                {{$data->created_at->format('d.m.Y')}}
                            </td>
                            @if($data->user->active)
                            <td>@lang('admin.activated')</td>
                            @else
                            <td>@lang('admin.deactivated')</td>
                            @endif
                            <td><a style="display:block;line-height:22px;" href="{{ $lang == 'en' ? url('/edit-customer/'.$data->user_id) : url('/no/rediger-kunde/'.$data->user_id) }}" class="">@lang('admin.details') </a></td>
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
    const data = @json($customers);
    customers(data);
</script>
@endsection
