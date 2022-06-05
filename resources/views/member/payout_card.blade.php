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

                <div class="pages-heading">
                    <h2>@lang('member.my-payouts')</h2>
                </div>
                <div class="pb-3">
                    <a href="/my-payouts"><small>Return to my payouts</small></a>
                </div>
                <div class="pages-subheading">
                    <ul class="p-0 m-0 ul_horiz_lis">
                        <li class="p-0 m-0 ul_horiz_lis_left_aligned_half">
                            <button type="button" class="btn btn-success btn-sm text-nowrap"
                                onclick="javascript:downloadPdf()">Download Pdf</button>
                        </li>
                        {{-- <li class="ul_horiz_lis_right_aligned_half">
                            <button type="button" class="btn btn-success btn-sm text-nowrap"
                                onclick="javascript:sendPdfToCreator()">Send Pdf to consultant</button>
                        </li> --}}
                    </ul>
                </div>


                <div class="pages-top-sec"
                    style="min-width: 1100px; background-color: {{ $background_color }} !important; border:0px solid green; display: noneWWW; height: 100% !important;padding: 12px;"
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
                                                {{ $invoiceCreator->first_name }}
                                                {{ $invoiceCreator->last_name }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="to_from_data_cell">
                                                {{ $invoiceCreatorProfile->street }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="to_from_data_cell">{{ $invoiceCreatorProfile->zip_code }}
                                                {{ $invoiceCreatorProfile->region }}
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

                                        @if( $invoiceCreator->status=='P' )
                                        <tr>
                                            <td colspan="2">
                                                <h3 style="background-color:#00af6c; color:white">PAID</h3>
                                            </td>
                                        </tr>
                                        @endif

                                        <tr>
                                            <td>Bank Account
                                            </td>
                                            <td>{{ $invoiceCreatorCompany->bank_account }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Amount
                                            </td>
                                            <td>{{ $currency }} {{ formatMoney($cardInvoice->total) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Date
                                            </td>
                                            <td>{{ $cardInvoice->created_at->format('Y-m-d') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Consultant ID
                                            </td>
                                            <td>{{ $cardInvoice->creator_id }}
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
                                    <td class="table_data_cell">#{{ $cardInvoice->id }} GotoConsult Payout
                                    </td>
                                    <td class="table_data_cell">{{ $currency }}
                                        {{ formatMoney($cardInvoice->total - $cardInvoice->vat) }}
                                    </td>
                                    <td class="table_data_cell">{{ $tax_percent }}%
                                    </td>
                                    <td class="table_data_cell">{{ $settingsFee }}%
                                    </td>
                                    <td class="table_data_cell">{{ $currency }}
                                        {{ formatMoney($cardInvoice->total) }}
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
                                        {{ formatMoney($cardInvoice->total - $cardInvoice->vat) }}
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="3">
                                    </td>
                                    <td class="summery_data_cell">
                                        <strong>MVA ({{ $tax_percent }}%)</strong>
                                    </td>
                                    <td class="summery_data_cell">
                                        {{ formatMoney(($cardInvoice->total / 100) * $tax_percent) }}
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="3">
                                    </td>
                                    <td class="summery_data_cell">
                                        <strong>Gtc fee ({{ $settingsFee }}%)</strong>
                                    </td>
                                    <td class="summery_data_cell">
                                        {{ formatMoney(($cardInvoice->total / 100) * $settingsFee) }}
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="3">
                                    </td>
                                    <td class="summery_data_cell">
                                        <strong>Paid amount</strong>
                                    </td>
                                    <td class="summery_data_cell">
                                        {{ $currency }} {{ formatMoney($cardInvoice->total) }}
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="3">
                                    </td>
                                    <td class="summery_data_cell">
                                        <strong>Total amount</strong>
                                    </td>
                                    <td class="summery_data_cell">
                                        {{ $currency }} {{ formatMoney($cardInvoice->total) }}
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="3">
                                    </td>
                                    <td class="summery_data_cell">
                                        <strong>Due amount</strong>
                                    </td>
                                    <td class="summery_data_cell">
                                        {{ $currency }} {{ formatMoney(0) }}
                                    </td>
                                </tr>

                            </table>

                        </div>
                    </div>
                </div> <!-- div_payment_receipt_content -->

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        jQuery(document).ready(function ($) {
            // alert('INITED')
            downloadPdf()
        });

        function downloadPdf() {
            console.log('downloadPdf::')
            $("#div_payment_receipt_content").css("display", "flex");
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

        function sendPdfToCreator() {
            if(!confirm('Do you want to send this invoice its consultant ?')) return;
            console.log('sendPdfToCreator::')
            $("#div_payment_receipt_content").css("display", "flex");
            var hidden_receipt_number = $("#hidden_receipt_number").val();
            var hidden_invoice_id = $("#hidden_invoice_id").val();
            // alert( 'hidden_receipt_number::'+hidden_receipt_number+"  hidden_invoice_id::"+hidden_invoice_id )
            var pdf_content = $("#div_payment_receipt_content").html();
            console.log('pdf_content::')
            console.log(pdf_content)

            $("#pdf_content").val(escapeHtml(pdf_content));
            $("#pdf_content_hidden_receipt_number").val(hidden_receipt_number);
            $("#pdf_content_hidden_invoice_id").val(hidden_invoice_id);
            $("#pdf_content_hidden_action").val('send_by_email');
            var theForm = $("#form_payment_receipt_to_pdf_content");
            console.log(theForm)
            theForm.submit();

        } // sendPdfToCreator

        //   const search = @json($search);
        //   const payouts = @json($payouts);
        //   const agent = @json($agentType);
        //   payout(search, payouts, agent);
        function escapeHtml(text) {
            return text
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }

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
