<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\MissedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use Spatie\Browsershot\Browsershot;

use Carbon\Carbon;

use App\User;
use App\Booking;
use App\Models\Page;
use App\Models\Categories;
use App\Models\Consultant;
use App\Models\Customer;
use App\Models\Company;
use App\Models\ChargingTransactions;
use App\Models\Transactions;
use App\Models\Review;
use App\Models\Session;
use App\Models\Requests;
use App\Models\Profile;
use App\Models\Education;
use App\Models\TwilioChannels;
use App\Models\Experience;
use App\Models\Certificate;
use App\Models\Invoices;

use App\Mail\UserRegister;
use App\Mail\ForgotPassword;
use App\Mail\ConsultantRegisterSuccess;
use App;
use Auth;
use DateTime;
use Agent;
use App\Plan;
use App\PlanSession;
use Hash;
use EmailChecker;
use Exception;
use Illuminate\Support\Facades\Log;
use Stripe\StripeClient;

//use Session;

class PagesController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            if (App::getLocale() == 'en') {
                $url = Auth::user()->role == 'admin' ? '/admin-dashboard' : '/dashboard';
            } else {
                $url = Auth::user()->role == 'admin' ? '/no/admin-dashbord' : '/no/oversikt';
            }
            return redirect($url);
        }
        // $users = User::join('consultants', function($join) {
        //     $join->on('users.id', 'consultants.user_id')
        //     ->where('consultants.currency', 'NOK');
        // })
        // ->join('profile', function($join) {
        //     $join->on('consultants.profile_id', 'profile.id')
        //     ->where('profile.from', 'Norway');
        // })
        // ->where('active', 1)
        // ->select('users.first_name', 'users.id', 'profile.zip_code', 'consultants.hourly_rate')
        // ->where('role', 'consultant')->get()->toArray();

        $page = Page::where('id', '63')->first();
        $data = json_decode($page->page_body);

        $consultantsAndServicesPage = Page::where('id', '10')->first();
        $consultantsAndServicesPageData = json_decode($consultantsAndServicesPage->page_body);

        $categories = [];
        $review_list = [];
        $customer_reviews = [];
        $consultant_reviews = [];
        $reviews = Review::get();
        foreach ($reviews as $review) {
            if ($review->type == "CUSTOCON") {
                $user = Customer::where('user_id', $review->sender_id)->with(['profile', 'user'])->first();
                $review['customer'] = $user;
                array_push($customer_reviews, $review);
            } else {
                $user = Consultant::where('user_id', $review->sender_id)->with(['profile', 'user'])->first();
                $review['consultant'] = $user;
                array_push($consultant_reviews, $review);
            }
        }
        if (count($customer_reviews) > 0) {
            if (count($customer_reviews) > 8) {
                $a = array_rand($customer_reviews, 9);
            } elseif (count($customer_reviews) > 1) {
                $a = array_rand($customer_reviews, count($customer_reviews));
            } else {
                $a = ["0"];
            }

            foreach ($a as $index) {
                array_push($review_list, $customer_reviews[$index]);
            }
        }
        if (count($consultant_reviews) > 0) {
            if (count($consultant_reviews) > 8) {
                $b = array_rand($consultant_reviews, 9);
            } elseif (count($consultant_reviews) > 1) {
                $b = array_rand($consultant_reviews, count($consultant_reviews));
            } else {
                $b = ["0"];
            }

            foreach ($b as $index) {
                array_push($review_list, $consultant_reviews[$index]);
            }
        }
        $review_count = count($review_list);
        return view('pages.home', compact('categories', 'data', 'consultantsAndServicesPageData', 'review_list', 'review_count'), ['title' => $page->meta_title, 'description' => $page->meta_description]);
    }

    public function updateLang(Request $request)
    {
        $url = $request->lang == 'en' ? '/' . $request->address : '/no/' . $request->address;
        App::setLocale($request->lang);
        session()->put('locale', $request->lang);
        return redirect($url);
    }

    public function category_info(Request $request)
    {
        if (Auth::check()) {
            return App::getLocale() == 'en' ? (Auth::user()->role == 'admin' ? redirect('/admin-dashboard') : redirect('/dashboard')) : (Auth::user()->role != 'admin' ? redirect('/no/oversikt') : redirect('/no/admin-dashbord'));
        }
        $category = Categories::where('category_url', $request->type)->first();
        $consultants = Consultant::whereHas('profile', function ($q) use ($request) {
            $q->where('profession', $request->type);
        })->whereHas('user', function ($q) {
            $q->where('active', 1);
        })->with('profile', 'user')->get();

        $page = Page::where('id', 1)->first();
        $data = json_decode($page->page_body);
        $countries = [];
        $profiles = Profile::get();
        foreach ($profiles as $profile) {
            if (!in_array($profile->country, $countries)) {
                array_push($countries, $profile->country);
            }
        }
        $search = [
            'name' => 'null',
            'category' => $request->type,
            'price' => 'Default',
            'status' => 'All',
            'country' => 'All'
        ];
        $review_list = [];
        $customer_reviews = [];
        $consultant_reviews = [];
        $reviews = Review::get();
        foreach ($reviews as $review) {
            if ($review->type == "CUSTOCON") {
                $user = Customer::where('user_id', $review->sender_id)->with(['profile', 'user'])->first();
                $review['customer'] = $user;
                array_push($customer_reviews, $review);
            } else {
                $user = Consultant::where('user_id', $review->sender_id)->with(['profile', 'user'])->first();
                $review['consultant'] = $user;
                array_push($consultant_reviews, $review);
            }
        }
        if (count($customer_reviews) > 0) {
            if (count($customer_reviews) > 8) {
                $a = array_rand($customer_reviews, 9);
            } elseif (count($customer_reviews) > 1) {
                $a = array_rand($customer_reviews, count($customer_reviews));
            } else {
                $a = ["0"];
            }

            foreach ($a as $index) {
                array_push($review_list, $customer_reviews[$index]);
            }
        }
        if (count($consultant_reviews) > 0) {
            if (count($consultant_reviews) > 8) {
                $b = array_rand($consultant_reviews, 9);
            } elseif (count($consultant_reviews) > 1) {
                $b = array_rand($consultant_reviews, count($consultant_reviews));
            } else {
                $b = ["0"];
            }

            foreach ($b as $index) {
                array_push($review_list, $consultant_reviews[$index]);
            }
        }
        $review_count = count($review_list);
        return view('pages.category_info', compact('category', 'consultants', 'data', 'countries', 'search', 'review_list', 'review_count'), [
            'title' => App::getLocale() == 'en' ? 'GoToConsult - ' . $category->meta_title : 'GoToConsult - ' . $category->no_meta_title,
            'description' => $category->meta_description
        ]);
    }

    public function categorySearch(Request $request)
    {
        if (Auth::check()) {
            return App::getLocale() == 'en' ? (Auth::user()->role == 'admin' ? redirect('/admin-dashboard') : redirect('/dashboard')) : (Auth::user()->role != 'admin' ? redirect('/no/oversikt') : redirect('/no/admin-dashbord'));
        }
        $category = Categories::where('category_url', $request->category)->first();
        $consultants = Consultant::whereHas('profile', function ($q) use ($request) {
            $q->where('profession', $request->category);
        })->whereHas('user', function ($q) {
            $q->where('active', 1);
        })->orderBy('hourly_rate', $request->price == 'low-high' ? 'asc' : 'desc')->with('user', 'profile')->get();
        if ($request->status != 'All') { //AC -> category + status + price
            $consultants = Consultant::whereHas('profile', function ($q) use ($request) {
                $q->where('profession', $request->category);
            })->whereHas('user', function ($q) use ($request) {
                if ($request->status != 'busy') {
                    $q->where('active', 1)->where('status', $request->status);
                } else {
                    $q->where('active', 1)->where('status', 'In a chat')->orWhere('status', 'In a call')->orWhere('status', 'In a Video call');
                }
            })->orderBy('hourly_rate', $request->price == 'low-high' ? 'asc' : 'desc')->with('user', 'profile')->get();
            if ($request->country != 'All') { //AD -> category + status + country + price
                $consultants = Consultant::whereHas('profile', function ($q) use ($request) {
                    $q->where('profession', $request->category)->where('country', $request->country);
                })->whereHas('user', function ($q) use ($request) {
                    if ($request->status != 'busy') {
                        $q->where('active', 1)->where('status', $request->status);
                    } else {
                        $q->where('active', 1)->where('status', 'In a chat')->orWhere('status', 'In a call')->orWhere('status', 'In a Video call');
                    }
                })->orderBy('hourly_rate', $request->price == 'low-high' ? 'asc' : 'desc')->with('user', 'profile')->get();
                if ($request->name != 'null') { // ADE -> category + status + country + name + price
                    $consultants = Consultant::whereHas('profile', function ($q) use ($request) {
                        $q->where('profession', $request->category)->where('country', $request->country);
                    })->whereHas('user', function ($q) use ($request) {
                        if ($request->status != 'busy') {
                            $q->where('active', 1)->where('status', $request->status)->where('first_name', 'LIKE', '%' . $request->name . '%')->orWhere('last_name', 'LIKE', '%' . $request->name . '%');
                        } else {
                            $q->where('active', 1)->where('status', 'In a chat')->orWhere('status', 'In a call')->orWhere('status', 'In a Video call')->where('first_name', 'LIKE', '%' . $request->name . '%')->orWhere('last_name', 'LIKE', '%' . $request->name . '%');
                        }
                    })->orderBy('hourly_rate', $request->price == 'low-high' ? 'asc' : 'desc')->with('user', 'profile')->get();
                }
            } else { //AE -> category + status + name + price
                if ($request->name != 'null') {
                    $consultants = Consultant::whereHas('profile', function ($q) use ($request) {
                        $q->where('profession', $request->category);
                    })->whereHas('user', function ($q) use ($request) {
                        if ($request->status != 'busy') {
                            $q->where('active', 1)->where('status', $request->status)->where('first_name', 'LIKE', '%' . $request->name . '%')->orWhere('last_name', 'LIKE', '%' . $request->name . '%');
                        } else {
                            $q->where('active', 1)->where('status', 'In a chat')->orWhere('status', 'In a call')->orWhere('status', 'In a Video call')->where('first_name', 'LIKE', '%' . $request->name . '%')->orWhere('last_name', 'LIKE', '%' . $request->name . '%');
                        }
                    })->orderBy('hourly_rate', $request->price == 'low-high' ? 'asc' : 'desc')->with('user', 'profile')->get();
                }
            }
        } else {
            if ($request->country != 'All') { //AD -> category + country + price
                $consultants = Consultant::whereHas('profile', function ($q) use ($request) {
                    $q->where('profession', $request->category)->where('country', $request->country);
                })->whereHas('user', function ($q) {
                    $q->where('active', 1);
                })->orderBy('hourly_rate', $request->price == 'low-high' ? 'asc' : 'desc')->with('user', 'profile')->get();
                if ($request->name != 'null') { // ADE -> category + country + name + price
                    $consultants = Consultant::whereHas('profile', function ($q) use ($request) {
                        $q->where('profession', $request->category)->where('country', $request->country);
                    })->whereHas('user', function ($q) use ($request) {
                        $q->where('active', 1)->where('first_name', 'LIKE', '%' . $request->name . '%')->orWhere('last_name', 'LIKE', '%' . $request->name . '%');
                    })->orderBy('hourly_rate', $request->price == 'low-high' ? 'asc' : 'desc')->with('user', 'profile')->get();
                }
            } else { // category + name + price
                if ($request->name != 'null') { //AE
                    $consultants = Consultant::whereHas('profile', function ($q) use ($request) {
                        $q->where('profession', $request->category);
                    })->whereHas('user', function ($q) use ($request) {
                        $q->where('active', 1)->where('first_name', 'LIKE', '%' . $request->name . '%')->orWhere('last_name', 'LIKE', '%' . $request->name . '%');
                    })->orderBy('hourly_rate', $request->price == 'low-high' ? 'asc' : 'desc')->with('user', 'profile')->get();
                }
            }
        }

        $page = Page::where('id', 1)->first();
        $data = json_decode($page->page_body);
        $countries = [];
        $profiles = Profile::get();
        foreach ($profiles as $profile) {
            if (!in_array($profile->country, $countries)) {
                array_push($countries, $profile->country);
            }
        }
        $search = [
            'name' => $request->name,
            'category' => $request->category,
            'price' => $request->price,
            'status' => $request->status,
            'country' => $request->country
        ];
        $review_list = [];
        $customer_reviews = [];
        $consultant_reviews = [];
        $reviews = Review::get();
        foreach ($reviews as $review) {
            if ($review->type == "CUSTOCON") {
                $user = Customer::where('user_id', $review->sender_id)->with(['profile', 'user'])->first();
                $review['customer'] = $user;
                array_push($customer_reviews, $review);
            } else {
                $user = Consultant::where('user_id', $review->sender_id)->with(['profile', 'user'])->first();
                $review['consultant'] = $user;
                array_push($consultant_reviews, $review);
            }
        }
        if (count($customer_reviews) > 0) {
            if (count($customer_reviews) > 8) {
                $a = array_rand($customer_reviews, 9);
            } elseif (count($customer_reviews) > 1) {
                $a = array_rand($customer_reviews, count($customer_reviews));
            } else {
                $a = ["0"];
            }

            foreach ($a as $index) {
                array_push($review_list, $customer_reviews[$index]);
            }
        }
        if (count($consultant_reviews) > 0) {
            if (count($consultant_reviews) > 8) {
                $b = array_rand($consultant_reviews, 9);
            } elseif (count($consultant_reviews) > 1) {
                $b = array_rand($consultant_reviews, count($consultant_reviews));
            } else {
                $b = ["0"];
            }

            foreach ($b as $index) {
                array_push($review_list, $consultant_reviews[$index]);
            }
        }
        $review_count = count($review_list);
        return view('pages.category_info', compact('category', 'consultants', 'data', 'countries', 'search', 'review_list', 'review_count'), [
            'title' => App::getLocale() == 'en' ? 'GoToConsult - ' . $category->meta_title : 'GoToConsult - ' . $category->no_meta_title,
            'description' => App::getLocale() == 'en' ? $category->meta_description : $category->no_meta_description
        ]);
    }

    public function features()
    {
        if (Auth::check()) {
            return App::getLocale() == 'en' ? (Auth::user()->role == 'admin' ? redirect('/admin-dashboard') : redirect('/dashboard')) : (Auth::user()->role != 'admin' ? redirect('/no/oversikt') : redirect('/no/admin-dashbord'));
        }
        $page = Page::where('id', '10')->first();
        $data = json_decode($page->page_body);
        $review_list = [];
        $customer_reviews = [];
        $consultant_reviews = [];
        $reviews = Review::get();
        foreach ($reviews as $review) {
            if ($review->type == "CUSTOCON") {
                $user = Customer::where('user_id', $review->sender_id)->with(['profile', 'user'])->first();
                $review['customer'] = $user;
                array_push($customer_reviews, $review);
            } else {
                $user = Consultant::where('user_id', $review->sender_id)->with(['profile', 'user'])->first();
                $review['consultant'] = $user;
                array_push($consultant_reviews, $review);
            }
        }
        if (count($customer_reviews) > 0) {
            if (count($customer_reviews) > 8) {
                $a = array_rand($customer_reviews, 9);
            } elseif (count($customer_reviews) > 1) {
                $a = array_rand($customer_reviews, count($customer_reviews));
            } else {
                $a = ["0"];
            }

            foreach ($a as $index) {
                array_push($review_list, $customer_reviews[$index]);
            }
        }
        if (count($consultant_reviews) > 0) {
            if (count($consultant_reviews) > 8) {
                $b = array_rand($consultant_reviews, 9);
            } elseif (count($consultant_reviews) > 1) {
                $b = array_rand($consultant_reviews, count($consultant_reviews));
            } else {
                $b = ["0"];
            }

            foreach ($b as $index) {
                array_push($review_list, $consultant_reviews[$index]);
            }
        }
        $review_count = count($review_list);
        return view('pages.features', compact('data', 'review_list', 'review_count'), [
            'title' => App::getLocale() == 'en' ? $page->meta_title : $page->no_meta_title,
            'description' => App::getLocale() == 'en' ? $page->meta_description : $page->no_meta_description,
        ]);
    }

    public function become_consultant()
    {
        if (Auth::check()) {
            return App::getLocale() == 'en' ? (Auth::user()->role == 'admin' ? redirect('/admin-dashboard') : redirect('/dashboard')) : (Auth::user()->role != 'admin' ? redirect('/no/oversikt') : redirect('/no/admin-dashbord'));
        }
        $categories = Categories::all();
        $count = Categories::count();
        $page = Page::where('id', '2')->first();
        $data = json_decode($page->page_body);
        $terms_page = Page::where('id', '9')->first();
        $terms = json_decode($terms_page->page_body);
        return view('pages.become_consultant', compact('categories', 'count', 'data', 'terms'), [
            'title' => App::getLocale() == 'en' ? $page->meta_title : $page->no_meta_title,
            'description' => App::getLocale() == 'en' ? $page->meta_description : $page->no_meta_description,
        ]);
    }

    public function about_us()
    {
        if (Auth::check()) {
            return App::getLocale() == 'en' ? (Auth::user()->role == 'admin' ? redirect('/admin-dashboard') : redirect('/dashboard')) : (Auth::user()->role != 'admin' ? redirect('/no/oversikt') : redirect('/no/admin-dashbord'));
        }
        $page = Page::where('id', '3')->first();
        $data = json_decode($page->page_body);
        $review_list = [];
        $customer_reviews = [];
        $consultant_reviews = [];
        $reviews = Review::get();
        foreach ($reviews as $review) {
            if ($review->type == "CUSTOCON") {
                $user = Customer::where('user_id', $review->sender_id)->with(['profile', 'user'])->first();
                $review['customer'] = $user;
                array_push($customer_reviews, $review);
            } else {
                $user = Consultant::where('user_id', $review->sender_id)->with(['profile', 'user'])->first();
                $review['consultant'] = $user;
                array_push($consultant_reviews, $review);
            }
        }
        if (count($customer_reviews) > 0) {
            if (count($customer_reviews) > 8) {
                $a = array_rand($customer_reviews, 9);
            } elseif (count($customer_reviews) > 1) {
                $a = array_rand($customer_reviews, count($customer_reviews));
            } else {
                $a = ["0"];
            }

            foreach ($a as $index) {
                array_push($review_list, $customer_reviews[$index]);
            }
        }
        if (count($consultant_reviews) > 0) {
            if (count($consultant_reviews) > 8) {
                $b = array_rand($consultant_reviews, 9);
            } elseif (count($consultant_reviews) > 1) {
                $b = array_rand($consultant_reviews, count($consultant_reviews));
            } else {
                $b = ["0"];
            } 

            foreach ($b as $index) {
                array_push($review_list, $consultant_reviews[$index]);
            }
        }
        $review_count = count($review_list);
        
        return view('pages.about_us', compact('data', 'review_list', 'review_count'), [
            'title' => App::getLocale() == 'en' ? $page->meta_title : $page->no_meta_title,
            'description' => App::getLocale() == 'en' ? $page->meta_description : $page->no_meta_description,
        ]);
    }

    public function privacy()
    {
        if (Auth::check()) {
            return App::getLocale() == 'en' ? (Auth::user()->role == 'admin' ? redirect('/admin-dashboard') : redirect('/dashboard')) : (Auth::user()->role != 'admin' ? redirect('/no/oversikt') : redirect('/no/admin-dashbord'));
        }
        $page = Page::where('id', '6')->first();
        $data = json_decode($page->page_body);
        return view('pages.privacy', compact('data'), [
            'title' => App::getLocale() == 'en' ? $page->meta_title : $page->no_meta_title,
            'description' => App::getLocale() == 'en' ? $page->meta_description : $page->no_meta_description,
        ]);
    }

    public function terms_customer()
    {
        if (Auth::check()) {
            return App::getLocale() == 'en' ? (Auth::user()->role == 'admin' ? redirect('/admin-dashboard') : redirect('/dashboard')) : (Auth::user()->role != 'admin' ? redirect('/no/oversikt') : redirect('/no/admin-dashbord'));
        }
        $page = Page::where('id', '5')->first();
        $data = json_decode($page->page_body);
        return view('pages.terms_customer', compact('data'), [
            'title' => App::getLocale() == 'en' ? $page->meta_title : $page->no_meta_title,
            'description' => App::getLocale() == 'en' ? $page->meta_description : $page->no_meta_description,
        ]);
    }

    public function terms_provider()
    {
        if (Auth::check()) {
            return App::getLocale() == 'en' ? (Auth::user()->role == 'admin' ? redirect('/admin-dashboard') : redirect('/dashboard')) : (Auth::user()->role != 'admin' ? redirect('/no/oversikt') : redirect('/no/admin-dashbord'));
        }
        $page = Page::where('id', '9')->first();
        $data = json_decode($page->page_body);
        return view('pages.terms_provider', compact('data'), [
            'title' => App::getLocale() == 'en' ? $page->meta_title : $page->no_meta_title,
            'description' => App::getLocale() == 'en' ? $page->meta_description : $page->no_meta_description,
        ]);
    }

    public function findConsultant()
    {
        if (!Auth::check()) {
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }

        $request = request();
        $requestData = $request->all();

        $consultants = Consultant::with('user', 'profile', 'company', 'plan')->where('user_id', '!=', auth()->user()->id)->whereHas('user', function ($q) {
            $q->where('active', 1);
        })->get();

        foreach ($consultants as $consultantItem) {
            $education = Education::where('consultant_id', $consultantItem->id)->first();
            if (!empty($education)) {
                $consultantItem->education_degree = $education->degree;
            }
        }
        $countries = [];
        $profiles = Profile::get();
        $search = [
            'name' => 'null',
            'category' => 'All',
            'price' => 'Default',
            'status' => 'All',
            'country' => 'All'
        ];
        return view('member.find_consultant', compact('consultants', 'countries', 'search'), [
            'title' => App::getLocale() == 'en' ? 'Find Consultant' : 'Finn Konsulent',
            'description' => '',
            'active' => ''
        ]);
    }

    public function findConsultantSearch(Request $request)
    {
        if (!Auth::check()) {
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        $requestData = $request->all();
        $educationFilter = $requestData['education'] ?? '';
        $tempConsultants = null;
        if ($request->category != "All") {
            $tempConsultants = Consultant::where('user_id', '!=', auth()->user()->id)->whereHas('profile', function ($q) use ($request) {
                $q->where('profession', $request->category);
            })->whereHas('user', function ($q) {
                $q->where('active', 1);
            })->orderBy('hourly_rate', $request->price == 'low-high' ? 'asc' : 'desc')->with('user', 'profile', 'company', 'plan')->get();
            if ($request->status != 'All') { //AC -> category + status + price
                $tempConsultants = Consultant::where('user_id', '!=', auth()->user()->id)->whereHas('profile', function ($q) use ($request) {
                    $q->where('profession', $request->category);
                })->whereHas('user', function ($q) use ($request) {
                    if ($request->status != 'busy') {
                        $q->where('active', 1)->where('status', $request->status);
                    } else {
                        $q->where('active', 1)->where('status', 'In a chat')->orWhere('status', 'In a call')->orWhere('status', 'In a Video call');
                    }
                })->orderBy('hourly_rate', $request->price == 'low-high' ? 'asc' : 'desc')->with('user', 'profile', 'company')->get();
                if ($request->country != 'All') { //AD -> category + status + country + price
                    $tempConsultants = Consultant::where('user_id', '!=', auth()->user()->id)->whereHas('profile', function ($q) use ($request) {
                        $q->where('profession', $request->category)->where('country', $request->country);
                    })->whereHas('user', function ($q) use ($request) {
                        if ($request->status != 'busy') {
                            $q->where('active', 1)->where('status', $request->status);
                        } else {
                            $q->where('active', 1)->where('status', 'In a chat')->orWhere('status', 'In a call')->orWhere('status', 'In a Video call');
                        }
                    })->orderBy('hourly_rate', $request->price == 'low-high' ? 'asc' : 'desc')->with('user', 'profile', 'company')->get();
                    if ($request->name != 'null') { // ADE -> category + status + country + name + price
                        $tempConsultants = Consultant::where('user_id', '!=', auth()->user()->id)->whereHas('profile', function ($q) use ($request) {
                            $q->where('profession', $request->category)->where('country', $request->country);
                        })->whereHas('user', function ($q) use ($request) {
                            if ($request->status != 'busy') {
                                $q->where('active', 1)->where('status', $request->status)->where('first_name', 'LIKE', '%' . $request->name . '%')->orWhere('last_name', 'LIKE', '%' . $request->name . '%');
                            } else {
                                $q->where('active', 1)->where('status', 'In a chat')->orWhere('status', 'In a call')->orWhere('status', 'In a Video call')->where('first_name', 'LIKE', '%' . $request->name . '%')->orWhere('last_name', 'LIKE', '%' . $request->name . '%');
                            }
                        })->orderBy('hourly_rate', $request->price == 'low-high' ? 'asc' : 'desc')->with('user', 'profile', 'company')->get();
                    }
                } else { //AE -> category + status + name + price
                    if ($request->name != 'null') {
                        $tempConsultants = Consultant::where('user_id', '!=', auth()->user()->id)->whereHas('profile', function ($q) use ($request) {
                            $q->where('profession', $request->category);
                        })->whereHas('user', function ($q) use ($request) {
                            if ($request->status != 'busy') {
                                $q->where('active', 1)->where('status', $request->status)->where('first_name', 'LIKE', '%' . $request->name . '%')->orWhere('last_name', 'LIKE', '%' . $request->name . '%');
                            } else {
                                $q->where('active', 1)->where('status', 'In a chat')->orWhere('status', 'In a call')->orWhere('status', 'In a Video call')->where('first_name', 'LIKE', '%' . $request->name . '%')->orWhere('last_name', 'LIKE', '%' . $request->name . '%');
                            }
                        })->orderBy('hourly_rate', $request->price == 'low-high' ? 'asc' : 'desc')->with('user', 'profile', 'company')->get();
                    }
                }
            } else {
                if ($request->country != 'All') { //AD -> category + country + price
                    $tempConsultants = Consultant::where('user_id', '!=', auth()->user()->id)->whereHas('profile', function ($q) use ($request) {
                        $q->where('profession', $request->category)->where('country', $request->country);
                    })->whereHas('user', function ($q) {
                        $q->where('active', 1);
                    })->orderBy('hourly_rate', $request->price == 'low-high' ? 'asc' : 'desc')->with('user', 'profile', 'company')->get();
                    if ($request->name != 'null') { // ADE -> category + country + name + price
                        $tempConsultants = Consultant::where('user_id', '!=', auth()->user()->id)->whereHas('profile', function ($q) use ($request) {
                            $q->where('profession', $request->category)->where('country', $request->country);
                        })->whereHas('user', function ($q) use ($request) {
                            $q->where('active', 1)->where('first_name', 'LIKE', '%' . $request->name . '%')->orWhere('last_name', 'LIKE', '%' . $request->name . '%');
                        })->orderBy('hourly_rate', $request->price == 'low-high' ? 'asc' : 'desc')->with('user', 'profile', 'company')->get();
                    }
                } else { // category + name + price
                    if ($request->name != 'null') { //AE
                        $tempConsultants = Consultant::where('user_id', '!=', auth()->user()->id)->whereHas('profile', function ($q) use ($request) {
                            $q->where('profession', $request->category);
                        })->whereHas('user', function ($q) use ($request) {
                            $q->where('active', 1)->where('first_name', 'LIKE', '%' . $request->name . '%')->orWhere('last_name', 'LIKE', '%' . $request->name . '%');
                        })->orderBy('hourly_rate', $request->price == 'low-high' ? 'asc' : 'desc')->with('user', 'profile', 'company')->get();
                    }
                }
            }
        } else {
            $tempConsultants = Consultant::where('user_id', '!=', auth()->user()->id)->whereHas('user', function ($q) {
                $q->where('active', 1);
            })->orderBy('hourly_rate', $request->price == 'low-high' ? 'asc' : 'desc')->with('user', 'profile', 'company', 'plan')->get();
            if ($request->status != 'All') { //AC -> status + price
                $tempConsultants = Consultant::where('user_id', '!=', auth()->user()->id)->whereHas('user', function ($q) use ($request) {
                    if ($request->status != 'busy') {
                        $q->where('active', 1)->where('status', $request->status);
                    } else {
                        $q->where('active', 1)->where('status', 'In a chat')->orWhere('status', 'In a call')->orWhere('status', 'In a Video call');
                    }
                })->orderBy('hourly_rate', $request->price == 'low-high' ? 'asc' : 'desc')->with('user', 'profile', 'company')->get();
                if ($request->country != 'All') { //AD -> status + country + price
                    $tempConsultants = Consultant::where('user_id', '!=', auth()->user()->id)->whereHas('profile', function ($q) use ($request) {
                        $q->where('country', $request->country);
                    })->whereHas('user', function ($q) use ($request) {
                        if ($request->status != 'busy') {
                            $q->where('active', 1)->where('status', $request->status);
                        } else {
                            $q->where('active', 1)->where('status', 'In a chat')->orWhere('status', 'In a call')->orWhere('status', 'In a Video call');
                        }
                    })->orderBy('hourly_rate', $request->price == 'low-high' ? 'asc' : 'desc')->with('user', 'profile', 'company')->get();
                    if ($request->name != 'null') { // ADE -> status + country + name + price
                        $tempConsultants = Consultant::where('user_id', '!=', auth()->user()->id)->whereHas('profile', function ($q) use ($request) {
                            $q->where('country', $request->country);
                        })->whereHas('user', function ($q) use ($request) {
                            if ($request->status != 'busy') {
                                $q->where('active', 1)->where('status', $request->status)->where('first_name', 'LIKE', '%' . $request->name . '%')->orWhere('last_name', 'LIKE', '%' . $request->name . '%');
                            } else {
                                $q->where('active', 1)->where('status', 'In a chat')->orWhere('status', 'In a call')->orWhere('status', 'In a Video call')->where('first_name', 'LIKE', '%' . $request->name . '%')->orWhere('last_name', 'LIKE', '%' . $request->name . '%');
                            }
                        })->orderBy('hourly_rate', $request->price == 'low-high' ? 'asc' : 'desc')->with('user', 'profile', 'company')->get();
                    }
                } else { //AE -> status + name + price
                    if ($request->name != 'null') {
                        $tempConsultants = Consultant::where('user_id', '!=', auth()->user()->id)->whereHas('user', function ($q) use ($request) {
                            if ($request->status != 'busy') {
                                $q->where('active', 1)->where('status', $request->status)->where('first_name', 'LIKE', '%' . $request->name . '%')->orWhere('last_name', 'LIKE', '%' . $request->name . '%');
                            } else {
                                $q->where('active', 1)->where('status', 'In a chat')->orWhere('status', 'In a call')->orWhere('status', 'In a Video call')->where('first_name', 'LIKE', '%' . $request->name . '%')->orWhere('last_name', 'LIKE', '%' . $request->name . '%');
                            }
                        })->orderBy('hourly_rate', $request->price == 'low-high' ? 'asc' : 'desc')->with('user', 'profile', 'company')->get();
                    }
                }
            } else {
                if ($request->country != 'All') { //AD -> country + price
                    $tempConsultants = Consultant::where('user_id', '!=', auth()->user()->id)->whereHas('profile', function ($q) use ($request) {
                        $q->where('country', $request->country);
                    })->whereHas('user', function ($q) {
                        $q->where('active', 1);
                    })->orderBy('hourly_rate', $request->price == 'low-high' ? 'asc' : 'desc')->with('user', 'profile', 'company')->get();
                    if ($request->name != 'null') { // ADE -> country + name + price
                        $tempConsultants = Consultant::where('user_id', '!=', auth()->user()->id)->whereHas('profile', function ($q) use ($request) {
                            $q->where('country', $request->country);
                        })->whereHas('user', function ($q) use ($request) {
                            $q->where('active', 1)->where('first_name', 'LIKE', '%' . $request->name . '%')->orWhere('last_name', 'LIKE', '%' . $request->name . '%');
                        })->orderBy('hourly_rate', $request->price == 'low-high' ? 'asc' : 'desc')->with('user', 'profile', 'company')->get();
                    }
                } else { // name + price
                    if ($request->name != 'null') { //AE
                        $tempConsultants = Consultant::where('user_id', '!=', auth()->user()->id)->whereHas('user', function ($q) use ($request) {
                            $q->where('active', 1)->where('first_name', 'LIKE', '%' . $request->name . '%')->orWhere('last_name', 'LIKE', '%' . $request->name . '%');
                        })->orderBy('hourly_rate', $request->price == 'low-high' ? 'asc' : 'desc')->with('user', 'profile', 'company', 'plan')->get();
                    }
                }
            }
        }

        $countries = [];
        $profiles = Profile::get();
        $consultants = [];
                
        foreach ($tempConsultants as $key => $consultantItem) {
            $education = Education::where('consultant_id', $consultantItem->id)->first();
            $consultantItem->education_degree = $education->degree ?? '';
            
            $addRowintoResults = false;
            if ($educationFilter == 'All') {
                $addRowintoResults = true;
            } else { // need to set filter on education
                if (!empty($educationFilter) and !empty($consultantItem->education_degree)) { // only with degree must be returned
                    $addRowintoResults = true;
                }
                if (empty($educationFilter) and empty($consultantItem->education_degree)) { // only withOUT degree must be returned
                    $addRowintoResults = true;
                }
            }
            if ($addRowintoResults) {
                $consultants[] = $consultantItem;
            }
        }

        foreach ($profiles as $profile) {
            if (!in_array($profile->country, $countries)) {
                array_push($countries, $profile->country);
            }
        }
        $search = [
            'name' => $request->name,
            'category' => $request->category,
            'education' => $request->education,
            'price' => $request->price,
            'status' => $request->status,
            'country' => $request->country
        ];

        return view('member.find_consultant', compact('consultants', 'countries', 'search'), [
            'title' => App::getLocale() == 'en' ? 'Find Consultant' : 'Finn Konsulent',
            'description' => '',
            'active' => ''
        ]);
    }

    public function unique_multidim_array($array, $key)
    {
        $temp_array = array();
        $i = 0;
        $key_array = array();

        foreach ($array as $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i] = $val[$key];
                $temp_array[$i] = $val;
            }
            $i++;
        }
        return $temp_array;
    }
    public function dashboard()
    {
        if (!Auth::check()) {
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        if (Auth::user()->role == "consultant") {
            $user_info = Consultant::where('user_id', Auth::user()->id)->first();
            $dt = new DateTime;
            $today_start = clone $dt->setTime(0, 0, 0);
            $today_end = $dt->setTime(23, 59, 59);
            $transactions = Transactions::where('receiver_id', $user_info->id)->where('created_at', '>=', $today_start)->where('created_at', '<=', $today_end)->get();
            $total_amount = 0;
            foreach ($transactions as $transaction) {
                $total_amount += $transaction->amount;
            }
            $earning = $total_amount;

            $recent_sessions = [];
            $sessions = Session::where('consultant_id', $user_info->id)->orWhere('customer_id', Auth::user()->id)->latest('created_at')->take(5)->get();
            foreach ($sessions as $session) {
                if ($session->type == 'CUSTOCON') {
                    $customer = Customer::where('user_id', $session->customer_id)->with('profile', 'user')->first();
                    if($customer)
                        array_push($recent_sessions, $customer);
                } else {
                    if ($session->customer_id == Auth::user()->id) {
                        $consultant = Consultant::where('id', $session->consultant_id)->with('profile', 'user', 'company')->first();
                    } else if ($session->consultant_id == $user_info->id) {
                        $consultant = Consultant::where('user_id', $session->customer_id)->with('profile', 'user', 'company')->first();
                    }
                    array_push($recent_sessions, $consultant);
                }
            }
            $recent_sessions = $this->unique_multidim_array($recent_sessions,'user_id');
            $recommended_consultants = Consultant::where('id', '!=', $user_info->id)->whereHas('user', function($q) {
                $q->where('active', 1);
            })->with('profile', 'user', 'company', 'plan')->orderBy('rate', 'desc')->take(5)->get();
            $count_sessions = count($this->unique_multidim_array($recent_sessions, 'user_id'));
            $count_consultants = Consultant::where('id', '!=', $user_info->id)->whereHas('user', function ($q) {
                $q->where('active', 1);
            })->with('profile', 'user', 'company')->orderBy('rate', 'desc')->take(5)->count();
        } else if (Auth::user()->role == "customer") {
            $sessions = Session::where('customer_id', Auth::user()->id)->latest('created_at')->take(5)->get();
            $recent_sessions = [];
            foreach ($sessions as $session) {
                $consultant = Consultant::where('id', $session->consultant_id)->with('profile', 'user', 'company')->first();
                if($consultant)
                    array_push($recent_sessions, $consultant);
            }
            $recent_sessions = $this->unique_multidim_array($recent_sessions,'user_id');
            $recommended_consultants = Consultant::whereHas('user', function($q) {
                $q->where('active', 1);
            })->with('profile', 'user', 'company', 'plan')->orderBy('rate', 'desc')->take(5)->get();
            $count_sessions = count($this->unique_multidim_array($recent_sessions, 'user_id'));
            $count_consultants = Consultant::whereHas('user', function ($q) {
                $q->where('active', 1);
            })->with('profile', 'user', 'company')->orderBy('rate', 'desc')->take(5)->count();
            $earning = 0;
        }
        $categories = Categories::get();
        return view('member.dashboard', compact('count_sessions', 'count_consultants', 'earning', 'categories', 'recent_sessions', 'recommended_consultants'), [
            'title' => App::getLocale() == 'en' ? 'Dashboard' : 'Oversikt',
            'description' => '',
            'active' => '0'
        ]);
    }

    public function session()
    {
        if (!Auth::check()) {
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }

        $single = 0;
        $consultants = Consultant::whereHas('user', function ($q) {
            $q->where('active', 1);
        })->with('user', 'profile', 'company')->get();
        $customers = Customer::whereHas('user', function ($q) {
            $q->where('active', 1);
        })->with('user', 'profile')->get();

        if (Auth::user()->role == 'consultant') {
            $missedNotifications = MissedNotification
                ::getByReceiverId(Auth::user()->id)
                ->select('sender_id', DB::raw('count(*) as sender_total'))
                ->groupBy('sender_id')
                ->get()
                ->toArray();
            \Session::put('missedNotifications', $missedNotifications);

            $authConsultant = Consultant::where('user_id', Auth::user()->id)->with('profile', 'user')->first();
            $contactedUsers = [];
            $channels = TwilioChannels::get();
            $vatPercent = 0;
            foreach ($channels as $channel) {
                if ($channel->consultant_id === $authConsultant->user_id) {
                    if ($channel->direction === 'con-con') {
                        $user = Consultant::where('user_id', $channel->customer_id)->with('profile', 'company', 'user')->first();

                        $user->sender_total = 0;
                        foreach ($missedNotifications as $nextMissedNotification) {
                            if ($nextMissedNotification['sender_id'] == (int)$user->user_id) {
                                $user->sender_total = $nextMissedNotification['sender_total'];
                            }
                        }
                        $vatPercent =  getVatPercent($user->profile, $authConsultant->profile);
                        array_push($contactedUsers, $user);
                    } else {
                        $user = Customer::where('user_id', $channel->customer_id)->with('profile', 'company', 'user')->first();

                        $user->sender_total = 0;
                        foreach ($missedNotifications as $nextMissedNotification) {
                            if ($nextMissedNotification['sender_id'] == (int)$user->user_id) {
                                $user->sender_total = $nextMissedNotification['sender_total'];
                            }
                        }
                        $vatPercent =  getVatPercent($user->profile, $authConsultant->profile);
                        array_push($contactedUsers, $user);
                    }
                } else if ($channel->customer_id === $authConsultant->user_id) {
                    $consultant = Consultant::where('user_id', $channel->consultant_id)->whereHas('user', function ($q) {
                        $q->where('active', 1);
                    })->with('user', 'profile', 'company')->first();
                    $consultant->sender_total = 0;
                    foreach ($missedNotifications as $nextMissedNotification) {
                        if ($nextMissedNotification['sender_id'] == (int)$consultant->user_id) {
                            $consultant->sender_total = $nextMissedNotification['sender_total'];
                        }
                    }
                    $vatPercent =  getVatPercent($consultant->profile, $authConsultant->profile);
                    array_push($contactedUsers, $consultant);
                }
            }
            return view('member.consultantchat', compact('customers', 'consultants', 'authConsultant', 'single', 'contactedUsers', 'vatPercent'), [
                'title' => App::getLocale() == 'en' ? 'My Sessions' : 'Mine møter',
                'description' => '',
                'active' => '1'
            ]);
        } else {
            $missedNotifications = MissedNotification
                ::getByReceiverId(Auth::user()->id)
                ->select('sender_id', DB::raw('count(*) as sender_total'))
                ->groupBy('sender_id')
                ->get()
                ->toArray();
            \Session::put('missedNotifications', $missedNotifications);

            $authCustomer = Customer::where('user_id', Auth::user()->id)->with('profile', 'user')->first();
            $contactedConsultants = [];
            $channels = TwilioChannels::where('customer_id', Auth::user()->id)->get();
            $vatPercent = 0;
            foreach ($channels as $channel) {
                if ($channel->customer_id === $authCustomer->user_id) {
                    $consultant = Consultant::where('user_id', $channel->consultant_id)->whereHas('user', function ($q) {
                        $q->where('active', 1);
                    })->with('user', 'profile', 'company')->first();
                    $consultant->sender_total = 0;
                    foreach ($missedNotifications as $nextMissedNotification) {
                        if ($nextMissedNotification['sender_id'] == (int)$consultant->user_id) {
                            $consultant->sender_total = $nextMissedNotification['sender_total'];
                        }
                    }
                    $vatPercent =  getVatPercent($consultant->profile, $authCustomer->profile);
                    array_push($contactedConsultants, $consultant);
                }
            }

            return view('member.customerchat', compact('consultants', 'customers', 'authCustomer', 'single', 'contactedConsultants', 'vatPercent'), [
                'title' => App::getLocale() == 'en' ? 'My Sessions' : 'Mine møter',
                'description' => '',
                'active' => '1'
            ]);
        }
    }
    public function singleSession(Request $request)
    {
        if (!Auth::check()) {
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }

        $single = $request->id;

        $missedNotifications = MissedNotification
            ::getByReceiverId(Auth::user()->id)
            ->select('sender_id', DB::raw('count(*) as sender_total'))
            ->groupBy('sender_id')
            ->get()
            ->toArray();

        //        \Log::info(  varDump($single, ' -1 singleSession $single::') );
        //        \Log::info(  varDump(Auth::user()->id, ' -1 singleSession LOGGED USER Auth::user()->id::') );
        //        \Log::info(  varDump($missedNotifications, ' -1 singleSession missedNotifications::') );

        $consultants = Consultant::whereHas('user', function ($q) {
            $q->where('active', 1);
        })->with('user', 'profile', 'company')->get();
        $customers = Customer::whereHas('user', function ($q) {
            $q->where('active', 1);
        })->with('user', 'profile')->get();

        if (Auth::user()->role == 'consultant') {
            $authConsultant = Consultant::where('user_id', Auth::user()->id)->with('profile', 'user')->first();
            $contactedUsers = [];
            $channels = TwilioChannels::get();
            foreach ($channels as $channel) {
                if ($channel->consultant_id === $authConsultant->user_id) {
                    if ($channel->direction === 'con-con') {
                        $user = Consultant::where('user_id', $channel->customer_id)->with('user', 'profile')->first();
                        array_push($contactedUsers, $user);
                    } else {
                        $user = Customer::where('user_id', $channel->customer_id)->with('user', 'profile')->first();
                        array_push($contactedUsers, $user);
                    }
                } else if ($channel->customer_id === $authConsultant->user_id) {
                    $consultant = Consultant::where('user_id', $channel->consultant_id)->with('user', 'profile')->first();
                    array_push($contactedUsers, $consultant);
                }
            }
            return view('member.consultantchat', compact('customers', 'consultants', 'authConsultant', 'single', 'contactedUsers'), [
                'title' => App::getLocale() == 'en' ? 'My Sessions' : 'Mine møter',
                'description' => '',
                'active' => '1'
            ]);
        } else {
            $authCustomer = Customer::where('user_id', Auth::user()->id)->with('profile', 'user')->first();
            $contactedConsultants = [];
            $channels = TwilioChannels::where('customer_id', Auth::user()->id)->get();
            $vatPercent = 0;
            foreach ($channels as $channel) {
                if ($channel->customer_id === $authCustomer->user_id) {
                    $consultant = Consultant::where('user_id', $channel->consultant_id)->with('user', 'profile')->first();
                    $vatPercent =  getVatPercent($consultant->profile, $authCustomer->profile);
                    array_push($contactedConsultants, $consultant);
                }
            }

            return view('member.customerchat', compact('consultants', 'customers', 'authCustomer', 'single', 'contactedConsultants', 'vatPercent'), [
                'title' => App::getLocale() == 'en' ? 'My Sessions' : 'Mine møter',
                'description' => '',
                'active' => '1'
            ]);
        }
    }

    public function wallet()
    {
        if (!Auth::check()) {
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        $cur_balance = Auth::user()->balance;
        $transactions = ChargingTransactions::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        $search = [
            'start' => 'null',
            'end' => 'null',
            'type' => 'null'
        ];
        $auth_user = [];
        if (auth()->user()->role == 'consultant') {
            $auth_user = Consultant::where('user_id', auth()->user()->id)->with('profile')->first();
        } else {
            $auth_user = Customer::where('user_id', auth()->user()->id)->with('profile')->first();
        }
        $currency = $auth_user->currency ? $auth_user->currency : 'NOK';
        $credits = [
            ["id" => 'card1', 'amount' => $currency == 'NOK' ? 100 : 10],
            ["id" => 'card2', 'amount' => $currency == 'NOK' ? 200 : 20],
            ["id" => 'card3', 'amount' => $currency == 'NOK' ? 300 : 30],
            ["id" => 'card4', 'amount' => $currency == 'NOK' ? 500 : 50],
            ["id" => 'card5', 'amount' => $currency == 'NOK' ? 1000 : 100],
            ["id" => 'card6', 'amount' => $currency == 'NOK' ? 2000 : 200],
            ["id" => 'card7', 'amount' => $currency == 'NOK' ? 5000 : 500],
            ["id" => 'card8', 'amount' => 0]
        ];

        return view('member.wallet', [
            'title' => App::getLocale() == 'en' ? 'My Wallet' : 'Min lommebok',
            'description' => '',
            'active' => '2',
            'transactions' => $transactions,
            'balance' => $cur_balance,
            'currency' => $currency,
            'is_popup' => 'false',
            'amount' => '3',
            'credits' => $credits,
            'search' => $search
        ]);
    }
    public function walletSearch(Request $request)
    {
        if (!Auth::check()) {
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        $cur_balance = Auth::user()->balance;

        if ($request->start != 'null') {
            $startDate_array = explode("/", $request->input('start'));
            $startDate = "$startDate_array[2]-$startDate_array[0]-$startDate_array[1]" . " 00:00:00";
            $transactions = ChargingTransactions::where('user_id', Auth::user()->id)->where('created_at', '>=', $startDate)->orderBy('created_at', 'desc')->get();
            if ($request->end != 'null') {
                $endDate_array = explode("/", $request->input('end'));
                $endDate = "$endDate_array[2]-$endDate_array[0]-$endDate_array[1]" . " 23:59:59";
                $transactions = ChargingTransactions::where('user_id', Auth::user()->id)->whereBetween('created_at', [$startDate, $endDate])->orderBy('created_at', 'desc')->get();
                if ($request->type != 'null') {
                    $transactions = ChargingTransactions::where('user_id', Auth::user()->id)
                        ->whereBetween('created_at', [$startDate, $endDate])
                        ->where(function ($q) use ($request) {
                            if ($request->type != "Klarna") {
                                $q->where('type', '!=', 'Klarna');
                            } else {
                                $q->where('type', 'Klarna');
                            }
                        })->orderBy('created_at', 'desc')->get();
                }
            } else {
                if ($request->type != 'null') {
                    $transactions = ChargingTransactions::where('user_id', Auth::user()->id)
                        ->where('created_at', '>=', $startDate)
                        ->where(function ($q) use ($request) {
                            if ($request->type != "Klarna") {
                                $q->where('type', '!=', 'Klarna');
                            } else {
                                $q->where('type', 'Klarna');
                            }
                        })->orderBy('created_at', 'desc')->get();
                }
            }
        } else if ($request->end != 'null') {
            $endDate_array = explode("/", $request->input('end'));
            $endDate = "$endDate_array[2]-$endDate_array[0]-$endDate_array[1]" . " 23:59:59";
            $transactions = ChargingTransactions::where('user_id', Auth::user()->id)->where('created_at', '<=', $endDate)->orderBy('created_at', 'desc')->get();
            if ($request->type != 'null') {
                $transactions = ChargingTransactions::where('user_id', Auth::user()->id)
                    ->where('created_at', '<=', $endDate)
                    ->where(function ($q) use ($request) {
                        if ($request->type != "Klarna") {
                            $q->where('type', '!=', 'Klarna');
                        } else {
                            $q->where('type', 'Klarna');
                        }
                    })->orderBy('created_at', 'desc')->get();
            }
        } else if ($request->type != 'null') {
            $transactions = ChargingTransactions::where('user_id', Auth::user()->id)
                ->where(function ($q) use ($request) {
                    if ($request->type != "Klarna") {
                        $q->where('type', '!=', 'Klarna');
                    } else {
                        $q->where('type', 'Klarna');
                    }
                })->orderBy('created_at', 'desc')->get();
        } else {
            $transactions = ChargingTransactions::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        }
        $search = [
            'start' => $request->start,
            'end' => $request->end,
            'type' => $request->type
        ];
        $auth_user = [];
        if (auth()->user()->role == 'consultant') {
            $auth_user = Consultant::where('user_id', auth()->user()->id)->with('profile')->first();
        } else {
            $auth_user = Customer::where('user_id', auth()->user()->id)->with('profile')->first();
        }
        $currency = $auth_user->currency ? $auth_user->currency : 'NOK';
        $credits = [
            ["id" => 'card1', 'amount' => $currency == 'NOK' ? 100 : 10],
            ["id" => 'card2', 'amount' => $currency == 'NOK' ? 200 : 20],
            ["id" => 'card3', 'amount' => $currency == 'NOK' ? 300 : 30],
            ["id" => 'card4', 'amount' => $currency == 'NOK' ? 500 : 50],
            ["id" => 'card5', 'amount' => $currency == 'NOK' ? 1000 : 100],
            ["id" => 'card6', 'amount' => $currency == 'NOK' ? 2000 : 200],
            ["id" => 'card7', 'amount' => $currency == 'NOK' ? 5000 : 500],
            ["id" => 'card8', 'amount' => 0]
        ];

        return view('member.wallet', [
            'title' => App::getLocale() == 'en' ? 'My Wallet' : 'Min lommebok',
            'description' => '',
            'active' => '2',
            'transactions' => $transactions,
            'balance' => $cur_balance,
            'currency' => $currency,
            'is_popup' => 'false',
            'amount' => '3',
            'credits' => $credits,
            'search' => $search
        ]);
    }

    public function transactions()
    {
        if (!Auth::check()) {
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        $transactions = [];
        $consultants = [];
        $consultantIds = [];
        if (Auth::user()->role == 'customer') {
            $transaction_list = Transactions::where('payer_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
            foreach ($transaction_list as $transaction) {
                $consultant = Consultant::where('id', $transaction->receiver_id)->with(['profile', 'user'])->first();
                if (!in_array($consultant->user->id, $consultantIds)) {
                    array_push($consultantIds, $consultant->user->id);
                    array_push($consultants, $consultant);
                }
                $transaction['consultant'] = $consultant;
                $transaction['status_label'] = Transactions::getStatusLabel($transaction->status);
                array_push($transactions, $transaction);
            }
        } else {
            $consultant = Consultant::where('user_id', Auth::user()->id)->first();
            $spendings = Transactions::where('payer_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
            $earnings = Transactions::where('receiver_id', $consultant->id)->orderBy('created_at', 'desc')->get();
            foreach ($spendings as $spend) {
                $spend['consultant'] = Consultant::where('id', $spend->receiver_id)->with(['profile', 'user'])->first();
                if (!in_array($spend['consultant']->user->id, $consultantIds)) {
                    array_push($consultantIds, $spend['consultant']->user->id);
                    array_push($consultants, $spend['consultant']);
                }
                $transaction['status_label'] = Transactions::getStatusLabel($spend->status);
                array_push($transactions, $transaction);
            }
            foreach ($earnings as $earning) {
                $earning['customer'] = Customer::where('user_id', $earning->payer_id)->with(['profile', 'user'])->first();
                if (!in_array($earning['customer']->user->id, $consultantIds)) {
                    array_push($consultantIds, $earning['customer']->user->id);
                    array_push($consultants, $earning['customer']);
                }
                if (!isset($earning['customer'])) {
                    $earning['consultant'] = Consultant::where('user_id', $earning->payer_id)->with(['profile', 'user'])->first();
                    if (!in_array($earning['consultant']->user->id, $consultantIds)) {
                        array_push($consultantIds, $earning['consultant']->user->id);
                        array_push($consultants, $earning['consultant']);
                    }
                }
                array_push($transactions, $earning);
            }
        }
        $search = [
            'name' => 'null',
            'consultant' => 'All',
            'date' => 'null',
            'type' => 'All'
        ];
        return view('member.transaction', [
            'title' => App::getLocale() == 'en' ? 'My Transactions' : 'Transaksjonene mine',
            'title' => '',
            'description' => '',
            'active' => '3',
            'transactions' => $transactions,
            'consultants' => $consultants,
            'search' => $search
        ]);
    }
    public function findObjectById($id, $array)
    {
        foreach ($array as $element) {
            if ($id == $element->id) {
                return $element;
            }
        }
        return false;
    }
    // Transaction Search fields should consider 'ALL' status
    public function transactionSearch(Request $request)
    {
        if (!Auth::check()) {
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        $consultants = [];
        $consultantIds = [];
        if (Auth::user()->role == 'customer') {
            if (isset($request->name) && $request->name != 'null') {
                $transactions = [];
                $transaction_list = Transactions::where('payer_id', Auth::user()->id)
                    ->where('transaction_id', 'LIKE', '%' . $request->name . '%')->orderBy('created_at', 'desc')->get();
                foreach ($transaction_list as $transaction) {
                    $consultant = Consultant::where('id', $transaction->receiver_id)->with(['profile', 'user'])->first();
                    if (!in_array($consultant->id, $consultantIds)) {
                        array_push($consultantIds, $consultant->id);
                        array_push($consultants, $consultant);
                    }
                    $transaction['consultant'] = $consultant;
                    $transaction['status_label'] = Transactions::getStatusLabel($transaction->status);
                    array_push($transactions, $transaction);
                }

                if ($request->consultant != 'null') {
                    $transaction_list = Transactions::where('payer_id', Auth::user()->id)
                        ->where('transaction_id', 'LIKE', '%' . $request->name . '%')
                        ->where('receiver_id', $request->consultant)->orderBy('created_at', 'desc')->get();
                    $transactions = [];
                    foreach ($transaction_list as $transaction) {
                        $consultant = Consultant::where('id', $transaction->receiver_id)->with(['profile', 'user'])->first();
                        if (!in_array($consultant->id, $consultantIds)) {
                            array_push($consultantIds, $consultant->id);
                            array_push($consultants, $consultant);
                        }
                        $transaction['consultant'] = $consultant;
                        $transaction['status_label'] = Transactions::getStatusLabel($transaction->status);
                        array_push($transactions, $transaction);
                    }

                    if ($request->date != 'null') {
                        $date_array = explode("/", $request->input('date'));
                        $date = "$date_array[2]-$date_array[0]-$date_array[1]" . " 00:00:00";
                        $transaction_list = Transactions::where('payer_id', Auth::user()->id)
                            ->where('transaction_id', 'LIKE', '%' . $request->name . '%')
                            ->where('created_at', '<=', $date)
                            ->where('receiver_id', $request->consultant)->orderBy('created_at', 'desc')->get();
                        $transactions = [];
                        foreach ($transaction_list as $transaction) {
                            $consultant = Consultant::where('id', $transaction->receiver_id)->with(['profile', 'user'])->first();
                            if (!in_array($consultant->id, $consultantIds)) {
                                array_push($consultantIds, $consultant->id);
                                array_push($consultants, $consultant);
                            }
                            $transaction['consultant'] = $consultant;
                            $transaction['status_label'] = Transactions::getStatusLabel($transaction->status);
                            array_push($transactions, $transaction);
                        }
                    }
                } else if ($request->date != 'null') {
                    $date_array = explode("/", $request->input('date'));
                    $date = "$date_array[2]-$date_array[0]-$date_array[1]" . " 00:00:00";
                    $transaction_list = Transactions::where('payer_id', Auth::user()->id)
                        ->where('transaction_id', 'LIKE', '%' . $request->name . '%')
                        ->where('created_at', ',=', $date)->orderBy('created_at', 'desc')->get();
                    $transactions = [];
                    foreach ($transaction_list as $transaction) {
                        $consultant = Consultant::where('id', $transaction->receiver_id)->with(['profile', 'user'])->first();
                        if (!in_array($consultant->id, $consultantIds)) {
                            array_push($consultantIds, $consultant->id);
                            array_push($consultants, $consultant);
                        }
                        $transaction['consultant'] = $consultant;
                        $transaction['status_label'] = Transactions::getStatusLabel($transaction->status);
                        array_push($transactions, $transaction);
                    }
                }
            } else if ($request->consultant != 'null') {
                $transactions = [];
                $transaction_list = Transactions::where('payer_id', Auth::user()->id)
                    ->where('receiver_id', $request->consultant)->orderBy('created_at', 'desc')->get();
                foreach ($transaction_list as $transaction) {
                    $consultant = Consultant::where('id', $transaction->receiver_id)->with(['profile', 'user'])->first();
                    if (!in_array($consultant->id, $consultantIds)) {
                        array_push($consultantIds, $consultant->id);
                        array_push($consultants, $consultant);
                    }

                    $transaction['consultant'] = $consultant;
                    $transaction['status_label'] = Transactions::getStatusLabel($transaction->status);
                    array_push($transactions, $transaction);
                }

                if ($request->date != 'null') {
                    $date_array = explode("/", $request->input('date'));
                    $date = "$date_array[2]-$date_array[0]-$date_array[1]" . " 00:00:00";
                    $transaction_list = Transactions::where('payer_id', Auth::user()->id)
                        ->where('created_at', '<=', $date)
                        ->where('receiver_id', $request->consultant)->orderBy('created_at', 'desc')->get();
                    $transactions = [];
                    foreach ($transaction_list as $transaction) {
                        $consultant = Consultant::where('id', $transaction->receiver_id)->with(['profile', 'user'])->first();
                        if (!in_array($consultant->id, $consultantIds)) {
                            array_push($consultantIds, $consultant->id);
                            array_push($consultants, $consultant);
                        }
                        $transaction['consultant'] = $consultant;
                        $transaction['status_label'] = Transactions::getStatusLabel($transaction->status);
                        array_push($transactions, $transaction);
                    }
                }
            } else if ($request->date != 'null') {
                $transactions = [];
                $date_array = explode("/", $request->input('date'));
                $date = "$date_array[2]-$date_array[0]-$date_array[1]" . " 00:00:00";
                $transaction_list = Transactions::where('payer_id', Auth::user()->id)
                    ->where('created_at', '<=', $date)->orderBy('created_at', 'desc')->get();

                foreach ($transaction_list as $transaction) {
                    $consultant = Consultant::where('id', $transaction->receiver_id)->with(['profile', 'user'])->first();
                    if (!in_array($consultant->id, $consultantIds)) {
                        array_push($consultantIds, $consultant->id);
                        array_push($consultants, $consultant);
                    }
                    $transaction['consultant'] = $consultant;
                    $transaction['status_label'] = Transactions::getStatusLabel($transaction->status);
                    array_push($transactions, $transaction);
                }
            } else {
                $transactions = [];
                $transaction_list = Transactions::where('payer_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();

                foreach ($transaction_list as $transaction) {
                    $consultant = Consultant::where('id', $transaction->receiver_id)->with(['profile', 'user'])->first();
                    if (!in_array($consultant->id, $consultantIds)) {
                        array_push($consultantIds, $consultant->id);
                        array_push($consultants, $consultant);
                    }
                    $transaction['consultant'] = $consultant;
                    $transaction['status_label'] = Transactions::getStatusLabel($transaction->status);
                    array_push($transactions, $transaction);
                }
            }
        } else {
            if ($request->type != 'All') {
                if ($request->type == "earn") {
                    $transactions = [];
                    $consultant = Consultant::where('user_id', Auth::user()->id)->first();
                    $earnings = Transactions::where('receiver_id', $consultant->id)->orderBy('created_at', 'desc')->get();
                    foreach ($earnings as $earning) {
                        $earning['customer'] = Customer::where('user_id', $earning->payer_id)->with(['profile', 'user'])->first();
                        if (!in_array($earning['customer']->user->id, $consultantIds)) {
                            array_push($consultantIds, $earning['customer']->user->id);
                            array_push($consultants, $earning['customer']);
                        }
                        if (!isset($earning['customer'])) {
                            $earning['consultant'] = Consultant::where('user_id', $earning->payer_id)->with(['profile', 'user'])->first();
                            if (!in_array($earning['consultant']->user->id, $consultantIds)) {
                                array_push($consultantIds, $earning['consultant']->user->id);
                                array_push($consultants, $earning['consultant']);
                            }
                        }
                        array_push($transactions, $earning);
                    }
                    if (isset($request->name) && $request->name != 'null') {
                        $transactions = [];
                        $consultant = Consultant::where('user_id', Auth::user()->id)->first();
                        $earnings = Transactions::where('receiver_id', $consultant->id)->where('transaction_id', 'LIKE', '%' . $request->name . '%')->orderBy('created_at', 'desc')->get();
                        foreach ($earnings as $earning) {
                            $earning['customer'] = Customer::where('user_id', $earning->payer_id)->with(['profile', 'user'])->first();
                            if (!in_array($earning['customer']->user->id, $consultantIds)) {
                                array_push($consultantIds, $earning['customer']->user->id);
                                array_push($consultants, $earning['customer']);
                            }
                            if (!isset($earning['customer'])) {
                                $earning['consultant'] = Consultant::where('user_id', $earning->payer_id)->with(['profile', 'user'])->first();
                                if (!in_array($earning['consultant']->user->id, $consultantIds)) {
                                    array_push($consultantIds, $earning['consultant']->user->id);
                                    array_push($consultants, $earning['consultant']);
                                }
                            }
                            array_push($transactions, $earning);
                        }
                        if ($request->consultant != 'null') {
                            $transactions = [];
                            $consultant = Consultant::where('id', $request->consultant)->first();
                            $earnings = Transactions::where('receiver_id', $request->consultant)->where('transaction_id', 'LIKE', '%' . $request->name . '%')->orderBy('created_at', 'desc')->get();
                            foreach ($earnings as $earning) {
                                $earning['customer'] = Customer::where('user_id', $earning->payer_id)->with(['profile', 'user'])->first();
                                if (!in_array($earning['customer']->user->id, $consultantIds)) {
                                    array_push($consultantIds, $earning['customer']->user->id);
                                    array_push($consultants, $earning['customer']);
                                }
                                if (!isset($earning['customer'])) {
                                    $earning['consultant'] = Consultant::where('user_id', $earning->payer_id)->with(['profile', 'user'])->first();
                                    if (!in_array($earning['consultant']->user->id, $consultantIds)) {
                                        array_push($consultantIds, $earning['consultant']->user->id);
                                        array_push($consultants, $earning['consultant']);
                                    }
                                }
                                array_push($transactions, $earning);
                            }
                            if ($request->date != 'null') {
                                $date_array = explode("/", $request->input('date'));
                                $date = "$date_array[2]-$date_array[0]-$date_array[1]" . " 00:00:00";
                                $transactions = [];
                                $consultant = Consultant::where('id', $request->consultant)->first();
                                $earnings = Transactions::where('receiver_id', $request->consultant)->where('transaction_id', 'LIKE', '%' . $request->name . '%')->where('created_at', '<=', $date)->orderBy('created_at', 'desc')->get();
                                foreach ($earnings as $earning) {
                                    $earning['customer'] = Customer::where('user_id', $earning->payer_id)->with(['profile', 'user'])->first();
                                    if (!in_array($earning['customer']->user->id, $consultantIds)) {
                                        array_push($consultantIds, $earning['customer']->user->id);
                                        array_push($consultants, $earning['customer']);
                                    }
                                    if (!isset($earning['customer'])) {
                                        $earning['consultant'] = Consultant::where('user_id', $earning->payer_id)->with(['profile', 'user'])->first();
                                        if (!in_array($earning['consultant']->user->id, $consultantIds)) {
                                            array_push($consultantIds, $earning['consultant']->user->id);
                                            array_push($consultants, $earning['consultant']);
                                        }
                                    }
                                    array_push($transactions, $earning);
                                }
                            }
                        } else if ($request->date != 'null') {
                            $transactions = [];
                            $date_array = explode("/", $request->input('date'));
                            $date = "$date_array[2]-$date_array[0]-$date_array[1]" . " 00:00:00";
                            $consultant = Consultant::where('user_id', Auth::user()->id)->first();
                            $earnings = Transactions::where('receiver_id', $consultant->id)->where('transaction_id', 'LIKE', '%' . $request->name . '%')->where('created_at', '<=', $date)->orderBy('created_at', 'desc')->get();
                            foreach ($earnings as $earning) {
                                $earning['customer'] = Customer::where('user_id', $earning->payer_id)->with(['profile', 'user'])->first();
                                if (!in_array($earning['customer']->user->id, $consultantIds)) {
                                    array_push($consultantIds, $earning['customer']->user->id);
                                    array_push($consultants, $earning['customer']);
                                }
                                if (!isset($earning['customer'])) {
                                    $earning['consultant'] = Consultant::where('user_id', $earning->payer_id)->with(['profile', 'user'])->first();
                                    if (!in_array($earning['consultant']->user->id, $consultantIds)) {
                                        array_push($consultantIds, $earning['consultant']->user->id);
                                        array_push($consultants, $earning['consultant']);
                                    }
                                }
                                array_push($transactions, $earning);
                            }
                        }
                    } else if ($request->consultant != 'null') {
                        $transactions = [];
                        $consultant = Consultant::where('id', $request->consultant)->first();
                        $earnings = Transactions::where('payer_id', $request->consultant)->orderBy('created_at', 'desc')->get();
                        foreach ($earnings as $earning) {
                            $earning['customer'] = Customer::where('user_id', $earning->payer_id)->with(['profile', 'user'])->first();
                            if (!in_array($earning['customer']->user->id, $consultantIds)) {
                                array_push($consultantIds, $earning['customer']->user->id);
                                array_push($consultants, $earning['customer']);
                            }
                            if (!isset($earning['customer'])) {
                                $earning['consultant'] = Consultant::where('user_id', $earning->payer_id)->with(['profile', 'user'])->first();
                                if (!in_array($earning['customer']->user->id, $consultantIds)) {
                                    array_push($consultantIds, $earning['consultant']->user->id);
                                    array_push($consultants, $earning['consultant']);
                                }
                            }
                            array_push($transactions, $earning);
                        }
                        if ($request->date != 'null') {
                            $transactions = [];
                            $date_array = explode("/", $request->input('date'));
                            $date = "$date_array[2]-$date_array[0]-$date_array[1]" . " 00:00:00";
                            $consultant = Consultant::where('id', $request->consultant)->first();
                            $earnings = Transactions::where('payer_id', $request->consultant)->where('created_at', '<=', $date)->orderBy('created_at', 'desc')->get();
                            foreach ($earnings as $earning) {
                                $earning['customer'] = Customer::where('user_id', $earning->payer_id)->with(['profile', 'user'])->first();
                                if (!in_array($earning['customer']->user->id, $consultantIds)) {
                                    array_push($consultantIds, $earning['customer']->user->id);
                                    array_push($consultants, $earning['customer']);
                                }
                                if (!isset($earning['customer'])) {
                                    $earning['consultant'] = Consultant::where('user_id', $earning->payer_id)->with(['profile', 'user'])->first();
                                    if (!in_array($earning['customer']->user->id, $consultantIds)) {
                                        array_push($consultantIds, $earning['consultant']->user->id);
                                        array_push($consultants, $earning['consultant']);
                                    }
                                }
                                array_push($transactions, $earning);
                            }
                        }
                    } else if ($request->date != 'null') {
                        $transactions = [];
                        $date_array = explode("/", $request->input('date'));
                        $date = "$date_array[2]-$date_array[0]-$date_array[1]" . " 00:00:00";
                        $consultant = Consultant::where('user_id', Auth::user()->id)->first();
                        $earnings = Transactions::where('receiver_id', $consultant->id)->where('created_at', '<=', $date)->orderBy('created_at', 'desc')->get();
                        foreach ($earnings as $earning) {
                            $earning['customer'] = Customer::where('user_id', $earning->payer_id)->with(['profile', 'user'])->first();
                            if (!in_array($consultant->user->id, $consultantIds)) {
                                array_push($consultantIds, $earning['customer']->user->id);
                                array_push($consultants, $earning['customer']);
                            }
                            if (!isset($earning['customer'])) {
                                $earning['consultant'] = Consultant::where('user_id', $earning->payer_id)->with(['profile', 'user'])->first();
                                if (!in_array($consultant->user->id, $consultantIds)) {
                                    array_push($consultantIds, $earning['consultant']->user->id);
                                    array_push($consultants, $earning['consultant']);
                                }
                            }
                            array_push($transactions, $earning);
                        }
                    }
                } else {
                    $transactions = [];
                    $consultant = Consultant::where('user_id', Auth::user()->id)->first();
                    $spendings = Transactions::where('payer_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
                    foreach ($spendings as $spend) {
                        $spend['consultant'] = Consultant::where('id', $spend->receiver_id)->with(['profile', 'user'])->first();
                        if (!in_array($spend['consultant']->user->id, $consultantIds)) {
                            array_push($consultantIds, $spend['consultant']->user->id);
                            array_push($consultants, $spend['consultant']);
                        }
                        $transaction['status_label'] = Transactions::getStatusLabel($spend->status);
                        array_push($transactions, $transaction);
                    }
                    if (isset($request->name) && $request->name != 'null') {
                        $transactions = [];
                        $consultant = Consultant::where('user_id', Auth::user()->id)->first();
                        $spendings = Transactions::where('payer_id', Auth::user()->id)->where('transaction_id', 'LIKE', '%' . $request->name . '%')->orderBy('created_at', 'desc')->get();
                        foreach ($spendings as $spend) {
                            $spend['consultant'] = Consultant::where('id', $spend->receiver_id)->with(['profile', 'user'])->first();
                            if (!in_array($spend['consultant']->user->id, $consultantIds)) {
                                array_push($consultantIds, $spend['consultant']->user->id);
                                array_push($consultants, $spend['consultant']);
                            }
                            $transaction['status_label'] = Transactions::getStatusLabel($spend->status);
                            array_push($transactions, $transaction);
                        }
                        if ($request->consultant != 'null') {
                            $transactions = [];
                            $consultant = Consultant::where('id', $request->consultant)->first();
                            $spendings = Transactions::where('payer_id', $consultant->user_id)->where('transaction_id', 'LIKE', '%' . $request->name . '%')->orderBy('created_at', 'desc')->get();
                            foreach ($spendings as $spend) {
                                $spend['consultant'] = Consultant::where('id', $spend->receiver_id)->with(['profile', 'user'])->first();
                                if (!in_array($spend['consultant']->user->id, $consultantIds)) {
                                    array_push($consultantIds, $spend['consultant']->user->id);
                                    array_push($consultants, $spend['consultant']);
                                }
                                $transaction['status_label'] = Transactions::getStatusLabel($spend->status);
                                array_push($transactions, $transaction);
                            }
                            if ($request->date != 'null') {
                                $date_array = explode("/", $request->input('date'));
                                $date = "$date_array[2]-$date_array[0]-$date_array[1]" . " 00:00:00";
                                $transactions = [];
                                $consultant = Consultant::where('id', $request->consultant)->first();
                                $spendings = Transactions::where('payer_id', $consultant->user_id)->where('transaction_id', 'LIKE', '%' . $request->name . '%')->where('created_at', '<=', $date)->orderBy('created_at', 'desc')->get();
                                foreach ($spendings as $spend) {
                                    $spend['consultant'] = Consultant::where('id', $spend->receiver_id)->with(['profile', 'user'])->first();
                                    if (!in_array($spend['consultant']->user->id, $consultantIds)) {
                                        array_push($consultantIds, $spend['consultant']->user->id);
                                        array_push($consultants, $spend['consultant']);
                                    }
                                    $transaction['status_label'] = Transactions::getStatusLabel($spend->status);
                                    array_push($transactions, $transaction);
                                }
                            }
                        } else if ($request->date != 'null') {
                            $transactions = [];
                            $date_array = explode("/", $request->input('date'));
                            $date = "$date_array[2]-$date_array[0]-$date_array[1]" . " 00:00:00";
                            $consultant = Consultant::where('user_id', Auth::user()->id)->first();
                            $spendings = Transactions::where('payer_id', Auth::user()->id)->where('transaction_id', 'LIKE', '%' . $request->name . '%')->where('created_at', '<=', $date)->orderBy('created_at', 'desc')->get();
                            foreach ($spendings as $spend) {
                                $spend['consultant'] = Consultant::where('id', $spend->receiver_id)->with(['profile', 'user'])->first();
                                if (!in_array($spend['consultant']->user->id, $consultantIds)) {
                                    array_push($consultantIds, $spend['consultant']->user->id);
                                    array_push($consultants, $spend['consultant']);
                                }
                                $transaction['status_label'] = Transactions::getStatusLabel($spend->status);
                                array_push($transactions, $transaction);
                            }
                        }
                    } else if ($request->consultant != 'null') {
                        $$transactions = [];
                        $consultant = Consultant::where('id', $request->consultant)->first();
                        $spendings = Transactions::where('payer_id', $consultant->user_id)->orderBy('created_at', 'desc')->get();
                        foreach ($spendings as $spend) {
                            $spend['consultant'] = Consultant::where('id', $spend->receiver_id)->with(['profile', 'user'])->first();
                            if (!in_array($spend['consultant']->user->id, $consultantIds)) {
                                array_push($consultantIds, $spend['consultant']->user->id);
                                array_push($consultants, $spend['consultant']);
                            }
                            $transaction['status_label'] = Transactions::getStatusLabel($spend->status);
                            array_push($transactions, $transaction);
                        }
                        if ($request->date != 'null') {
                            $transactions = [];
                            $date_array = explode("/", $request->input('date'));
                            $date = "$date_array[2]-$date_array[0]-$date_array[1]" . " 00:00:00";
                            $consultant = Consultant::where('id', $request->consultant)->first();
                            $spendings = Transactions::where('payer_id', $consultant->user_id)->where('created_at', '<=', $date)->orderBy('created_at', 'desc')->get();
                            foreach ($spendings as $spend) {
                                $spend['consultant'] = Consultant::where('id', $spend->receiver_id)->with(['profile', 'user'])->first();
                                if (!in_array($spend['consultant']->user->id, $consultantIds)) {
                                    array_push($consultantIds, $spend['consultant']->user->id);
                                    array_push($consultants, $spend['consultant']);
                                }
                                $transaction['status_label'] = Transactions::getStatusLabel($spend->status);
                                array_push($transactions, $transaction);
                            }
                        }
                    } else if ($request->date != 'null') {
                        $transactions = [];
                        $date_array = explode("/", $request->input('date'));
                        $date = "$date_array[2]-$date_array[0]-$date_array[1]" . " 00:00:00";
                        $consultant = Consultant::where('user_id', Auth::user()->id)->first();
                        $spendings = Transactions::where('payer_id', Auth::user()->id)->where('created_at', '<=', $date)->orderBy('created_at', 'desc')->get();
                        foreach ($spendings as $spend) {
                            $spend['consultant'] = Consultant::where('id', $spend->receiver_id)->with(['profile', 'user'])->first();
                            if (!in_array($spend['consultant']->user->id, $consultantIds)) {
                                array_push($consultantIds, $spend['consultant']->user->id);
                                array_push($consultants, $spend['consultant']);
                            }
                            array_push($transactions, $spend);
                        }
                    }
                }
            } else {
                $transactions = [];
                $consultant = Consultant::where('user_id', Auth::user()->id)->first();
                $spendings = Transactions::where('payer_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
                $earnings = Transactions::where('receiver_id', $consultant->id)->orderBy('created_at', 'desc')->get();
                foreach ($spendings as $spend) {
                    $spend['consultant'] = Consultant::where('id', $spend->receiver_id)->with(['profile', 'user'])->first();
                    if (!in_array($spend['consultant']->user->id, $consultantIds)) {
                        array_push($consultantIds, $spend['consultant']->user->id);
                        array_push($consultants, $spend['consultant']);
                    }
                    $transaction['status_label'] = Transactions::getStatusLabel($spend->status);
                    array_push($transactions, $transaction);
                }
                foreach ($earnings as $earning) {
                    $earning['customer'] = Customer::where('user_id', $earning->payer_id)->with(['profile', 'user'])->first();
                    if (!in_array($earning['customer']->user->id, $consultantIds)) {
                        array_push($consultantIds, $earning['customer']->user->id);
                        array_push($consultants, $earning['customer']);
                    }
                    if (!isset($earning['customer'])) {
                        $earning['consultant'] = Consultant::where('user_id', $earning->payer_id)->with(['profile', 'user'])->first();
                        if (!in_array($earning['consultant']->user->id, $consultantIds)) {
                            array_push($consultantIds, $earning['consultant']->user->id);
                            array_push($consultants, $earning['consultant']);
                        }
                    }
                    array_push($transactions, $earning);
                }
                if (isset($request->name) && $request->name != 'null') {
                    $transactions = [];
                    $consultant = Consultant::where('user_id', Auth::user()->id)->first();
                    $spendings = Transactions::where('payer_id', Auth::user()->id)->where('transaction_id', 'LIKE', '%' . $request->name . '%')->orderBy('created_at', 'desc')->get();
                    $earnings = Transactions::where('receiver_id', $consultant->id)->where('transaction_id', 'LIKE', '%' . $request->name . '%')->orderBy('created_at', 'desc')->get();
                    foreach ($spendings as $spend) {
                        $spend['consultant'] = Consultant::where('id', $spend->receiver_id)->with(['profile', 'user'])->first();
                        if (!in_array($spend['consultant']->user->id, $consultantIds)) {
                            array_push($consultantIds, $spend['consultant']->user->id);
                            array_push($consultants, $spend['consultant']);
                        }
                        $transaction['status_label'] = Transactions::getStatusLabel($spend->status);
                        array_push($transactions, $transaction);
                    }
                    foreach ($earnings as $earning) {
                        $earning['customer'] = Customer::where('user_id', $earning->payer_id)->with(['profile', 'user'])->first();
                        if (!in_array($earning['customer']->user->id, $consultantIds)) {
                            array_push($consultantIds, $earning['customer']->user->id);
                            array_push($consultants, $earning['customer']);
                        }
                        if (!isset($earning['customer'])) {
                            $earning['consultant'] = Consultant::where('user_id', $earning->payer_id)->with(['profile', 'user'])->first();
                            if (!in_array($earning['consultant']->user->id, $consultantIds)) {
                                array_push($consultantIds, $earning['consultant']->user->id);
                                array_push($consultants, $earning['consultant']);
                            }
                        }
                        array_push($transactions, $earning);
                    }
                    if ($request->consultant != 'null') {
                        $transactions = [];
                        $consultant = Consultant::where('id', $request->consultant)->first();
                        $spendings = Transactions::where('payer_id', $consultant->user_id)->where('transaction_id', 'LIKE', '%' . $request->name . '%')->orderBy('created_at', 'desc')->get();
                        $earnings = Transactions::where('receiver_id', $request->consultant)->where('transaction_id', 'LIKE', '%' . $request->name . '%')->orderBy('created_at', 'desc')->get();
                        foreach ($spendings as $spend) {
                            $spend['consultant'] = Consultant::where('id', $spend->receiver_id)->with(['profile', 'user'])->first();
                            if (!in_array($spend['consultant']->user->id, $consultantIds)) {
                                array_push($consultantIds, $spend['consultant']->user->id);
                                array_push($consultants, $spend['consultant']);
                            }
                            $transaction['status_label'] = Transactions::getStatusLabel($spend->status);
                            array_push($transactions, $transaction);
                        }
                        foreach ($earnings as $earning) {
                            $earning['customer'] = Customer::where('user_id', $earning->payer_id)->with(['profile', 'user'])->first();
                            if (!in_array($earning['customer']->user->id, $consultantIds)) {
                                array_push($consultantIds, $earning['customer']->user->id);
                                array_push($consultants, $earning['customer']);
                            }
                            if (!isset($earning['customer'])) {
                                $earning['consultant'] = Consultant::where('user_id', $earning->payer_id)->with(['profile', 'user'])->first();
                                if (!in_array($earning['consultant']->user->id, $consultantIds)) {
                                    array_push($consultantIds, $earning['consultant']->user->id);
                                    array_push($consultants, $earning['consultant']);
                                }
                            }
                            array_push($transactions, $earning);
                        }
                        if ($request->date != 'null') {
                            $date_array = explode("/", $request->input('date'));
                            $date = "$date_array[2]-$date_array[0]-$date_array[1]" . " 00:00:00";
                            $transactions = [];
                            $consultant = Consultant::where('id', $request->consultant)->first();
                            $spendings = Transactions::where('payer_id', $consultant->user_id)->where('transaction_id', 'LIKE', '%' . $request->name . '%')->where('created_at', '<=', $date)->orderBy('created_at', 'desc')->get();
                            $earnings = Transactions::where('receiver_id', $request->consultant)->where('transaction_id', 'LIKE', '%' . $request->name . '%')->where('created_at', '<=', $date)->orderBy('created_at', 'desc')->get();
                            foreach ($spendings as $spend) {
                                $spend['consultant'] = Consultant::where('id', $spend->receiver_id)->with(['profile', 'user'])->first();
                                if (!in_array($spend['consultant']->user->id, $consultantIds)) {
                                    array_push($consultantIds, $spend['consultant']->user->id);
                                    array_push($consultants, $spend['consultant']);
                                }
                                $transaction['status_label'] = Transactions::getStatusLabel($spend->status);
                                array_push($transactions, $transaction);
                            }
                            foreach ($earnings as $earning) {
                                $earning['customer'] = Customer::where('user_id', $earning->payer_id)->with(['profile', 'user'])->first();
                                if (!in_array($earning['customer']->user->id, $consultantIds)) {
                                    array_push($consultantIds, $earning['customer']->user->id);
                                    array_push($consultants, $earning['customer']);
                                }
                                if (!isset($earning['customer'])) {
                                    $earning['consultant'] = Consultant::where('user_id', $earning->payer_id)->with(['profile', 'user'])->first();
                                    if (!in_array($earning['consultant']->user->id, $consultantIds)) {
                                        array_push($consultantIds, $earning['consultant']->user->id);
                                        array_push($consultants, $earning['consultant']);
                                    }
                                }
                                array_push($transactions, $earning);
                            }
                        }
                    } else if ($request->date != 'null') {
                        $transactions = [];
                        $date_array = explode("/", $request->input('date'));
                        $date = "$date_array[2]-$date_array[0]-$date_array[1]" . " 00:00:00";
                        $consultant = Consultant::where('user_id', Auth::user()->id)->first();
                        $spendings = Transactions::where('payer_id', Auth::user()->id)->where('transaction_id', 'LIKE', '%' . $request->name . '%')->where('created_at', '<=', $date)->orderBy('created_at', 'desc')->get();
                        $earnings = Transactions::where('receiver_id', $consultant->id)->where('transaction_id', 'LIKE', '%' . $request->name . '%')->where('created_at', '<=', $date)->orderBy('created_at', 'desc')->get();
                        foreach ($spendings as $spend) {
                            $spend['consultant'] = Consultant::where('id', $spend->receiver_id)->with(['profile', 'user'])->first();
                            if (!in_array($spend['consultant']->user->id, $consultantIds)) {
                                array_push($consultantIds, $spend['consultant']->user->id);
                            }
                            if (!in_array($spend['consultant']->user->id, $consultantIds)) {
                                array_push($consultantIds, $spend['consultant']->user->id);
                                array_push($consultants, $spend['consultant']);
                            }
                            $transaction['status_label'] = Transactions::getStatusLabel($spend->status);
                            array_push($transactions, $transaction);
                        }
                        foreach ($earnings as $earning) {
                            $earning['customer'] = Customer::where('user_id', $earning->payer_id)->with(['profile', 'user'])->first();
                            if (!in_array($earning['customer']->user->id, $consultantIds)) {
                                array_push($consultantIds, $earning['customer']->user->id);
                                array_push($consultants, $earning['customer']);
                            }
                            if (!isset($earning['customer'])) {
                                $earning['consultant'] = Consultant::where('user_id', $earning->payer_id)->with(['profile', 'user'])->first();
                                if (!in_array($earning['consultant']->user->id, $consultantIds)) {
                                    array_push($consultantIds, $earning['consultant']->user->id);
                                    array_push($consultants, $earning['consultant']);
                                }
                            }
                            array_push($transactions, $earning);
                        }
                    }
                } else if ($request->consultant != 'null') {
                    $$transactions = [];
                    $consultant = Consultant::where('id', $request->consultant)->first();
                    $spendings = Transactions::where('payer_id', $consultant->user_id)->orderBy('created_at', 'desc')->get();
                    $earnings = Transactions::where('receiver_id', $request->consultant)->orderBy('created_at', 'desc')->get();
                    foreach ($spendings as $spend) {
                        $spend['consultant'] = Consultant::where('id', $spend->receiver_id)->with(['profile', 'user'])->first();
                        if (!in_array($spend['consultant']->user->id, $consultantIds)) {
                            array_push($consultantIds, $spend['consultant']->user->id);
                            array_push($consultants, $spend['consultant']);
                        }
                        $transaction['status_label'] = Transactions::getStatusLabel($spend->status);
                        array_push($transactions, $transaction);
                    }
                    foreach ($earnings as $earning) {
                        $earning['customer'] = Customer::where('user_id', $earning->payer_id)->with(['profile', 'user'])->first();
                        if (!in_array($earning['customer']->user->id, $consultantIds)) {
                            array_push($consultantIds, $earning['customer']->user->id);
                            array_push($consultants, $earning['customer']);
                        }
                        if (!isset($earning['customer'])) {
                            if (!in_array($earning['consultant']->user->id, $consultantIds)) {
                                array_push($consultantIds, $earning['consultant']->user->id);
                                array_push($consultants, $earning['consultant']);
                            }
                            $earning['consultant'] = Consultant::where('user_id', $earning->payer_id)->with(['profile', 'user'])->first();
                        }
                        array_push($transactions, $earning);
                    }
                    if ($request->date != 'null') {
                        $transactions = [];
                        $date_array = explode("/", $request->input('date'));
                        $date = "$date_array[2]-$date_array[0]-$date_array[1]" . " 00:00:00";
                        $consultant = Consultant::where('id', $request->consultant)->first();
                        $spendings = Transactions::where('payer_id', $consultant->user_id)->where('created_at', '<=', $date)->orderBy('created_at', 'desc')->get();
                        $earnings = Transactions::where('receiver_id', $request->consultant)->where('created_at', '<=', $date)->orderBy('created_at', 'desc')->get();
                        foreach ($spendings as $spend) {
                            $spend['consultant'] = Consultant::where('id', $spend->receiver_id)->with(['profile', 'user'])->first();
                            if (!in_array($spend['consultant']->user->id, $consultantIds)) {
                                array_push($consultantIds, $spend['consultant']->user->id);
                                array_push($consultants, $spend['consultant']);
                            }
                            $transaction['status_label'] = Transactions::getStatusLabel($spend->status);
                            array_push($transactions, $transaction);
                        }
                        foreach ($earnings as $earning) {
                            $earning['customer'] = Customer::where('user_id', $earning->payer_id)->with(['profile', 'user'])->first();
                            if (!in_array($earning['customer']->user->id, $consultantIds)) {
                                array_push($consultantIds, $earning['consultant']->user->id);
                                array_push($consultants, $earning['consultant']);
                            }
                            if (!isset($earning['customer'])) {
                                $earning['consultant'] = Consultant::where('user_id', $earning->payer_id)->with(['profile', 'user'])->first();
                                if (!in_array($earning['consultant']->user->id, $consultantIds)) {
                                    array_push($consultantIds, $earning['consultant']->user->id);
                                    array_push($consultants, $earning['consultant']);
                                }
                            }
                            array_push($transactions, $earning);
                        }
                    }
                } else if ($request->date != 'null') {
                    $transactions = [];
                    $date_array = explode("/", $request->input('date'));
                    $date = "$date_array[2]-$date_array[0]-$date_array[1]" . " 00:00:00";
                    $consultant = Consultant::where('user_id', Auth::user()->id)->first();
                    $spendings = Transactions::where('payer_id', Auth::user()->id)->where('created_at', '<=', $date)->orderBy('created_at', 'desc')->get();
                    $earnings = Transactions::where('receiver_id', $consultant->id)->where('created_at', '<=', $date)->orderBy('created_at', 'desc')->get();
                    foreach ($spendings as $spend) {
                        $spend['consultant'] = Consultant::where('id', $spend->receiver_id)->with(['profile', 'user'])->first();
                        if (!in_array($spend['consultant']->user->id, $consultantIds)) {
                            array_push($consultantIds, $spend['consultant']->user->id);
                            array_push($consultants, $spend['consultant']);
                        }
                        array_push($transactions, $spend);
                    }
                    foreach ($earnings as $earning) {
                        $earning['customer'] = Customer::where('user_id', $earning->payer_id)->with(['profile', 'user'])->first();
                        if (!in_array($earning['customer']->user->id, $consultantIds)) {
                            array_push($consultantIds, $earning['customer']->user->id);
                            array_push($consultants, $earning['customer']);
                        }
                        if (!isset($earning['customer'])) {
                            $earning['consultant'] = Consultant::where('user_id', $earning->payer_id)->with(['profile', 'user'])->first();
                            if (!in_array($spend['consultant']->user->id, $consultantIds)) {
                                array_push($consultantIds, $earning['consultant']->user->id);
                                array_push($consultants, $earning['consultant']);
                            }
                        }
                        array_push($transactions, $earning);
                    }
                } else {
                    $transactions = [];
                    $consultant = Consultant::where('user_id', Auth::user()->id)->first();
                    $spendings = Transactions::where('payer_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
                    $earnings = Transactions::where('receiver_id', $consultant->id)->orderBy('created_at', 'desc')->get();
                    foreach ($spendings as $spend) {
                        $spend['consultant'] = Consultant::where('id', $spend->receiver_id)->with(['profile', 'user'])->first();
                        if (!in_array($spend['consultant']->user->id, $consultantIds)) {
                            array_push($consultantIds, $spend['consultant']->user->id);
                            array_push($consultants, $spend['consultant']);
                        }
                        array_push($transactions, $spend);
                    }
                    foreach ($earnings as $earning) {
                        $earning['customer'] = Customer::where('user_id', $earning->payer_id)->with(['profile', 'user'])->first();
                        if (!in_array($earning['customer']->user->id, $consultantIds)) {
                            array_push($consultantIds, $earning['customer']->user->id);
                            array_push($consultants, $earning['customer']);
                        }
                        if (!isset($earning['customer'])) {
                            $earning['consultant'] = Consultant::where('user_id', $earning->payer_id)->with(['profile', 'user'])->first();
                            if (!in_array($earning['consultant']->user->id, $consultantIds)) {
                                array_push($consultantIds, $earning['consultant']->user->id);
                                array_push($consultants, $earning['consultant']);
                            }
                        }
                        array_push($transactions, $earning);
                    }
                }
            }
        }

        $search = [
            'name' => $request->name,
            'consultant' => $request->consultant,
            'date' => $request->date,
            'type' => $request->type
        ];
        return view('member.transaction', [
            'title' => App::getLocale() == 'en' ? 'My Transactions' : 'Transaksjonene mine',
            'description' => '',
            'active' => '3',
            'transactions' => $transactions,
            'consultants' => $consultants,
            'search' => $search
        ]);
    }


    public function myPayouts()
    {
        if (!Auth::check()) {
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        if(Auth::user()->role != 'consultant') {
            return redirect('dashboard');
        }
        $start_date = new DateTime('first day of this month');
        //        echo '<pre>$start_date->format(Y)::'.print_r($start_date->format('Y'),true).'</pre>';
        //        echo '<pre>$start_date->format(m)::'.print_r($start_date->format('m'),true).'</pre>';
        $end_date = new DateTime('last day of this month');
        //        echo '<pre>$end_date->format(Y)::'.print_r($end_date->format('Y'),true).'</pre>';
        //        echo '<pre>$end_date->format(m)::'.print_r($end_date->format('m'),true).'</pre>';

        $url = '/my-payouts-search?date_from=' . $start_date->format('m') . '/' . $start_date->format('Y') . '&date_till=' . $end_date->format('m') . '/' . $end_date->format('Y');
        //        echo '<pre>$url::'.print_r($url,true).'</pre>';
        //        die("-1 XXZ");
        return redirect($url);
    }


    public function myPayoutsSearch(Request $request)
    {
        if (!Auth::check()) {
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        if(Auth::user()->role != 'consultant') {
            return redirect('dashboard');
        }
        $metaTitle = App::getLocale() == 'en' ? 'My Payouts' : 'Mine utbetalinger';
        $metaDescription = '';

        $requestData = $request->all();
        // \Log::info('-1 myPayoutsSearch $requestData ::' . print_r($requestData, true));

        $date_from_str = explode('/', $request->date_from);
        $start_from_date = date('Y-m-d', strtotime($date_from_str[1] . "-" . $date_from_str[0] . "-" . "01"));

        $date_till_str = explode('/', $request->date_till);
        $end_till_date = date('Y-m-t', strtotime($date_till_str[1] . "-" . $date_till_str[0] . "-" . "01"));
        $end_time = $end_till_date . ' 23:59:59';

        $search_date_from = date('M, Y', strtotime($date_from_str[1] . "-" . $date_from_str[0] . "-" . "01"));
        $search_date_till = date('M, Y', strtotime($date_till_str[1] . "-" . $date_till_str[0] . "-" . "01"));

        $adminUser = User::find(1);
        $settingsFee = $adminUser->fee ?? 0;

        // \Log::info('-1 $start_from_date ::' . print_r($start_from_date, true));
        // \Log::info('-1 $end_till_date ::' . print_r($end_till_date, true));
        // \Log::info('-3 settingsFee ::' . print_r($settingsFee, true));

        $loggedConsultant = Consultant::where('user_id', Auth::user()->id)->get()->first();
        // \Log::info('-12 loggedConsultant ::' . print_r($loggedConsultant, true));
        $payouts = [];
        $payout_list = Transactions
            ::getByReceiverId($loggedConsultant->id)
            ->getByStatus('U')
            ->select('payer_id', DB::raw('sum(amount) as amount_total, sum(vat_amount) as vat_amount_total, sum(total_amount) as total_amount_total'))
            ->where('created_at', '>=', $start_from_date)
            ->where('created_at', '<=', $end_till_date . " 23:59:59' ")
            ->groupBy('payer_id')
            ->get()
            ->toArray();

        foreach ($payout_list as $payout) {
            $transactionsPeriodTextFromDate = '';
            $transactionsPeriodTextTillDate = '';
            $relatedTransactionsIdText = '';
            $relatedTransactionsIds = '';
            $receiver = Consultant::where('id', $payout['receiver_id'])->with('profile', 'user')->first();

            $relatedTransactions = Transactions
                ::where('receiver_id', $loggedConsultant->id)
                ->getByStatus('U')
                ->where('created_at', '>=', $start_from_date)
                ->where('created_at', '<=', $end_till_date . " 23:59:59' ")
                ->orderBy('created_at', 'asc')
                ->get();
            // \Log::info(varDump(count($relatedTransactions), ' -2 count($relatedTransactions)::'));
            if (count($relatedTransactions) > 0) {
                $transactionsPeriodTextFromDate = $relatedTransactions[0]->created_at->format('Y-m-d');
                $transactionsPeriodTextTillDate = $relatedTransactions[count($relatedTransactions) - 1]->created_at->format('Y-m-d');
                for ($i = 0; $i < count($relatedTransactions); $i++) {
                    // \Log::info(varDump($relatedTransactions[$i]));
                    $relatedTransactionsIdText .= 'GTC-' . $relatedTransactions[$i]->id . ($i < count($relatedTransactions) - 1 ? ', ' : '');
                    $relatedTransactionsIds .= $relatedTransactions[$i]->id . ($i < count($relatedTransactions) - 1 ? ',' : '');
                }
            }

            $payout['date_from'] = $start_from_date;
            $payout['date_till'] = $end_till_date;
            $payout['period_string'] = $start_from_date . ' - ' . $end_till_date;
            $payout['status'] = 'D';
            $payout['status_label'] = 'Draft';
            $payout['invoice_label'] = 'Draft';

            $payout['transactionsPeriodTextFromDate'] = $transactionsPeriodTextFromDate;
            $payout['transactionsPeriodTextTillDate'] = $transactionsPeriodTextTillDate;
            $payout['relatedTransactionsIdText'] = $relatedTransactionsIdText;
            $payout['relatedTransactionsIds'] = $relatedTransactionsIds;

            array_push($payouts, $payout);
        }
        // \Log::info(varDump($payouts, ' -4 $payouts::'));

        $invoices_list = Invoices
            ::getByCreatorId(Auth::user()->id)
            ->where('created_at', '>=', $start_from_date)
            ->where('created_at', '<=', $end_till_date . " 23:59:59' ")
            ->select('*')
            ->orderBy('status')
            ->orderBy('created_at')
            ->get()
            ->map(function ($invoiceItem) {
                $invoiceItem['status_label'] = Invoices::getStatusLabel($invoiceItem->status);
                return $invoiceItem;
            })
            ->all();

//         \Log::info(varDump($invoices_list, ' -123 $invoices_list::'));
        $search = [
            'consultant' => $request->consultant,
            'date_from' => $search_date_from,
            'date_till' => $search_date_till,
        ];
        $tax_percent = 5;

        $today_date             = Carbon::now(config('app.timezone'));
        $background_color       = '#ffffff';
        $font_weight_light      = 'font-weight: 500; ';

        $title_font_size            = '20px';
        $subtitle_font_size         = '16px';
        $content_font_size          = '12px';
        $notes_font_size            = '12px';
        $debugging_border           = '';  // 'border:2px dotted red !important';
        $home_url                   = \Config::get('app.url');
        $invoiceLogoName            = \Config::get('app.invoiceLogoName');
        $invoiceCompanyName         = \Config::get('app.invoiceCompanyName');
        $invoiceCompanyStreet       = \Config::get('app.invoiceCompanyStreet');
        $invoiceCompanyAddress      = \Config::get('app.invoiceCompanyAddress');
        $companySupportEmail        = \Config::get('app.companySupportEmail');
        $companyUrl                 = \Config::get('app.companyUrl');
        $adminUser = User::find(1);
        $settingsFee = $adminUser->fee ?? 0;

        return view('member.my_payouts', compact('payouts', 'invoices_list', 'settingsFee', 'tax_percent', 'search' , 'background_color', 'settingsFee', 'tax_percent', 'today_date', 'font_weight_light', 'title_font_size', 'subtitle_font_size', 'content_font_size', 'notes_font_size', 'debugging_border', 'home_url', 'currency', 'invoiceCompanyName', 'invoiceCompanyStreet', 'invoiceLogoName', 'invoiceCompanyAddress', 'companySupportEmail', 'companyUrl', 'invoiceCreator', 'invoiceCreatorProfile', 'invoiceCreatorCompany' ), ['active' => '4', 'title' => $metaTitle, 'description' => $metaDescription]);
    } // public function mypayoutsSearch(Request $request) {



    public function my_payout_into_pdf($payout_id) {
        $cardInvoice = Invoices::find($payout_id);
        $invoiceCreator = $cardInvoice->creator;

        $invoiceCreatorCustomer = Customer::where('user_id', $invoiceCreator->id)->get()->first();
//        \Log::info('-01 $invoiceCreatorCustomer ::' . print_r($invoiceCreatorCustomer, true));
        $invoiceCreatorProfile = null;
        $invoiceCreatorCompany = null;
        $currency              = 'NOK';
        if(!empty($invoiceCreatorCustomer)) {
            \Log::info('-12 $invoiceCreatorCustomer->profile_id ::' . print_r($invoiceCreatorCustomer->profile_id, true));
            $invoiceCreatorProfile = Profile::where('id', $invoiceCreatorCustomer->profile_id)->get()->first();
            $invoiceCreatorCompany = Company::where('id', $invoiceCreatorCustomer->company_id)->get()->first();
            $currency              = $invoiceCreatorCustomer->currency;

        }

//        \Log::info('-1 $invoiceCreator ::' . print_r($invoiceCreator, true));
//        \Log::info('-1 $invoiceCreatorProfile ::' . print_r($invoiceCreatorProfile, true));
//        \Log::info('-4 $invoiceCreatorCompany ::' . print_r($invoiceCreatorCompany, true));

        $today_date             = Carbon::now(config('app.timezone'));
        $background_color       = '#ffffff';
        $font_weight_light      = 'font-weight: 500; ';

        $title_font_size            = '20px';
        $subtitle_font_size         = '16px';
        $content_font_size          = '12px';
        $notes_font_size            = '12px';
        $debugging_border           = '';  // 'border:2px dotted red !important';
        $home_url                   = \Config::get('app.url');
        $invoiceLogoName            = \Config::get('app.invoiceLogoName');
        $invoiceCompanyName         = \Config::get('app.invoiceCompanyName');
        $invoiceCompanyStreet       = \Config::get('app.invoiceCompanyStreet');
        $invoiceCompanyAddress      = \Config::get('app.invoiceCompanyAddress');
        $companySupportEmail        = \Config::get('app.companySupportEmail');
        $companyUrl                 = \Config::get('app.companyUrl');
        $adminUser = User::find(1);
        $settingsFee = $adminUser->fee ?? 0;
        $tax_percent = 5;
        $invoice_id= $payout_id;

        return view('member.payout_card' , compact('cardInvoice', 'background_color', 'settingsFee', 'tax_percent', 'today_date', 'font_weight_light', 'title_font_size', 'subtitle_font_size', 'content_font_size', 'notes_font_size', 'debugging_border', 'home_url', 'currency', 'invoiceCompanyName', 'invoiceCompanyStreet', 'invoiceLogoName', 'invoiceCompanyAddress', 'companySupportEmail', 'companyUrl', 'invoiceCreator', 'invoiceCreatorProfile', 'invoiceCreatorCompany', 'invoice_id') );

       // Route::get('/my-payout-into-pdf/{payout_id}', [ 'uses' => 'Client\PagesController@my_payout_into_pdf' ] );
    } // public function my_payout_into_pdf($payout_id) {

    public function generate_payment_receipt_pdf_by_content(Request $request)
    {
        $requestData = $request->all();
        // echo '<pre>generate_payment_receipt_pdf_by_content requestData::'.print_r($requestData,true).'</pre>';

        $invoice_id                = ! empty($requestData['pdf_content_hidden_invoice_id']) ? $requestData['pdf_content_hidden_invoice_id'] : '';
        $pdf_content_hidden_action = ! empty($requestData['pdf_content_hidden_action']) ? $requestData['pdf_content_hidden_action'] : '';
//            \Log::info('-1generate_payment_receipt_pdf_by_content $pdf_content_hidden_action ::' . print_r($pdf_content_hidden_action,
//                    true));
        $viewParamsArray = [];//$appParamsForJSArray = $this->getAppParameters(true, ['csrf_token'], []);

        $retArray = Invoices::generatePaymentReceiptPdfByContent($invoice_id, $viewParamsArray, $requestData,
            $pdf_content_hidden_action);
        if ($pdf_content_hidden_action == 'upload') {
            \Response::download($retArray['save_to_file'], $retArray['filename_to_save'],
                array('Content-Type: application/octet-stream', 'Content-Length: pdf'));

            return response()->download($retArray['save_to_file'],
                $retArray['filename_to_save'])->deleteFileAfterSend(true);
        }

        return Redirect::back();
    }


    public function get_invoice_data($invoice_id)
    {
//       \Log::info('-1 get_invoice_data invoice_id ::' . print_r($invoice_id, true));
        $tax_percent = 5;
        $adminUser = User::find(1);
        $settingsFee = $adminUser->fee ?? 0;


        $invoice = Invoices::find($invoice_id);
        $invoiceCreator = $invoice->creator;

        $invoiceCreatorCustomer = Customer::where('user_id', $invoiceCreator->id)->get()->first();
//        \Log::info('-01 $invoiceCreatorCustomer ::' . print_r($invoiceCreatorCustomer, true));
        $invoiceCreatorProfile = null;
        $invoiceCreatorCompany = null;
        $currency              = 'NOK';
        if(!empty($invoiceCreatorCustomer)) {
//            \Log::info('-12 $invoiceCreatorCustomer->profile_id ::' . print_r($invoiceCreatorCustomer->profile_id, true));
            $invoiceCreatorProfile = Profile::where('id', $invoiceCreatorCustomer->profile_id)->get()->first();
            $invoiceCreatorCompany = Company::where('id', $invoiceCreatorCustomer->company_id)->get()->first();
            $currency              = $invoiceCreatorCustomer->currency;
        }


        $invoice->status_label = Invoices::getStatusLabel($invoice->status );
        $invoice->total_formatted = formatMoney($invoice->total );
        $invoice->total_minus_vat_formatted = formatMoney($invoice->total - $invoice->vat );
        $invoice->mva_tax_percent_sum_formatted = formatMoney($invoice->total / 100 * $tax_percent );
        $invoice->settings_fee_percent_sum_formatted = formatMoney($invoice->total / 100 * $settingsFee );
        $invoice->invoice_created_at_formatted = $invoice->created_at->format('Y-m-d');
        $invoice->first_name_last_name = $invoiceCreator->first_name . ' ' . $invoiceCreator->last_name;
        $invoice->invoice_creator_profile_street = $invoiceCreatorProfile->street;
        $invoice->invoice_creator_profile_zip_code_region = $invoiceCreatorProfile->zip_code . ' ' . $invoiceCreatorProfile->region;
        $invoice->invoice_creator_status = $invoice->status;
//        \Log::info(  varDump($invoiceCreatorCompany, ' -1 $invoiceCreatorCompany::') );
        $invoice->invoice_creator_company_bank_account = $invoiceCreatorCompany->bank_account;
        return response()->json(['invoice'=> $invoice, 'currency'=> $currency]);
    }


    public function memberCreateInvoice(Request $request)
    {

        $requestData = $request->all();
        $id = $requestData['id'];
        // \Log::info('-1 memberCreateInvoice $requestData ::' . print_r($requestData, true));

        DB::beginTransaction();
        try {
            $adminUser = User::find(1);
            $settingsFee = $adminUser->fee ?? 0;

            $refTransactions = [];
            $relatedTransactionsIds       = preg_split('/,/', $requestData["relatedTransactionsIds"]);
            // \Log::info('-1 memberCreateInvoice $relatedTransactionsIds ::' . print_r($relatedTransactionsIds, true));
            foreach ($relatedTransactionsIds as $next_key => $next_value) {
                if (!empty($next_value)) {
                    $refTransactions[] = $next_value;
                }
            }
            // \Log::info('-5 memberCreateInvoice $refTransactions ::' . print_r($refTransactions, true));

            /*-------------------------------/
            / Stripe Invoice API Integration /
            /-------------------------------*/
            $customer = User::find(Auth::user()->id);
            $consultant = Consultant::where('user_id', Auth::user()->id)->first();
            try {
                $appEnv = strtolower(config('app.env'));
                if ($appEnv == 'local' or $appEnv == 'dev') {
                    $key = config('app.STRIPE_TEST_KEY');
                }
                if ($appEnv == 'production') {
                    $key = config('app.STRIPE_LIVE_KEY');
                }
                $stripe = new StripeClient($key);

                $customer_id = $customer->stripe_cus_id;

                // Create an invoice items
                $stripe->invoiceItems->create([
                    "customer" => $customer_id,
                    "amount" => $requestData["total"] * 100,
                    "currency" => $consultant->currency,
                    "description" => "Consultant Fee"
                ]);

                // Create an invoice in stripe
                $stripe_invoice = $stripe->invoices->create([
                    'customer' => $customer_id,
                    'description' => 'Consultant Fee'
                ]);

                $invoice = new Invoices();
                $invoice->creator_id = Auth::user()->id;
                $invoice->invoice_id = $stripe_invoice->id;
                $invoice->from_date = $requestData["from_date"];
                $invoice->till_date = $requestData["till_date"];
                //data: { "date_from":date_from, "date_till":date_till, 'relatedTransactionsIds' : relatedTransactionsIds, "vat": vat_amount, "amount" : total_amount},
                //$invoice->till_date = $requestData["till_date"]; //
                $invoice->status = 'N';
                $invoice->gtc_fee = $settingsFee;
                $invoice->vat = $requestData["vat"];
                $invoice->total = $requestData["total"];
                $invoice->ref_transactions = json_encode($refTransactions);
                $invoice->save();

                foreach ($relatedTransactionsIds as $relatedTransactionsId) {
                    $transaction = Transactions::find($relatedTransactionsId);
                    if (!empty($transaction)) {
                        $transaction->status = 'I';
                        $transaction->updated_at = Carbon::now(config('app.timezone'));
                        $transaction->save();
                    }
                }
            }
            catch (Exception $err) {
                return response()->json(['message' => $err->getMessage()], 500);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 500);
        }

        return response()->json(true);
    } // public function memberCreateInvoice(Request $request)


    public function profile()
    {
        if (!Auth::check()) {
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        $review_info = null;
        $chart_info = [
            'request_sessions' => ['Jan' => 0, 'Feb' => 0, 'Mar' => 0, 'Apr' => 0, 'May' => 0, 'Jun' => 0, 'Jul' => 0, 'Aug' => 0, 'Sep' => 0, 'Oct' => 0, 'Nov' => 0, 'Dec' => 0],
            'completed_sessions' => ['Jan' => 0, 'Feb' => 0, 'Mar' => 0, 'Apr' => 0, 'May' => 0, 'Jun' => 0, 'Jul' => 0, 'Aug' => 0, 'Sep' => 0, 'Oct' => 0, 'Nov' => 0, 'Dec' => 0],
            'response_rates' => ['Jan' => 0, 'Feb' => 0, 'Mar' => 0, 'Apr' => 0, 'May' => 0, 'Jun' => 0, 'Jul' => 0, 'Aug' => 0, 'Sep' => 0, 'Oct' => 0, 'Nov' => 0, 'Dec' => 0]
        ];
        if (Auth::user()->role == 'consultant') {
            $user_profile = Consultant::where('user_id', Auth::user()->id)->with('user', 'profile', 'company')->first();
            $review_info = Review::where('type', 'CUSTOCON')->where('receiver_id', $user_profile->user_id)->get();
            foreach ($review_info as $review) {
                $customer = Customer::where('user_id', $review->sender_id)->first();
                $review['customer'] = $customer;
            }
            $sessions = Session::where('consultant_id', $user_profile->id)->get();
            $requests = Requests::where('consultant_id', $user_profile->id)->get();
            foreach ($requests as $request) {
                $newDate = date('M d, Y', strtotime($request->created_at));
                $month = explode(" ", $newDate)[0];
                $chart_info['request_sessions'][$month] += 1;
            }
        } else {
            $user_profile = Customer::where('user_id', Auth::user()->id)->with('user', 'profile')->first();
            $sessions = Session::where('customer_id', $user_profile->user_id)->get();
            $review_info = Review::where('type', 'CONTOCUS')->where('receiver_id', $user_profile->user_id)->get();
            foreach ($review_info as $review) {
                $consultant = Consultant::where('user_id', $review->sender_id)->first();
                $review['consultant'] = $consultant;
            }
        }

        foreach ($sessions as $session) {
            $newDate = date('M d, Y', strtotime($session->created_at));
            $month = explode(" ", $newDate)[0];
            $chart_info['completed_sessions'][$month] += 1;
        }

        if (Auth::user()->role == 'consultant') {
            foreach ($chart_info['response_rates'] as $key => $value) {
                if ($chart_info['request_sessions'][$key] != 0) {
                    $chart_info['response_rates'][$key] = $chart_info['completed_sessions'][$key] / $chart_info['request_sessions'][$key] * 100;
                    $chart_info['response_rates'][$key] = round($chart_info['response_rates'][$key], 2);
                }
            }
        }
        $chart_info['no_data'] = count($sessions) > 0 ? false : true;
        $request_type = 'own';
        $plans = Plan::where('user_id', Auth::user()->id)->get();
        $user_id = Auth::user()->id;
        return view('member.profile', compact('user_id', 'chart_info', 'review_info', 'user_profile', 'request_type', 'plans'), [
            'title' => App::getLocale() == 'en' ? 'My Profile' : 'Min profil',
            'description' => '',
            'active' => '5'
        ]);
    }

    public function singleProfile($id)
    {
        $review_info = null;
        $chart_info = [
            'request_sessions' => ['Jan' => 0, 'Feb' => 0, 'Mar' => 0, 'Apr' => 0, 'May' => 0, 'Jun' => 0, 'Jul' => 0, 'Aug' => 0, 'Sep' => 0, 'Oct' => 0, 'Nov' => 0, 'Dec' => 0],
            'completed_sessions' => ['Jan' => 0, 'Feb' => 0, 'Mar' => 0, 'Apr' => 0, 'May' => 0, 'Jun' => 0, 'Jul' => 0, 'Aug' => 0, 'Sep' => 0, 'Oct' => 0, 'Nov' => 0, 'Dec' => 0],
            'response_rates' => ['Jan' => 0, 'Feb' => 0, 'Mar' => 0, 'Apr' => 0, 'May' => 0, 'Jun' => 0, 'Jul' => 0, 'Aug' => 0, 'Sep' => 0, 'Oct' => 0, 'Nov' => 0, 'Dec' => 0]
        ];
        if (User::where('account_id', $id)->exists()) {
            $user = User::where('account_id', $id)->first();
        } else {
            $user = User::where('id', $id)->first();
        }
        if (isset($user)) {
            if ($user->role == 'consultant') {
                $user_profile = Consultant::where('user_id', $user->id)->with('user', 'profile')->first();
                $review_info = Review::where('type', 'CUSTOCON')->where('receiver_id', $user->id)->get();
                foreach ($review_info as $review) {
                    $customer = Customer::where('user_id', $review->sender_id)->first();
                    $review['customer'] = $customer;
                }
                $sessions = Session::where('consultant_id', $user_profile->id)->get();
                $requests = Requests::where('consultant_id', $user_profile->id)->get();
                foreach ($requests as $request) {
                    $newDate = date('M d, Y', strtotime($request->created_at));
                    $month = explode(" ", $newDate)[0];
                    $chart_info['request_sessions'][$month] += 1;
                }
            } else {
                $user_profile = Customer::where('user_id', $user->id)->with('user', 'profile')->first();
                $review_info = Review::where('type', 'CONTOCUS')->where('receiver_id', $user->id)->get();
                foreach ($review_info as $review) {
                    $consultant = Consultant::where('user_id', $review->sender_id)->first();
                    $review['consultant'] = $consultant;
                }
                $sessions = Session::where('customer_id', $user_profile->user_id)->get();
            }
            foreach ($sessions as $session) {
                $newDate = date('M d, Y', strtotime($session->created_at));
                $month = explode(" ", $newDate)[0];
                $chart_info['completed_sessions'][$month] += 1;
            }
            if ($user->role == 'consultant') {
                foreach ($chart_info['response_rates'] as $key => $value) {
                    if ($chart_info['request_sessions'][$key] != 0) {
                        $chart_info['response_rates'][$key] = $chart_info['completed_sessions'][$key] / $chart_info['request_sessions'][$key] * 100;
                        $chart_info['response_rates'][$key] = round($chart_info['response_rates'][$key], 2);
                    }
                }
            }
            $chart_info['no_data'] = count($sessions) > 0 ? false : true;
            $request_type = 'other';
            if (Auth::check()) {
                $user_id = $user->id;
                $plans = Plan::where('user_id', $user->id)->get();
                return view('member.profile', compact('user_id', 'chart_info', 'review_info', 'user_profile', 'request_type', 'plans'), [
                    'title' => App::getLocale() == 'en' ? 'My Profile' : 'Min profil',
                    'description' => '',
                    'active' => '5'
                ]);
            } else {
                return view('pages.profile', compact('chart_info', 'review_info', 'user_profile'), [
                    'title' => App::getLocale() == 'en' ? 'Profile' : 'Profil',
                    'description' => ''
                ]);
            }
        } else {
            return redirect('/');
        }
    }

    public function settings()
    {
        if (!Auth::check()) {
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        if (Auth::user()->role == 'consultant') {
            $consultant = Consultant::where('user_id', Auth::user()->id)->first();
            $education = Education::where('consultant_id', $consultant->id)->get();
        } else {
            $education = null;
        }
        return view('member.settings', compact('education'), [
            'title' => App::getLocale() == 'en' ? 'Settings' : 'Innstillinger',
            'description' => '',
            'active' => '6'
        ]);
    }

    public function memberPrivacy()
    {
        if (!Auth::check()) {
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        $page = Page::where('id', '6')->first();
        $data = json_decode($page->page_body);
        return view('member.privacy', compact('data'), [
            'title' => App::getLocale() == 'en' ? $page->meta_title : $page->no_meta_title,
            'description' => App::getLocale() == 'en' ? $page->meta_description : $page->no_meta_description,
            'active' => ''
        ]);
    }

    public function memberTermsCustomer()
    {
        if (!Auth::check()) {
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        $page = Page::where('id', '5')->first();
        $data = json_decode($page->page_body);
        return view('member.terms_customer', compact('data'), [
            'title' => App::getLocale() == 'en' ? $page->meta_title : $page->no_meta_title,
            'description' => App::getLocale() == 'en' ? $page->meta_description : $page->no_meta_description,
            'active' => ''
        ]);
    }

    public function memberTermsProvider()
    {
        if (!Auth::check()) {
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        $page = Page::where('id', '9')->first();
        $data = json_decode($page->page_body);
        return view('member.terms_provider', compact('data'), [
            'title' => App::getLocale() == 'en' ? $page->meta_title : $page->no_meta_title,
            'description' => App::getLocale() == 'en' ? $page->meta_description : $page->no_meta_description,
            'active' => ''
        ]);
    }

    public function klarna_checkout(Request $request)
    {
        $html_snippet = $request->html_snippet;
        return view('member.klarna_checkout', ['html_snippet' => $html_snippet, 'active' => '1']);
    }

    public function klarna_confirmation(Request $request)
    {
        $sid = $request->sid;
        $merchantId = config('app.KLARNA_MERCHANT_ID', 'PK12126_ebf20e785379');
        $sharedSecret = config('app.KLARNA_SHARED_SECRET', 'eDWpqm3sIuKBi8jq');

        $connector = Connector::create(
            $merchantId,
            $sharedSecret,
            config('app.env') === 'local' ?
                ConnectorInterface::EU_TEST_BASE_URL :
                ConnectorInterface::EU_BASE_URL
        );

        try {
            $order = new OrderInStore($connector, $sid);
            $order->acknowledge();

            $id = $request->uid;
            $amount = $request->amount;
            $cur_balance = 0;
            $user = User::where('id', $id)->first();
            $user->balance += $amount;
            $user->payment_method = 'klarna';
            $user->save();
            $cur_balance = $user->balance;
            $currency = $request->currency;
            $charging_transaction = [
                'user_id' => Auth::user()->id,
                'type' => 'Klarna',
                'amount' => $amount,
                'transaction_id' => $sid,
                'status' => 'success'
            ];
            ChargingTransactions::create($charging_transaction);

            $cur_balance = Auth::user()->balance;
            $currency = Auth::user()->currency != null ? Auth::user()->currency : 'NOK';
            $transactions = ChargingTransactions::where('user_id', Auth::user()->id)->get();
            $credits = [
                ["id" => 'card1', 'amount' => $currency == 'NOK' ? 100 : 10],
                ["id" => 'card2', 'amount' => $currency == 'NOK' ? 200 : 20],
                ["id" => 'card3', 'amount' => $currency == 'NOK' ? 300 : 30],
                ["id" => 'card4', 'amount' => $currency == 'NOK' ? 500 : 50],
                ["id" => 'card5', 'amount' => $currency == 'NOK' ? 1000 : 100],
                ["id" => 'card6', 'amount' => $currency == 'NOK' ? 2000 : 200],
                ["id" => 'card7', 'amount' => $currency == 'NOK' ? 5000 : 500],
                ["id" => 'card8', 'amount' => 0]
            ];
            $search = [
                'start' => 'null',
                'end' => 'null',
                'type' => 'null'
            ];
            $auth_user = [];
            if (auth()->user()->role == 'consultant') {
                $auth_user = Consultant::where('user_id', auth()->user()->id)->with('profile')->first();
            } else {
                $auth_user = Customer::where('user_id', auth()->user()->id)->with('profile')->first();
            }
            return view('member.wallet', [
                'title' => App::getLocale() == 'en' ? 'My Wallet' : 'Min lommebok',
                'description' => '',
                'active' => '2',
                'transactions' => $transactions,
                'balance' => $cur_balance,
                'currency' => $currency,
                'is_popup' => 'true',
                'amount' => $amount,
                'credits' => $credits,
                'search' => $search,
                'auth_user' => $auth_user
            ]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function forgotPassword(Request $request)
    {
        return view('auth.forgot-password', ['title' => 'Forgot Password', 'description' => '']);
    }

    public function send_reset_password_request(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $link = URL::route('reset-password', $user->api_token);
            try {
                Mail::to($request->email)->send(new ForgotPassword($link));
            } catch (\Exception $e) {
                // Never reached
                return Redirect::to('/password/forgot')->with('alert-error', 'Enter a valid email address.');
            }
            return Redirect::to('/login')->with('alert-success', 'Please check your email to reset your password.');
        } else {
            return Redirect::to('/password/forgot')->with('alert-error', 'You did not sign in correctly or your account is temporaily disabled.');
        }
    }

    public function resetPassword(Request $request)
    {
        $user = User::where('api_token', $request->code)->first();
        if ($user) {
            return view('auth.reset-password', ['title' => 'Reset Password', 'description' => '', 'id' => $user->id]);
        } else {
            return Redirect::to('/login')->with('alert-success', 'Invalid token');
        }
    }

    public function emailVerification(Request $request)
    {
        $date = new DateTime('NOW');
        $user = User::where('api_token', $request->code)->first();
        $user->active = 1;
        $user->email_verified_at = $date->format('Y-m-d H:i:s');
        $user->save();
        Mail::to($user->email)->send(new UserRegister($user->first_name, $user->role));
        return Redirect::to('/login')->with('alert-success', 'Welcome to a world of consulting. Your account has been activated. Enjoy!');
    }

    public function becomeConsultant(Request $request)
    {
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->ex_phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'consultant',
            'status' => 'offline',
            'balance' => '0',
            'account_id' => $request->account,
            'api_token' => str_random(60),
            'active' => 2
        ]);

        $profile = Profile::create([
            'birth' => $request->birthday,
            'gender' => $request->gender,
            'street' => $request->street,
            'zip_code' => $request->zip_code,
            'avatar' => $request->profile_avatar,
            'profession' => $request->profession,
            'from' => $request->from,
            'country' => $request->country,
            'region' => $request->region,
            'timezone' => $request->timezone,
            'description' => $request->consultant_introduction
        ]);

        $company = Company::create([
            'company_name' => $request->company_name,
            'organization_number' => $request->organization_number,
            'bank_account' => $request->bank_account,
            "first_name" => $request->cfirst_name,
            "last_name" => $request->clast_name,
            "address" => $request->company_address,
            "zip_code" => $request->czip_code,
            "zip_place" => $request->company_region,
            "country" => $request->company_from
        ]);

        $consultant = Consultant::create([
            'user_id' => $user->id,
            'profile_id' => $profile->id,
            'company_id' => $company->id,
            'chat_contact' => $request->chat_contact,
            'phone_contact' => $request->phone_contact,
            'video_contact' => $request->video_contact,
            'currency' => $request->currency,
            'hourly_rate' => $request->rate
        ]);

        if ($request->education_count > 0) {
            for ($i = 0; $i < $request->education_count; $i++) {
                Education::create([
                    "consultant_id" => $consultant->id,
                    "from" => $request["education{$i}_from"],
                    "to" => $request["education{$i}_to"],
                    "institution" => $request["education{$i}_institution"],
                    "major" => $request["education{$i}_major"],
                    "degree" => $request["education{$i}_degree"],
                    "description" => $request["education{$i}_description"],
                    "diploma" => $request["education{$i}_diploma"]
                ]);
            }
        }
        if ($request->experience_count > 0) {
            for ($i = 0; $i < $request->experience_count; $i++) {
                Experience::create([
                    "consultant_id" => $consultant->id,
                    "from" => $request["experience{$i}_from"],
                    "to" => $request["experience{$i}_to"],
                    "company" => $request["experience{$i}_company"],
                    "position" => $request["experience{$i}_position"],
                    "country" => $request["experience{$i}_country"],
                    "city" => $request["experience{$i}_city"],
                    "description" => $request["experience{$i}_description"]
                ]);
            }
        }
        if ($request->certificate_count > 0) {
            for ($i = 0; $i < $request->certificate_count; $i++) {
                Certificate::create([
                    "consultant_id" => $consultant->id,
                    "date" => $request["certificate{$i}_date"],
                    "name" => $request["certificate{$i}_name"],
                    "institution" => $request["certificate{$i}_institution"],
                    "description" => $request["certificate{$i}_description"],
                    "diploma" => $request["certificate{$i}_diploma"]
                ]);
            }
        }
        Mail::to($user->email)->send(new ConsultantRegisterSuccess());
        return Redirect::to('/login')->with('alert-success', App::getLocale() == 'en' ? 'Thank you for your interest. We will contact you by email once your application is processed.' : 'Takk for din interesse! Vi vil ta kontakt på e-post når søknaden din har blitt prosessert.');
    }

    public function reset_password(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect('/login')->with('alert-success', App::getLocale() == 'en' ? 'Your password has been successfully reset. You can now login to GotoConsult.' : 'Vennligst sjekk e-posten din for å opprette et nytt passord.');
    }

    public function plans()
    {
        $user_id = Auth::user()->id;
        $user_role = Auth::user()->role;
        $user_detail = '';
        if($user_role == 'customer') {
            $user_detail = Customer::where('user_id', $user_id)->first();
        }
        if($user_role == 'consultant') {
            $user_detail = Consultant::where('user_id', $user_id)->first();   
        }
        $plans = Plan::where('user_id', $user_id)->get();
        return view('member.plans', [
            'title' => App::getLocale() == 'en' ? 'My Plans' : 'Planene mine',
            'description' => '',
            'active' => '7',
            'plans' => $plans,
            'user_detail' => $user_detail
        ]);
    }

    public function savePlan(Request $request)
    {
        $user_id = Auth::user()->id;
        Plan::create([
            'user_id' => $user_id,
            'title' => $request->title,
            'category' => $request->category,
            'description' => $request->has('description') ? $request->description : '',
            'price' => $request->price
        ]);
        return redirect()->back();
    }

    public function deletePlan($id)
    {
        Plan::destroy($id);
        PlanSession::where('plan_id', $id)->delete();
        return redirect()->back();
    }

    public function savePlanSession(Request $request, $id)
    {
        $user_id = Auth::user()->id;
        $user_role = Auth::user()->role;
        $user_detail = '';
        if($user_role == 'customer') {
            $user_detail = Customer::where('user_id', $user_id)->first();
        }
        if($user_role == 'consultant') {
            $user_detail = Consultant::where('user_id', $user_id)->first();   
        }
        PlanSession::create([
            'plan_id' => $id,
            'title' => $request->title,
            'duration' => $request->duration,
            'currency_type' => $user_detail->currency,
            'price' => (float)$request->price
        ]);
        return redirect()->back();
    }

    public function calendar()
    {
        $user_id = Auth::user()->id;
        $user_role = Auth::user()->role;
        $calendar_data = Booking::where('bookings.user_id', $user_id)->orWhere('bookings.consultant_id', $user_id)
            ->leftJoin('users as u', 'u.id', '=', 'bookings.user_id')
            ->leftJoin('users as c', 'c.id', '=', 'bookings.consultant_id')
            ->leftJoin('customers', 'customers.user_id', '=', 'bookings.user_id')
            ->leftJoin('consultants', 'consultants.user_id', '=', 'bookings.consultant_id')
            ->join('profile as p_u', 'p_u.id', '=', 'customers.profile_id')
            ->join('profile as p_c', 'p_c.id', '=', 'consultants.profile_id')
            ->join('plan_sessions', 'plan_sessions.id', '=', 'bookings.session_id')
            ->select(
                'bookings.*', 
                'u.first_name as user_first_name', 
                'u.last_name as user_last_name', 
                'c.first_name as consultant_first_name', 
                'c.last_name as consultant_last_name',
                'p_u.avatar as user_avatar',
                'p_c.avatar as consultant_avatar',
                'plan_sessions.price',
                'plan_sessions.currency_type',
            )
            ->get();
        return view('member.calendar', [
            'title' => App::getLocale() == 'en' ? 'My Calendar' : 'Min kalender',
            'description' => '',
            'active' => '8',
            'data' => $calendar_data,
            'role' => $user_role
        ]);
    }

    public function updateAvailableHours(Request $request)
    {
        $user_id = Auth::user()->id;
        $consultant = Consultant::where('user_id', $user_id)->first();
        $profile = Profile::where('id', $consultant->profile_id)->first();
        if($profile)
        {
            $profile->timetable = $request->timetable;
            $profile->save();
        }
        return redirect()->back();
    }

    public function booking(Request $request)
    {
        $data = json_decode($request->data);
        $user_id = Auth::user()->id;
        $booking = Booking::create([
            'user_id' => $user_id,
            'consultant_id' => $data->consultantID,
            'plan_id' => $data->planID,
            'session_id' => $data->sessionID,
            'booking_date' => date('Y-m-d H:i', strtotime($data->date)),
            'communication_type' => $data->communicationType
        ]);
        $profile = Profile::where('id', $data->profileID)->first();
        if($profile)
        {
            $selectedDate = $data->date;
            $profile->timetable = implode(',', array_filter(explode(',', $profile->timetable), function($date) use ($selectedDate) {
                if ($date == $selectedDate) {
                    return false;
                }
                return true;
            }));
            $profile->save();
        }
        return redirect()->route('booking.payment', $booking->id);
    }

    public function bookingPayment($id)
    {
        if (!Auth::check()) {
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        $cur_balance = Auth::user()->balance;
        $auth_user = [];
        if (auth()->user()->role == 'consultant') {
            $auth_user = Consultant::where('user_id', auth()->user()->id)->with('profile')->first();
        } else {
            $auth_user = Customer::where('user_id', auth()->user()->id)->with('profile')->first();
        }
        $currency = $auth_user->currency ? $auth_user->currency : 'NOK';
        
        $booking = Booking::find($id);

        $plan = PlanSession::where('id', $booking->session_id)->where('plan_id', $booking->plan_id)->first();

        // echo json_encode($plain);

        return view('member.payment', [
            'title' => App::getLocale() == 'en' ? 'Booking Checkout' : 'Min lommebok',
            'booking' => $booking,
            'description' => '',
            'active' => '2',
            'balance' => $cur_balance,
            'currency' => $currency,
            'is_popup' => 'false',
            'amount' => $plan->price,
        ]);
    }
}
