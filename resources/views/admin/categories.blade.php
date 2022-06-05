@extends('layout.private')
@section('title', 'GoToConsult - Categories')
@section('content')
<div class="admin-wrapper">
    @include('elements.admin_sidebar')
    <div class="content-wrapper adminprof">
        <div class="single-page">
            <div class="pages-heading category-heading">
                <h2 class="mr-auto mt-auto mb-auto">@lang('admin.categories')</h2>
                <a href="{{ $lang == 'en' ? url('/create-category') : url('/no/opprett-kategori') }}"><button class="btn save-btn">@lang('admin.create_category')</button></a>
            </div>
            <div class="admin-table status-section consult-table cust-table table-responsive">
                <table class="table table-borderless responsive" id="example">
                    <thead>
                        <tr class="top">
                            <th>@lang('admin.category')</th>
                            <th>@lang('admin.description')</th>
                            <th>@lang('admin.category_vat')</th>
                            <th>@lang('admin.slug')</th>
                            <th>@lang('admin.action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $key => $data)
                            <tr>
                                <td>
                                    <p data-id="{{$data->id}}"></p>
                                    @if($lang == 'en')
                                        {{$data->category_name}}
                                    @else
                                        {{$data->category_name_no}}
                                    @endif
                                </td>
                                <td>{{$data->category_description}}</td>
                                <td>{{$data->vat}}</td>
                                <td>{{$data->category_url}}</td>
                                <td><a style="display:block;line-height:22px;" href="{{ $lang == 'en' ? url('/edit-category/'.$data->id) : url('/no/rediger-kategori/'.$data->id) }}">@lang('admin.details') </a></td>
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
    categories();
</script>
@endsection
