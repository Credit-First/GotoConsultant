@extends('layout.private')
@section('title', $title)
@section('description', $description)
@section('content')
    <div class="member-wrapper">
        @include('elements.admin_sidebar')
        <div class="content-wrapper adminprof">
            <div class="single-page">
                <div class="pages-heading">
                    <h2>@lang('admin_sidebar.payouts')</h2>
                </div>

                <div class="pages-top-sec"> <!-- Filters Block Start -->
                    <div class="sort-section">

                        <div class="dropdown-box">
                            <label for="consultant">@lang('member.consultant'): </label>
                            <select id="consultant" name="consultant" class="consultant form-control">
                                <option value="All" {{$search['consultant'] == 'All' ? 'selected' : ''}}>@lang('member.all')</option>
                                @foreach($consultants as $consultant)
                                    <option value="{{$consultant->id}}" {{$consultant->id == $search['consultant'] ? 'selected' : ''}}>
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
                    {{-- <div>
                        Vat amount summery : <strong>{{$summery_vat_amount_total}}</strong> kr
                    </div>

                    <div>
                        Total amount summery : <strong>{{$summery_total_amount_total}}</strong> kr
                    </div> --}}

                    <table class="table table-borderless responsive" id="payout">
                        <thead class="table-header">
                        <th>@lang('admin.consultant_name')</th>
                        <th>@lang('admin.payout_id')</th>
                        <th>@lang('admin.amount_excl_vat')</th>
                        <th>@lang('member.vat_amount')</th>
                        <th>@lang('admin.vat_percentage')</th>

                        <th>@lang('admin.subtotal_incl_vat')</th>
                        <th>@lang('admin.gtc_fee_incl_vat')({{$settingsFee}} %)</th>
                        <th>@lang('admin.total_incl_vat')</th>

                        <th>@lang('admin.period')</th>
{{--                        <th>@lang('admin.status')</th>--}}
                        </thead>
                        <tbody>

                        @foreach ($payouts as $payout)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar"></div>
                                        <span>{{$payout['receiver_name']}}</span>
                                    </div>
                                </td>
                                <td>
                                    {{ $payout['consultantTransactionsIdText']}}
                                </td>
                                <td>{{$payout['amount_total']}} kr</td>
                                <td>{{$payout['vat_amount_total']}} kr</td>
                                <td>{{$tax_percent}} %</td>
                                <td>{{$payout['total_amount_total']}} kr</td>
                                <td>{{ $payout['total_amount_total'] / 100 * $settingsFee}} kr</td>

                                <td>{{$payout['total_amount_total'] - ( $payout['total_amount_total'] / 100 * $settingsFee ) }} kr</td>

                                <td>{{$payout['consultantTransactionsPeriodText']}}</td>
{{--                                <td>--}}
{{--                                    @if($payout['status'])--}}
{{--                                        <span class="p-2 m-2" style="background-color: grey" role="alert">Payed--}}
{{--                      </span>--}}
{{--                                    @else--}}
{{--                                        <button type="button" class="btn btn-success btn-sm text-nowrap" onclick="javascript:setAdminSetTransactionStatusPayed('{{$payout['id']}}')">Pay</button>--}}
{{--                                    @endif--}}
{{--                                </td>--}}
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
        function setAdminSetTransactionStatusPayed(id) {
            if(!confirm('Do you want to set paid status to selected payout ?')) return;
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: '/adminSetTransactionStatusPayed',
                data: {"id": id},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (e) {
                    document.location.reload()
                }
            });
            return false;
        }
        const data = @json($payouts);
        const search = @json($search);
        payouts(data, search);

        $(".dataTables_filter > label").css("display", "none")

    </script>
@endsection
