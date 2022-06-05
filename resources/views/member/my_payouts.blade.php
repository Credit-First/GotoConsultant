@extends('layout.member')
@section('title', $title)
@section('description', $description)
@section('content')
    <?php
    use Jenssegers\Agent\Agent as Agent;
    $agent = new Agent();
    $agentType = ($agent->isTablet() ? 'tablet' : $agent->isMobile()) ? 'mobile' : 'desktop';
    ?>
    <div class="member-wrapper">
        @include('elements.member_sidebar')
        <div class="content-wrapper">



            <form method="POST" action="{{ url('/generate-payment-pdf-by-content') }}" accept-charset="UTF-8"
                  id="form_payment_receipt_to_pdf_content" name="form_payment_receipt_to_pdf_content"
                  enctype="multipart/form-data">
                {!! csrf_field() !!}
                <input type="hidden" id="pdf_content" name="pdf_content" value="">
                <input type="hidden" id="pdf_content_hidden_receipt_number" name="pdf_content_hidden_receipt_number"
                       value="">
                <input type="hidden" id="pdf_content_hidden_invoice_id" name="pdf_content_hidden_invoice_id" value="">
                <input type="hidden" id="pdf_content_hidden_action" name="pdf_content_hidden_action" value="">
                <input type="hidden" id="hidden_receipt_number" name="hidden_receipt_number" value="{{ $receipt_number }}">
                <input type="hidden" id="hidden_invoice_id" name="hidden_invoice_id" value="{{ $invoice_id }}">
            </form>



            <div class="single-page">



                <div class="pages-top-sec"
                     style="min-width: 1100px; background-color: {{ $background_color }} !important; border:0px solid green; display: none; height: 100% !important;padding: 12px;"
                     id="div_payment_receipt_content">

                    <div class="block_vert">
                        <div class="p-0 m-0 block_vert_half_top">
                            <ul class="p-0 m-0 ul_horiz_lis">
                                <li class="p-0 m-0 ul_horiz_lis_left_aligned_half">

                                    <table>
                                        <tr>
                                            <td class="to_from_data_cell"><strong>To:</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="to_from_data_cell">{{ $invoiceCompanyName }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="to_from_data_cell">{{ $invoiceCompanyStreet }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="to_from_data_cell">{{ $invoiceCompanyAddress }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>&nbsp;
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>&nbsp;
                                            </td>
                                        </tr>


                                        <tr>
                                            <td class="to_from_data_cell"><strong>From:</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="to_from_data_cell">
                                                <span id="span_invoice_first_name_last_name">
                                                {{ $invoiceCreator->first_name ?? ''}}
                                                {{ $invoiceCreator->last_name ?? ''}}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="to_from_data_cell">
                                                <span id="span_invoice_creator_profile_street">
                                                {{ $invoiceCreatorProfile->street ?? ''}}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="to_from_data_cell">
                                                <span id="span_invoice_creator_profile_zip_code_region">
                                                {{ $invoiceCreatorProfile->zip_code ?? '' }}
                                                {{ $invoiceCreatorProfile->region ?? '' }}
                                                </span>
                                            </td>
                                        </tr>
                                    </table>

                                </li>
                                <li class="ul_horiz_lis_right_aligned_half">

                                    <table style="width:100%">
                                        <tr>
                                            <td colspan="2">
                                                <h3>{{ $invoiceLogoName }}</h3>
                                            </td>
                                        </tr>

                                            <tr >
                                                <td colspan="2">

                                                    <h3 style="background-color:#00af6c; color:white; display: none" id="h3_invoice_creator_status">
                                                        PAID
                                                    </h3>
                                                </td>
                                            </tr>

                                        <tr>
                                            <td>Bank Account
                                            </td>
                                            <td>
                                                <span id="span_invoice_creator_company_bank_account">
                                                    {{ $invoiceCreatorCompany->bank_account ?? '' }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Amount
                                            </td>
                                            <td>
                                                <span id="span_currency">
                                                    {{ $currency }}
                                                </span>
                                                <span id="span_invoice_total">
                                                    {{ formatMoney($cardInvoice->total ?? 0) }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Date
                                            </td>
                                            <td>
                                                <span id="span_invoice_created_at_formatted">
                                                    {{ $cardInvoice ? $cardInvoice->created_at->format('Y-m-d') : ''}}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Consultant ID
                                            </td>
                                            <td>
                                                <span id="span_invoice_creator_id">
                                                    {{ $cardInvoice->creator_id ?? '' }}
                                                </span>
                                            </td>
                                        </tr>
                                    </table>

                                </li>
                            </ul>

                        </div>
                        <div class="p-0 m-0 block_vert_half_bottom">

                            <table style="width:100%; margin-top:50px;">
                                <tr style="background:white">
                                    <th class="table_header_cell">Description
                                    </th>
                                    <th class="table_header_cell">Amount
                                    </th>
                                    <th class="table_header_cell">MVA
                                    </th>
                                    <th class="table_header_cell">Gtc Fee
                                    </th>
                                    <th class="table_header_cell">Sum
                                    </th>
                                </tr>
                                <tr>
                                    <td class="table_data_cell">#
                                        <span id="span_invoice_id">
                                            {{ $cardInvoice->id ?? ''}}
                                        </span>
                                        GotoConsult Payout
                                    </td>
                                    <td class="table_data_cell">
                                        <span id="span_currency_2">
                                           {{ $currency }}
                                        </span>
                                        <span id="span_invoice_total_minus_vat">
                                           {{ ( formatMoney($cardInvoice->total ?? 0 ) - ( $cardInvoice->vat ?? 0 ) ) }}
                                        </span>
                                    </td>
                                    <td class="table_data_cell">{{ $tax_percent }}%
                                    </td>
                                    <td class="table_data_cell">{{ $settingsFee }}%
                                    </td>
                                    <td class="table_data_cell">
                                        <span id="span_currency_3">
                                            {{ $currency }}
                                        </span>
                                        <span id="span_invoice_total_2">
                                            {{ formatMoney($cardInvoice->total ?? 0) }}
                                        </span>
                                    </td>
                                </tr>

                                {{-- <tr style="width:100%; border:0; border-top: 8px solid #c1c1c1; margin: 0; padding: 0; margin-top: 4px;"> --}}
                                <tr style="  margin-top:38px; margin-bottom:38px;">
                                    <td colspan="3" style="border-top: 2px solid #c1c1c1;">
                                    </td>
                                    <td class="summery_data_cell"
                                        style="padding-top:8px; padding-bottom:8px; border-top: 2px solid #c1c1c1;">
                                        <strong>Sub total</strong>
                                    </td>
                                    <td class="summery_data_cell"
                                        style="padding-top:8px; padding-bottom:8px; border-top: 2px solid #c1c1c1;">

                                        <span id="span_invoice_total_minus_vat_2">
                                            {{ formatMoney( ( $cardInvoice->total ?? 0 ) - ( $cardInvoice->vat ?? 0)) }}
                                        </span>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="3">
                                    </td>
                                    <td class="summery_data_cell">
                                        <strong>MVA ({{ $tax_percent }}%)</strong>
                                    </td>
                                    <td class="summery_data_cell">
                                        <span id="span_invoice_total_mva_tax_percent_sum">
                                            {{ formatMoney(( ( $cardInvoice->total ?? 0 ) / 100) * $tax_percent) }}
                                        </span>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="3">
                                    </td>
                                    <td class="summery_data_cell">
                                        <strong>Gtc fee ({{ $settingsFee }}%)</strong>
                                    </td>
                                    <td class="summery_data_cell">
                                        <span id="span_invoice_total_settings_fee_percent_sum">
                                            {{ formatMoney(( ( $cardInvoice->total ?? 0 ) / 100) * $settingsFee) }}
                                        </span>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="3">
                                    </td>
                                    <td class="summery_data_cell">
                                        <strong>Paid amount</strong>
                                    </td>
                                    <td class="summery_data_cell">
                                        <span id="span_currency_4">
                                            {{ $currency }}
                                        </span>
                                        <span id="span_invoice_total_3">
                                            {{ formatMoney($cardInvoice->total ?? 0) }}
                                        </span>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="3">
                                    </td>
                                    <td class="summery_data_cell">
                                        <strong>Total amount</strong>
                                    </td>
                                    <td class="summery_data_cell">
                                        <span id="span_currency_6">
                                            {{ $currency }}
                                        </span>
                                        <span id="span_invoice_total_4">
                                            {{ formatMoney($cardInvoice->total ?? 0) }}
                                        </span>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="3">
                                    </td>
                                    <td class="summery_data_cell">
                                        <strong>Due amount</strong>
                                    </td>
                                    <td class="summery_data_cell">
                                        <span id="span_currency_5">
                                           {{ $currency }}
                                        </span>
                                        {{ formatMoney(0) }}
                                    </td>
                                </tr>

                            </table>

                        </div>
                    </div>
                </div> <!-- div_payment_receipt_content -->



                <div class="pages-heading">
                    <h2>@lang('member.my-payouts')</h2>
                </div>
                <div class="pages-top-sec my-transaction">
                    <div class="sort-section member">

                        <div class="dropdown-box">
                            <label>Status:</label>
                            <select class="filter_status">
                                <option value="All" selected>@lang('member.all')</option>
                                <option value="P" {{ $search['status'] == 'P' ? 'selected' : '' }}>
                                    @lang('member.paid')
                                </option>
                                <option value="N" {{ $search['status'] == 'N' ? 'selected' : '' }}>
                                    @lang('member.unpaid')
                                </option>
                            </select>
                        </div>

                        <div class="dropdown-box">
                            <label for="desktop_date_from">@lang('member.from-date'): </label>
                            <input type="text" class="form-control date-picker" id="desktop_date_from" readonly>
                        </div>

                        <div class="dropdown-box">
                            <label for="desktop_date_till">@lang('member.till-date'): </label>
                            <input type="text" class="form-control date-picker" id="desktop_date_till" readonly>
                        </div>

                        <div class="ml-auto">
                            <button id="desktop_filter" class="filter_btn">@lang('member.filter')</button>
                        </div>
                    </div>
                </div>
                <div class="filter-sec">
                    <div class="filter-header">
                        <p>{{ count($payouts) }} @lang('member.results')</p>
                        <button id="show_filter" class="filter_btn">@lang('member.filter')</button>
                    </div>
                    <div class="filter-body">

                        <div class="dropdown-box">
                            <label>Status:</label>
                            <select class="status">
                                <option value="All" selected>@lang('member.status')</option>
                                <option value="P" {{ $search['status'] == 'P' ? 'selected' : '' }}>
                                    @lang('member.paid')
                                </option>
                                <option value="N" {{ $search['status'] == 'N' ? 'selected' : '' }}>
                                    @lang('member.unpaid')
                                </option>
                            </select>
                        </div>
                        <div class="dropdown-box">
                            <label>@lang('member.date'):</label>
                            <input type="text" class="form-control date-picker" id="mobile_date" readonly>
                        </div>
                        <button id="mobile_filter" class="filter_btn reversed">@lang('member.filter')</button>
                    </div>
                </div>
                <div class="status-section payout">
                    <table class="table table-borderless" id="payouts">
                        <thead class="table-header">
                        <th>@lang('member.from-date')</th>
                        <th>@lang('member.till-date')</th>
                        <th>@lang('member.invoice')</th>

                        <th>@lang('member.gtc_fee')({{$settingsFee}} %)</th>
                        <th>@lang('member.vat_percentage')</th>
                        <th>@lang('member.vat_amount')</th>
                        <th>@lang('member.status')</th>
                        <th>@lang('member.action')</th>
                        <th>@lang('member.card')</th>
                        </thead>
                        <tbody>

                        @foreach ($payouts as $payout)
                            <tr>
                                <td>{{ $payout['transactionsPeriodTextFromDate'] }}</td>
                                <td>{{ $payout['transactionsPeriodTextTillDate'] }}</td>
                                <td>{{ $payout['invoice_label'] }}</td>
                                <td>{{ $payout['total_amount_total'] / 100 * $settingsFee }} kr</td>
                                <td>{{$tax_percent}} %</td>

                                <td>
                                    kr {{ $payout['total_amount_total'] }}<br>
                                    (Included {{ $payout['vat_amount_total'] }} kr VAT)
                                </td>

                                <td @if($invoice['status'] == 'N') style="color:red" @endif  @if($invoice['status'] == 'P') style="color:green" @endif >
                                    {{ $payout['status_label'] }}
                                </td>
                                <td>
                                    @if ($payout['status'] == 'D')
                                        <button type="button" class="btn btn-success btn-sm text-nowrap"
                                                onclick="javascript:ctreateInvoice('{{ $payout['date_from'] }}', '{{ $payout['date_till'] }}', '{{ $payout['relatedTransactionsIds'] }}', '{{ $payout['amount'] }}', '{{ $payout['vat_amount_total'] }}', '{{ $payout['total_amount_total'] }}' )">
                                            Send
                                            Invoice
                                        </button>
                                    @endif
                                </td>
                                <td></td>
                            </tr>
                        @endforeach


                        @foreach ($invoices_list as $invoice)
                            <tr>
                                <td>{{ $invoice['from_date'] }}</td>
                                <td>{{ $invoice['till_date'] }}</td>
                                <td>FantasyLab AS<br>Invoice # {{ $invoice['id'] }}</td>
                                <td>{{ (float)$invoice['total'] / 100 * (int)$settingsFee }} kr</td>
                                <td>{{ $tax_percent }}%</td>
                                <td>
                                    kr {{ $invoice['total'] }}<br>
                                    (Included {{ $invoice['vat'] }} kr VAT)
                                </td>
                                <td @if($invoice['status'] == 'N') style="color:red" @endif  @if($invoice['status'] == 'P') style="color:green" @endif>
                                    {{ $invoice['status_label'] }}
                                </td>
                                <td>
{{--                                    {{ $invoice['status'] }}:::{{ $invoice['id'] }}--}}
                                    @if ($invoice['status'] == 'D')
                                        <button type="button" class="btn btn-success btn-sm text-nowrap"
                                                onclick="javascript:ctreateInvoice('{{ $invoice['date_from'] }}', '{{ $invoice['date_till'] }}', '{{ $invoice['relatedTransactionsIds'] }}', '{{ $invoice['amount'] }}', '{{ $invoice['vat_amount_total'] }}', '{{ $invoice['total_amount_total'] }}' )">
                                            Send
                                            Invoice
                                        </button>
                                    @endif
                                    @if ($invoice['status'] == 'P')
                                        <button type="button" class="btn btn-secondary btn-sm text-nowrap" >
                                            Invoice sent and payed
                                        </button>
                                    @endif
                                    @if ($invoice['status']=='N' )
                                        <button type="button" class="btn btn-secondary btn-sm text-nowrap" >
                                            Invoice sent
                                        </button>
                                    @endif
                                </td>

                                <td>
{{--                                    onclick="javascript:document.location=' /my-payout-into-pdf/{{ $invoice['id'] }}'"--}}
                                    <button type="button" class="btn btn-primary" onclick="javascript:preparePdfCard( {{ $invoice['id'] }} )" >
                                    <span class="btn-label">
                                        <i class="fa fa-download fa-submit-button" title="Pdf downloading"></i></span>
                                    </button>
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

        function preparePdfCard(invoice_id) {
            console.log('preparePdfCard invoice_id::')
            console.log(invoice_id)

            // if(!confirm('Do you want download invoice in pdf format ?')) return;
            $.ajax({
                type: 'get',
                dataType: 'json',
                url: '/get_invoice_data/' + invoice_id,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    console.log('response::')
                    console.log(response)
                    console.log('response.invoice::')
                    console.log(response.invoice)
                    $("#span_invoice_total").html(response.invoice.total_formatted);
                    $("#span_invoice_total_2").html(response.invoice.total_formatted);
                    $("#span_invoice_total_3").html(response.invoice.total_formatted);
                    $("#span_invoice_total_4").html(response.invoice.total_formatted);
                    $("#span_invoice_total_minus_vat").html(response.invoice.total_minus_vat_formatted);
                    $("#span_invoice_total_minus_vat_2").html(response.invoice.total_minus_vat_formatted);
                    $("#span_invoice_total_mva_tax_percent_sum").html(response.invoice.mva_tax_percent_sum_formatted);
                    $("#span_invoice_total_settings_fee_percent_sum").html(response.invoice.settings_fee_percent_sum_formatted);

                    $("#span_invoice_created_at_formatted").html(response.invoice.invoice_created_at_formatted);
                    $("#span_currency").html(response.currency);
                    $("#span_currency_2").html(response.currency);
                    $("#span_currency_3").html(response.currency);
                    $("#span_currency_4").html(response.currency);
                    $("#span_currency_5").html(response.currency);
                    $("#span_currency_6").html(response.currency);

                    $("#span_invoice_creator_id").html(response.invoice.creator_id);
                    $("#span_invoice_first_name_last_name").html(response.invoice.first_name_last_name);
                    $("#span_invoice_creator_profile_street").html(response.invoice.invoice_creator_profile_street);
                    $("#span_invoice_creator_profile_zip_code_region").html(response.invoice.invoice_creator_profile_zip_code_region);
                    $("#span_invoice_creator_company_bank_account").html(response.invoice.invoice_creator_company_bank_account);
                    $("#span_invoice_id").html(response.invoice.id);

                    // alert( 'response.invoice.invoice_creator_status::' + response.invoice.invoice_creator_status )
                    if( response.invoice.invoice_creator_status=='P' ) {
                        $("#h3_invoice_creator_status").css("display", "block")
                    }
                    // document.location.reload()
                    downloadPdf()
                }
            });

        }
        function downloadPdf() {
            console.log('downloadPdf::')
            // $("#div_payment_receipt_content").css("display", "flex");
            var hidden_receipt_number = $("#hidden_receipt_number").val();
            var hidden_invoice_id = $("#hidden_invoice_id").val();
            // alert( 'hidden_receipt_number::'+hidden_receipt_number+"  hidden_invoice_id::"+hidden_invoice_id )
            var pdf_content = $("#div_payment_receipt_content").html();
            console.log('pdf_content::')
            console.log(pdf_content)

            $("#pdf_content").val(escapeHtml(pdf_content));
            $("#pdf_content_hidden_receipt_number").val(hidden_receipt_number);
            $("#pdf_content_hidden_invoice_id").val(hidden_invoice_id);
            $("#pdf_content_hidden_action").val('upload');
            var theForm = $("#form_payment_receipt_to_pdf_content");
            console.log(theForm)
            theForm.submit();
        } // function downloadPdf() {

        function escapeHtml(text) {
            return text
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }


        function ctreateInvoice(date_from, date_till, relatedTransactionsIds, amount, vat_amount, total_amount) {
            if (!confirm('Do you want to ctreate invoice for selected transactions ?')) return;
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: '/memberCreateInvoice',
                data: {
                    "from_date": date_from,
                    "till_date": date_till,
                    'relatedTransactionsIds': relatedTransactionsIds,
                    "vat": vat_amount,
                    "total": total_amount
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (e) {
                    document.location.reload()
                }
            });
            return false;
        }

        const search = @json($search);
        const payouts = @json($payouts);
        const agent = @json($agentType);
        payout(search, payouts, agent);

    </script>
@endsection

<style>
    .block_vert {
        display: flex;
        flex-direction: column;
        width: 100% !important;
        height: 100% !important;
    }

    .block_vert_half_top {
        display: flex;
        justify-content: flex-start;
        height: 40%;
        width: 100%;
        /* border: 2px dotted blue !important; */
    }

    .block_vert_half_bottom {
        display: flex;
        justify-content: flex-start;
        /* border: 2px dotted green !important; */
        height: 60%;
        width: 100%;
    }

    .ul_horiz_lis {
        display: flex;
        list-style-type: none;
        width: 100%;
        justify-items: flex-start;
        padding: 0;
        margin: 0;
    }

    .ul_horiz_lis_left_aligned_half {
        display: flex;
        margin: 0 10px;
        justify-content: space-between;
        width: 50%;
        flex-wrap: nowrap;
        white-space: nowrap;
    }

    .ul_horiz_lis_right_aligned_half {
        justify-content: flex-start;
        text-align: left;
        width: 50%;
        display: flex;
        margin: 0 10px;
        flex-wrap: nowrap;
        white-space: nowrap;
    }

    .table_data_cell {
        padding: 12px !important;
        margin: 2px !important;
    }

    .to_from_data_cell {
        margin: 1px;
        padding: 2px;
    }

    .summery_data_cell {
        margin: 2px;
        padding: 4px;
    }

    .table_header_cell {
        text-align: left;
        margin: 10px;
        padding: 6px;
        background: white !important;
    }

</style>
