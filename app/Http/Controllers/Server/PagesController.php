<?php

namespace App\Http\Controllers\Server;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App;
use DateTime;
use App\User;
use App\Models\Categories;
use App\Models\Consultant;
use App\Models\Customer;
use Carbon\Carbon;
use DB;

use App\Models\Page;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Certificate;
use App\Models\Transactions;
use App\Models\Invoices;

class PagesController extends Controller
{
    public function __construct () {
        if(!Auth::check()){
            return redirect('/');
        }
    }
    public function adminDashboard() {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        $customers = Customer::count();
        $consultants = Consultant::count();
        $start_date = new DateTime('first day of this month');
        $start_time = clone $start_date->setTime(0, 0, 0);
        $end_date = new DateTime('last day of this month');
        $end_time = $end_date->setTime(23, 59, 59);

        $earning = 0;
        $transaction_list = Transactions::where('created_at', '>=', $start_time)->where('created_at', '<=', $end_time)->get();
        foreach ($transaction_list as $transaction) {
           $earning += $transaction->amount;
        }
        $search = [
            "start" => 'null',
            "end" => 'null'
        ];
        return view('admin.dashboard', ['active' => '0', 'customers' => $customers, 'consultants' => $consultants, 'search' => $search, 'earning' => $earning]);
    }
    public function adminDashboardSearch(Request $request) {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        $startDate_array = explode("/", $request->input('start'));
        $startDate = "$startDate_array[2]-$startDate_array[0]-$startDate_array[1]"." 00:00:00";
        $endDate_array = explode("/", $request->input('end'));
        $endDate = "$endDate_array[2]-$endDate_array[0]-$endDate_array[1]"." 23:59:59";
        $customers = Customer::whereBetween('created_at', [$startDate, $endDate])->count();
        $consultants = Consultant::whereBetween('created_at', [$startDate, $endDate])->count();
        $earning = 0;
        $transaction_list = Transactions::where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->get();
        foreach ($transaction_list as $transaction) {
           $earning += $transaction->amount;
        }
        $search = [
            "start" => $request->start,
            "end" => $request->end
        ];
        return view('admin.dashboard', ['active' => '0', 'customers' => $customers, 'consultants' => $consultants, "search" => $search, 'earning' => $earning]);
    }
    //PAGES
    public function pages () {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        $pages = Page::all();
        return view('admin.pages', compact('pages'), ['active' => '4']);
    }
    public function createPage() {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        return view('admin.create_page', ['active' => '4']);
    }
    public function editPage(Request $request) {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        $page = Page::where('id', $request->id)->first();
        $page_body = json_decode($page->page_body);
        if ($request->id == 6) {
            return view('admin.edit_privacy', compact('page', 'page_body'), ['active' => '4']);
        } else if ($request->id == 5) {
            return view('admin.edit_terms_customer', compact('page', 'page_body'), ['active' => '4']);
        } else if ($request->id == 9) {
            return view('admin.edit_terms_provider', compact('page', 'page_body'), ['active' => '4']);
        } else {
            return view('admin.edit_page', compact('page', 'page_body'), ['active' => '4']);
        }
    }
    //CATEGORIES
    public function categories () {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        $categories = Categories::all();
        return view('admin.categories', compact('categories'), ['active' => '3']);
    }
    public function createCategory () {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        return view('admin.create_category', ['active' => '3']);
    }
    public function editCategory (Request $request) {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        $category = Categories::where('id', $request->id)->first();
        return view('admin.edit_category', compact('category'), ['active' => '3']);
    }
    //CUSTOMERS
    public function customers () {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        $customers = Customer::with('user', 'profile')->get();
        return view('admin.customers', compact('customers'), ['active' => '1']);
    }
    public function createCustomer () {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        $categories = Categories::all();
        return view('admin.create_customer', compact('categories'), ['active' => '1']);
    }
    public function editCustomer (Request $request) {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        $user = User::where('id', $request->id)->first();
        $customer = Customer::where('user_id', $request->id)->with('user', 'profile')->first();
        $categories = Categories::all();
        return view('admin.edit_customer', compact('customer', 'user', 'categories'), ['active' => '1']);
    }
    //CONSULTANTS
    public function consultants () {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        $consultants = Consultant::with('user', 'profile')->get();
        return view('admin.consultants', compact('consultants'), ['active' => '2']);
    }
    public function createConsultant () {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        $categories = Categories::all();
        $count = Categories::count();
        return view('admin.create_consultant', compact('categories', 'count'), ['active' => '2']);
    }
    public function editConsultant (Request $request) {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        $consultant = Consultant::where('user_id', $request->id)->with('profile', 'user', 'company')->first();
        $educations = Education::where('consultant_id', $consultant->id)->get();
        $experiences = Experience::where('consultant_id', $consultant->id)->get();
        $certificates = Certificate::where('consultant_id', $consultant->id)->get();
        $categories = Categories::all();
        return view('admin.edit_consultant', compact('consultant', 'categories', 'educations', 'experiences', 'certificates'), ['active' => '2']);
    }
    //SETTING
    public function settting () {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        return view('admin.settings', ['active' => '8']);
    }

    public function adminTransaction () {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        $metaTitle = App::getLocale() == 'en' ? 'My Transactions' : 'Mine transaksjoner';
        $metaDescription = '';

        $start_date = new DateTime('first day of this month');
        $start_time = clone $start_date->setTime(0, 0, 0);
        $end_date = new DateTime('last day of this month');
        $end_time = $end_date->setTime(23, 59, 59);


        $transactions = [];
        $transaction_list = Transactions::where('created_at', '>=', $start_time)->where('created_at', '<=', $end_time)->get();
        $summery_vat_amount = 0;
        $summery_total_amount = 0;
        foreach ($transaction_list as $transaction) {
            $user = User::where('id', $transaction->payer_id)->first();
            if ($transaction->type == 'CUSTOCON') {
                $payer = Customer::where('user_id', $user->id)->with('profile')->first();
                $receiver = Consultant::where('id', $transaction->receiver_id)->with('profile', 'user')->first();
            } else {
                $payer = Consultant::where('user_id', $user->id)->with('profile')->first();
                $receiver = Consultant::where('id', $transaction->receiver_id)->with('profile', 'user')->first();
            }

            $transaction['payer_img'] = $payer->profile->avatar;
            $transaction['payer_name'] = $user->first_name." ".$user->last_name;
            $transaction['receiver_img'] = $receiver->profile->avatar;
            $transaction['receiver_name'] = $receiver->user->first_name." ".$receiver->user->last_name;
            $transaction['status_label'] = Transactions::getStatusLabel($transaction->status);
            array_push($transactions, $transaction);
            $summery_vat_amount += $transaction->vat_amount ?? 0;
            $summery_total_amount += $transaction->total_amount ?? 0;
        }
        $settingsFee = auth()->user()->fee;
        $consultants = Consultant::with('user')->get();
        $search = [
            'consultant' => 'All',
            'date' => date('M, Y')
        ];
        $tax_percent= 5;
        \Log::info('-10 $transactions ::' . print_r($transactions, true));
        return view('admin.transaction', compact('transactions', 'tax_percent', 'settingsFee', 'consultants', 'search', 'summery_total_amount', 'summery_vat_amount' ), ['active' => '5', 'title' => $metaTitle,'description' => $metaDescription]);
    }

    public function adminTransactionSearch(Request $request) {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        $metaTitle = App::getLocale() == 'en' ? 'My Transactions' : 'Mine transaksjoner';
        $metaDescription = '';

        $date_str = explode('/', $request->date);
        $start_date = date('Y-m-d', strtotime($date_str[1]."-".$date_str[0]."-"."01"));
        $end_date = date('Y-m-t', strtotime($date_str[1]."-".$date_str[0]."-"."01"));
        $search_date = date('M, Y', strtotime($date_str[1]."-".$date_str[0]."-"."01"));

        $transactions = [];
        $transaction_list = Transactions::where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date)->get();
        if ($request->consultant != 'All') {
            $consultant = Consultant::where('id', $request->consultant)->with('profile', 'user')->first();
            $transaction_list = Transactions::where('payer_id', $consultant->user_id)
                                ->orWhere('receiver_id', $request->consultant)
                                ->where('created_at', '>=', $start_date)
                                ->where('created_at', '<=', $end_date)->get();
        }
        $summery_vat_amount = 0;
        $summery_total_amount = 0;

        foreach ($transaction_list as $transaction) {
            $user = User::where('id', $transaction->payer_id)->first();
            if ($transaction->type == 'CUSTOCON') {
                $payer = Customer::where('user_id', $user->id)->with('profile')->first();
                $receiver = Consultant::where('id', $transaction->receiver_id)->with('profile', 'user')->first();
            } else {
                $payer = Consultant::where('user_id', $user->id)->with('profile')->first();
                $receiver = Consultant::where('id', $transaction->receiver_id)->with('profile', 'user')->first();
            }
            $transaction['payer_img'] = $payer->profile->avatar;
            $transaction['payer_name'] = $user->first_name." ".$user->last_name;
            $transaction['receiver_img'] = $receiver->profile->avatar;
            $transaction['receiver_name'] = $receiver->user->first_name." ".$receiver->user->last_name;
            $transaction['period_string'] = $start_date .' - '. $end_date;
            $transaction['status_label'] = Transactions::getStatusLabel($transaction->status);
            array_push($transactions, $transaction);
            $summery_vat_amount += $transaction->vat_amount ?? 0;
            $summery_total_amount += $transaction->total_amount ?? 0;
        }
        $consultants = Consultant::with('user')->get();
        $settingsFee = auth()->user()->fee;
        $search = [
            'consultant' => $request->consultant,
            'date' => $search_date
        ];
        $tax_percent= 5;
        \Log::info('-1 $transactions ::' . print_r($transactions, true));
        return view('admin.transaction', compact('transactions', 'tax_percent', 'settingsFee', 'consultants', 'search', 'summery_total_amount', 'summery_vat_amount'), ['active' => '5', 'title' => $metaTitle,'description' => $metaDescription]);
    }

    public function adminDeleteTransaction( $transaction_id ) {
        $transaction = Transactions::find($transaction_id);
        if(empty($transaction)) {
            return response()->json(['status' => false]);
        }

        $transaction->delete();
        return response()->json(true);
    }


    public function adminPayout() {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        $start_date = new DateTime('first day of this month');
//        echo '<pre>$start_date->format(Y)::'.print_r($start_date->format('Y'),true).'</pre>';
//        echo '<pre>$start_date->format(m)::'.print_r($start_date->format('m'),true).'</pre>';
        $end_date = new DateTime('last day of this month');
//        echo '<pre>$end_date->format(Y)::'.print_r($end_date->format('Y'),true).'</pre>';
//        echo '<pre>$end_date->format(m)::'.print_r($end_date->format('m'),true).'</pre>';

        $url= '/admin-payout-search?date_from='.$start_date->format('m').'/'.$start_date->format('Y').'&date_till='.$end_date->format('N').'/'.$end_date->format('Y').'&consultant=All';
//        echo '<pre>$url::'.print_r($url,true).'</pre>';
//        die("-1 XXZ");
        return redirect($url);
    }

    public function adminPayoutSearch(Request $request) {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        $metaTitle = App::getLocale() == 'en' ? 'My Payouts' : 'Mine utbetalinger';
        $metaDescription = '';
//        \Log::info( '-1 $request->date_from ::' . print_r( $request->date_from, true  ) );
//        \Log::info( '-11 $request->date_till ::' . print_r( $request->date_till, true  ) );


        $date_from_str = explode('/', $request->date_from);
        $start_from_date = date('Y-m-d', strtotime($date_from_str[1]."-".$date_from_str[0]."-"."01"));
//        \Log::info(  varDump($start_from_date, ' -1 $start_from_date::') );

        $date_till_str = explode('/', $request->date_till);
        $end_till_date = date('Y-m-t', strtotime($date_till_str[1]."-".$date_till_str[0]."-"."01"));
        $end_time = $end_till_date . ' 23:59:59';

        $search_date_from = date('M, Y', strtotime($date_from_str[1]."-".$date_from_str[0]."-"."01"));
        $search_date_till = date('M, Y', strtotime($date_till_str[1]."-".$date_till_str[0]."-"."01"));

        $settingsFee = auth()->user()->fee;

//        \Log::info( '-1 $start_from_date ::' . print_r( $start_from_date, true  ) );
//        \Log::info( '-1 $end_till_date ::' . print_r( $end_till_date, true  ) );

        $payouts = [];
        $payout_list= Transactions
            ::getByReceiverId($request->consultant)
            ->select('receiver_id', DB::raw('sum(amount) as amount_total, sum(vat_amount) as vat_amount_total, sum(total_amount) as total_amount_total'))
            ->where('created_at', '>=', $start_from_date)
            ->where('created_at', '<=', $end_till_date . " 23:59:59' ")
            ->groupBy('receiver_id')
            ->get()
            ->toArray();
//        \Log::info(  varDump($payout_list, ' -123 $payout_list::') );

        $summery_vat_amount_total = 0;
        $summery_total_amount_total = 0;

        foreach ($payout_list as $payout) {
            $consultantTransactionsPeriodText= '';
            $consultantTransactionsIdText= '';
            $receiver = Consultant::where('id', $payout['receiver_id'])->with('profile', 'user')->first();

            $consultantTransactions = Transactions
                ::where('receiver_id', $payout['receiver_id'])
                ->where('created_at', '>=', $start_from_date)
                ->where('created_at', '<=', $end_till_date . " 23:59:59' ")
                ->orderBy('created_at', 'asc')
                ->get();
            if(count($consultantTransactions) > 0) {
                $consultantTransactionsPeriodText= $consultantTransactions[0]->created_at->format('Y-m-d') . ' - ' .
                     $consultantTransactions[ count($consultantTransactions) -1 ]->created_at->format('Y-m-d');
                for( $i=0; $i< count($consultantTransactions);  $i++ ) {
                    $consultantTransactionsIdText.= 'GTC-'.$consultantTransactions[$i]->id . ( $i < count($consultantTransactions) - 1 ? ', ':'');
                }
            }

            $payout['receiver_img'] = $receiver->profile->avatar;
            $payout['period_string'] = $start_from_date .' - '. $end_till_date;

            $payout['receiver_name'] = /*$receiver->id . '->' . */ $receiver->user->first_name." ".$receiver->user->last_name;
            $payout['consultantTransactionsPeriodText'] = $consultantTransactionsPeriodText;
            $payout['consultantTransactionsIdText'] = $consultantTransactionsIdText;

            array_push($payouts, $payout);
            $summery_vat_amount_total += $payout['vat_amount_total'] ?? 0;
            $summery_total_amount_total += $payout['total_amount_total'] ?? 0;
        }
        $consultants = Consultant::with('user')->get();
        $search = [
            'consultant' => $request->consultant,
            'date_from' => $search_date_from,
            'date_till' => $search_date_till,
        ];
        $tax_percent= 5;
        return view('admin.payout', compact('payouts', 'settingsFee', 'tax_percent', 'consultants', 'search', 'summery_total_amount_total', 'summery_vat_amount_total'), ['active' => '6', 'title' => $metaTitle,'description' => $metaDescription]);
    } // public function adminPayoutSearch(Request $request) {

    public function adminSetTransactionStatusPayed(Request $request) {

        $requestData = $request->all();
        $id= $requestData['id'];
        $transaction = Transactions::find($id);
        if(empty($transaction)) {
            return response()->json(['status' => false]);
        }

        $transaction->status= 1;
        $transaction->payed_at= Carbon::now(config('app.timezone'));
        $transaction->updated_at= Carbon::now(config('app.timezone'));
        $transaction->save();
        return response()->json(true);
    }


    public function adminInvoices() {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        $start_date = new DateTime('first day of this month');
//        echo '<pre>$start_date->format(Y)::'.print_r($start_date->format('Y'),true).'</pre>';
//        echo '<pre>$start_date->format(m)::'.print_r($start_date->format('m'),true).'</pre>';
        $end_date = new DateTime('last day of this month');
//        echo '<pre>$end_date->format(Y)::'.print_r($end_date->format('Y'),true).'</pre>';
//        echo '<pre>$end_date->format(m)::'.print_r($end_date->format('m'),true).'</pre>';

        $url= '/admin-invoices-search?date_from='.$start_date->format('m').'/'.$start_date->format('Y').'&date_till='.$end_date->format('m').'/'.$end_date->format('Y').'&consultant=All';
//        echo '<pre>$url::'.print_r($url,true).'</pre>';
//        die("-1 XXZ");
        return redirect($url);
    }

    public function adminInvoicesSearch(Request $request) {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }

        $metaTitle = App::getLocale() == 'en' ? 'My Invoices' : 'Mine utbetalinger';
        $metaDescription = '';
//        \Log::info( '-1 $request->date_from ::' . print_r( $request->date_from, true  ) );
//        \Log::info( '-11 $request->date_till ::' . print_r( $request->date_till, true  ) );


        $date_from_str = explode('/', $request->date_from);
        $start_from_date = date('Y-m-d', strtotime($date_from_str[1]."-".$date_from_str[0]."-"."01"));
//        \Log::info(  varDump($start_from_date, ' -1 $start_from_date::') );

        $date_till_str = explode('/', $request->date_till);
        $end_till_date = date('Y-m-t', strtotime($date_till_str[1]."-".$date_till_str[0]."-"."01"));
        $end_time = $end_till_date . ' 23:59:59';

        $search_date_from = date('M, Y', strtotime($date_from_str[1]."-".$date_from_str[0]."-"."01"));
        $search_date_till = date('M, Y', strtotime($date_till_str[1]."-".$date_till_str[0]."-"."01"));

        $settingsFee = auth()->user()->fee;

//        \Log::info( '-1 $start_from_date ::' . print_r( $start_from_date, true  ) );
//        \Log::info( '-1 $end_till_date ::' . print_r( $end_till_date, true  ) );

        $invoices = [];
        $invoices_list= Invoices
            ::getByCreatorId($request->consultant)
            ->select('invoices.*')
            ->where('created_at', '>=', $start_from_date)
            ->where('created_at', '<=', $end_till_date . " 23:59:59' ")
            ->get()
            ->toArray();
    //    \Log::info(  varDump($invoices_list, ' -123 $invoices_list::') );

        foreach ($invoices_list as $invoice) {
            $creator = User::where('id', $invoice['creator_id'])/*->with('profile')*/->first();

            // $invoice['receiver_img'] = $receiver->profile->avatar;
            // $invoice['period_string'] = $start_from_date .' - '. $end_till_date;


            $invoice['status_label'] = Invoices::getStatusLabel($invoice['status']);

            $invoice['creator_name'] = /*$creator->id . '->' .  */$creator->first_name." ".$creator->last_name;
            // $invoice['consultantTransactionsPeriodText'] = $consultantTransactionsPeriodText;
            // $invoice['consultantTransactionsIdText'] = $consultantTransactionsIdText;

            array_push($invoices, $invoice);
        }
        $consultants = Consultant::with('user')->get();
        $search = [
            'consultant' => $request->consultant,
            'date_from' => $search_date_from,
            'date_till' => $search_date_till,
        ];
        $tax_percent= 5;
        return view('admin.invoices', compact('invoices', 'settingsFee', 'tax_percent', 'consultants', 'search'), ['active' => '7', 'title' => $metaTitle,'description' => $metaDescription]);
    } // public function adminInvoicesSearch(Request $request) {

}
