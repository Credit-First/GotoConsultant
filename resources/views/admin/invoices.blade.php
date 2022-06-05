@extends('layout.private')
@section('title', $title)
@section('description', $description)
@section('content')
    <div class="member-wrapper">
        @include('elements.admin_sidebar')
        <div class="content-wrapper adminprof">
            <div class="single-page">
                <div class="pages-heading">
                    <h2>@lang('admin_sidebar.invoices')</h2>
                </div>

                <div class="pages-top-sec"> <!-- Filters Block Start -->
                    <div class="sort-section">

                        <div class="dropdown-box">
                            <label for="consultant">@lang('member.consultant'): </label>
                            <select id="consultant" name="consultant" class="consultant form-control">
                                <option value="All" {{$search['consultant'] == 'All' ? 'selected' : ''}}>@lang('member.all')</option>
                                @foreach($consultants as $consultant)
                                    <option value="{{$consultant->user_id}}" {{$consultant->user_id == $search['consultant'] ? 'selected' : ''}}>
                                        {{$consultant->user->first_name}} {{$consultant->user->last_name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="dropdown-box">
                            <label for="desktop_date_from">@lang('admin.date_from'): </label>
                            <input type="text" class="form-control date-picker" id="desktop_date_from" readonly>
                        </div>

                        <div class="dropdown-box">
                            <label for="desktop_date_till">@lang('admin.date_till'): </label>
                            <input type="text" class="form-control date-picker" id="desktop_date_till" readonly>
                        </div>

                        <div class="ml-auto">
                            <button id="desktop_filter" class="filter_btn">@lang('member.filter')</button>
                        </div>

                    </div>
                </div> <!-- Filters Block End -->

                <div class="status-section admin-page">

                    <table class="table table-borderless responsive" id="invoices">
                        <thead class="table-header">
                        <th>@lang('admin.invoice_creator_name')</th>

						<th>@lang('admin.from_date')</th>
						<th>@lang('admin.till_date')</th>

                        <th>@lang('admin.invoice')</th>
                        <th>@lang('admin.gtc_fee') ({{$settingsFee}} %)</th>

                        <th>@lang('admin.vat_percentage')</th>
                        <th>@lang('admin.amount')</th>
                        <th>@lang('admin.status')</th>
                        <th>@lang('member.action')</th>

                        </thead>
                        <tbody>

                        @foreach ($invoices as $invoice)
                            <tr>
                                <td>
                                    {{$invoice['creator_name']}}
                                </td>
                                <td>{{ $invoice['from_date']}}</td>
                                <td>{{ $invoice['till_date']}}</td>

                                <td>FantasyLab AS<br>Invoice # {{ $invoice['id'] }}</td>

                                <td>
                                    {{ $invoice['total'] / 100 * $settingsFee }} kr
                                </td>

                                <td>{{ $tax_percent }} %</td>
                                <td>
                                    kr {{ $invoice['total']}}<br>
                                    (Included {{ $invoice['vat'] }} kr VAT)
                                </td>
                                <td @if($invoice['status'] == 'N') style="color:red" @endif >
                                    {{ $invoice['status_label']}}
                                </td>

                                <td>
                                    @if ($invoice['status'] == 'N')
                                        <button type="button" class="btn btn-success btn-sm text-nowrap"
                                            onclick="javascript:payInvoice({{ $invoice['id'] }}, '{{ $invoice['creator_name'] }}')">To Pay
                                        </button>
                                    @endif
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
<link rel="stylesheet" href="{{ asset('css/MonthPicker.min.css') }}">
@section('scripts')
    <script src="{{ asset('js/MonthPicker.min.js') }}"></script>
    <script>
        function payInvoice(invoice_id, consultant_name) {
            {{--  alert('Pay Invoice is not implemented yet!')  --}}
            console.log('payInvoice invoice_id:: ')
            console.log(invoice_id)
            if(!confirm('Do you want to pay to "'+consultant_name+'" consultant ?')) return;
            window.document.location='{{url('')}}/admin-pay-consultant-invoice/'+invoice_id
        }
        const data = @json($invoices);
        const search = @json($search);
        invoices(data, search);

        $(".dataTables_filter > label").css("display", "none")

    </script>
@endsection
