<?php

namespace App\Http\Controllers\Server;

use App\Http\Controllers\Controller;

use Stripe\StripeClient;

use App\User;
use Illuminate\Database\DatabaseManager;

use App\Models\Transactions;
use App\Models\Invoices;
use Exception;

class AdminStripeController extends Controller
{
	protected StripeClient $stripeClient;
	protected DatabaseManager $databaseManager;

	public function __construct(StripeClient $stripeClient, DatabaseManager $databaseManager) {
        // if(!Auth::check()){
        //     return redirect('/');
        // }
		\Log::info(varDump(-9, ' -9 AdminStripeController ::'));
		// \Log::info(varDump($stripeClient, ' -1 AdminStripeController ::'));
		$this->stripeClient = $stripeClient;
		$this->databaseManager = $databaseManager;
    }

	public function payConsultantInvoice($invoice_id)
    {
        $invoice = Invoices::find($invoice_id);
        if (!$invoice) {
            abort(500, 'Invoice not found');
        }
        $appEnv = strtolower(config('app.env'));
        if ($appEnv == 'local' or $appEnv == 'dev') {
            $key = config('app.STRIPE_TEST_KEY');
        }
        if ($appEnv == 'production') {
            $key = config('app.STRIPE_LIVE_KEY');
        }
        try {
            $invoice_id = $invoice->invoice_id;
            $stripe = new StripeClient($key);
            $stripe->invoices->pay($invoice_id, []);

            # update invoices and users table
            $invoice->status = 'P';
            $invoice->save();

            $user = User::find($invoice->creator_id);
            $user->balance = (float)$user->balance - (float)$invoice->total;
            $user->save();

            foreach(json_decode($invoice->ref_transactions) as $transaction_id) {
                $transaction = Transactions::find((int)$transaction_id);
                $transaction->payed_at = date("Y-m-d H:m:s");
                $transaction->status = 'P';
                $transaction->save();
            }
        }
        catch (Exception $err) {
            \Log::info('Stripe Invoice Pay ::' . print_r($err->getMessage(), true));
        }

        return redirect()->back();
    } // public function payConsultantInvoice($invoice_id)

}
