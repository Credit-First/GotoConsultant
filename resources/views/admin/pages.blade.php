@extends('layout.private')
@section('title', 'GoToConsult - Pages')
@section('content')
<?php $lang = app()->getLocale();?>
<div class="admin-wrapper">
    @include('elements.admin_sidebar')
    <div class="content-wrapper adminprof">
	    <div class="single-page">
            <div class="pages-heading">
                <h2 class="mr-auto mt-auto mb-auto">@lang('admin.pages')</h2>
                <a href="{{ $lang == 'en' ? url('/create-page') : url('/no/opprett-side') }}"><button class="btn save-btn">@lang('admin.create_page')</button></a>
            </div>
			<div class="admin-table status-section admin-page">
				<table class="table table-borderless responsive" id="example">
                    <thead>
                        <tr class="top">
                            <th>@lang('admin.page_name')</th>
                            <th>@lang('admin.status')</th>
                            <th>@lang('admin.action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pages as $key => $data)
                        <tr>
                            <td>
                                <p data-id="{{$data->id}}"></p>
                                {{$data->page_name}}
                            </td>
                            <td>
                                <p data-id="{{$data->id}}"></p>
                                <small>@lang('admin.published')</small>
                            </td>
                            <td>
                                <a href="{{ url('/edit-page', $data->id) }}">@lang('admin.edit_page')</a>
                            </td>
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
    page();
</script>
@endsection
