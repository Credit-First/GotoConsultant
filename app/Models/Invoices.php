<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Spatie\Browsershot\Browsershot as SpatieBrowsershot;
use Session;

class Invoices extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'invoices';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var array
     */
    protected $fillable = [
      'invoice_id', 'creator_id', 'from_date', 'till_date', 'status', 'gtc_fee', 'vat', 'total', 'ref_transactions'
	 ];

    private static $statusLabelValueArray = ['N' => 'Not paid', 'P' => 'Paid'];

    public static function getStatusLabelValueArray($key_return = true): array
    {
        if(!$key_return) {
            return self::$statusLabelValueArray;
        }
        $resArray = [];
        foreach (self::$statusLabelValueArray as $key => $value) {
            if ($key_return) {
                $resArray[] = ['key' => $key, 'label' => $value];
            }
        }
        return $resArray;
    }
    public static function getStatusLabel(string $status): string
    {
        if ( ! empty(self::$statusLabelValueArray[$status])) {
            return self::$statusLabelValueArray[$status];
        }
        return self::$statusLabelValueArray[0];
    }


    public function scopeGetByStatus($query, $status = null)
    {
        if (empty($status) or $status == 'All') {
            return $query;
        }
        return $query->where(with(new Invoices)->getTable().'.status', $status);
    }

    public function scopeGetByCreatorId($query, $creator_id = null)
    {
        if (empty($creator_id) or $creator_id == 'All') {
            return $query;
        }
        return $query->where(with(new Invoices)->getTable().'.creator_id', $creator_id);
    }

    public function creator() {
        return $this->belongsTo('App\User', 'creator_id');
    }

    public static function generatePaymentReceiptPdfByContent(
        $invoice_id,
        $viewParamsArray,
        $requestData,
        $generated_file_action
    ) {

        $payment      = Invoices::find($invoice_id);
        $pdf_content  = ! empty($requestData['pdf_content']) ? $requestData['pdf_content'] : '';
        $lease_number = ! empty($requestData['pdf_content_hidden_receipt_number']) ? $requestData['pdf_content_hidden_receipt_number'] : '';

        \Log::info('-0 generatePaymentReceiptPdfByContent $invoice_id ::' . print_r($invoice_id, true));
        \Log::info('-1generatePaymentReceiptPdfByContent $generated_file_action ::' . print_r($generated_file_action, true));

        $today_date = getCFFormattedDate(Carbon::now(config('app.timezone')), 'mysql', 'pdf_format');

        $option_output_filename = 'payment_receipt_' . $lease_number;

        $a                      = pregSplit('/\./', $option_output_filename);
        if (count($a) == 2) {
            $option_output_filename = $a[0];
        }

        $filename_to_save = $option_output_filename . '.pdf';

        $save_to_file       = public_path() . '/upload/pdf_tmp/' . Session::getId() . '_' . $filename_to_save;
        $save_to_clear_file = public_path() . '/upload/pdf_tmp/' . $filename_to_save;

            \Log::info('-23 $save_to_file ::' . print_r($save_to_file, true));
            \Log::info('-24 $save_to_clear_file ::' . print_r($save_to_clear_file, true));


        $company_name               = \Config::get('app.invoiceCompanyName');
        $companySupportEmail        = \Config::get('app.companySupportEmail');
        $companyUrl                 = \Config::get('app.companyUrl');

        $footerHtml = '<div class="card-text" style="background-color: #ffffff !important; width: 100%; margin-left: 30px;margin-right: 30px;">
            <table style="width: 100%; font-family: \'times\'; font-size: 12px !important;
                color:#101010 !important; ;" class="mb-3 mt-3">

                <tbody>';
        $footerHtml .= '
                <tr>
                    <td style="width:100%; border:0; border-top: 0px solid #c1c1c1; margin: 0; padding: 0; margin-top: 4px;" colspan="3">
                        <table style="width:100%;  ">
                            <tr>
                                <td style="width:40%; {{ $content_font_name }}; font-size: 11px !important;
                                    color:{{ $content_font_color }};" >
                                    ' . $company_name . ' Registered company : MVA 921 757 468 NO. | Email:'.$companySupportEmail.' | URL: '.$companyUrl.'
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
';


        $footerHtml .= '            </tbody></table>
        </div>';

        createDir([public_path() . '/upload', public_path() . '/upload/pdf_tmp']);
        SpatieBrowsershot::html(htmlspecialchars_decode($pdf_content))
            ->showBrowserHeaderAndFooter()
            // ->headerHtml('<div style="height:240px !important;"><h3>Receipt Voucher</h3></div>')
            ->footerHtml($footerHtml)
            ->showBackground()
            ->margins(20, 10, 20, 10)
                   ->setOption('addStyleTag', json_encode([
                           'content' => '



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
                            padding:12px  !important;
                            margin:2px !important;
                        }
                        .to_from_data_cell {
                            margin:1px;
                            padding:2px;
                        }
                        .summery_data_cell {
                            margin:2px;
                            padding:4px;
                        }
                        .table_header_cell {
                            text-align: left;
                            margin:10px;
                            padding:6px;
                            background:white !important;
                        }



 '
                       ])
                   )
                   ->save($save_to_file);

        if ($generated_file_action == 'send_by_email') {

            if ($requestData['pdf_content_hidden_action'] == 'send_by_email') {
                $cardInvoice = Invoices::find($invoice_id);
                $invoiceCreator = $cardInvoice->creator;
                $invoiceCreatorEmail= $invoiceCreator->email;

                if (empty($$invoiceCreatorEmail)) {
                    return false;
                }
                $client_full_name = $client->full_name;
                    \Log::info('-1 $client_full_name ::' . print_r($client_full_name, true));
                    \Log::info('-2 $invoiceCreatorEmail ::' . print_r($invoiceCreatorEmail, true));
                    \Log::info('-3 with(new Payment)->isDeveloperComp() ::' . print_r(with(new Payment)->isDeveloperComp(),
                            true));

//                    $client_full_name = 'clientname';
                    $invoiceCreatorEmail = 'nilovsergey@yahoo.com';

                    $cc = [];

                    \Log::info('-243 $cc ::' . print_r($cc, true));
                    \Log::info('-111 $client_full_name ::' . print_r($client_full_name, true));
                    \Log::info('-222 $invoiceCreatorEmail ::' . print_r($invoiceCreatorEmail, true));

                $site_name         = config('app.name', '');
                $support_signature = config('app.support_signature', '');

                $additiveVars      = array(
                    'client_full_name'  => $client_full_name,
                    'email'             => $invoiceCreatorEmail,
                    'receipt_number'    => $payment->receipt_number,
                    'invoice_id'        => $invoice_id,
                    'company_name'      => \Config::get('app.company_name'),
                    'support_signature' => $support_signature,
                );

                $subject = 'New payment receipt # ' . $payment->receipt_number . ' at ' . $site_name . ' site ';
                // rename ( string $oldname , string $newname [, resource $context ] ) : bool
                $rename_ret = rename($save_to_file, $save_to_clear_file);
                    \Log::info('-100 $rename_ret ::' . print_r($rename_ret, true));

                $attachFiles = [$save_to_clear_file];
                    \Log::info('-10 $cc ::' . print_r($cc, true));
                    \Log::info('-1 $attachFiles ::' . print_r($attachFiles, true));

                \Mail::to($invoiceCreatorEmail)->send(new SendgridMail('emails/payment_send', $client_email, $cc, $subject,
                    $additiveVars, $attachFiles));
                with(new Payment)->setFlashMessage("Payment # " . $payment->receipt_number . ' was sent to ' . $client_full_name . ' !',
                    'success');

                if ($rename_ret) {
                    @unlink($save_to_clear_file);
                }

                return Redirect::back();
            }  // if ($requestData['pdf_content_hidden_action'] == 'send_by_email') {

        } // if($generated_file_action == 'send_by_email') {

        return [
            'save_to_file'       => $save_to_file,
            'filename_to_save'   => $filename_to_save,
            'save_to_clear_file' => $save_to_clear_file
        ];
    } // public static function generatePaymentReceiptPdfByContent($invoice_id, $viewParamsArray, $requestData) {


}
