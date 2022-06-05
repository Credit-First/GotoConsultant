<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;

use App\User;
use App\Booking;
use App\Models\Categories;
use App\Models\Consultant;
use App\Models\Customer;
use App\Models\Profile;
use App\Models\Company;
use App\Models\Transactions;
use App\Models\Page;
use App\Models\Review;
use App\Models\Session;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Certificate;
use App\Models\Requests;
use App\Models\ChargingTransactions;

use App\Mail\UserRegister;
use App\Mail\ConsultantRegisterFailed;
use Carbon\Carbon;

use App\Events\UserStatus;
use App\PlanSession;
use Stripe;
use Hash;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{
    public function updateSetting(Request $request) {
        if ($request->type == 'personal') {
            $rules = array('first_name' => 'required','last_name' => 'required','phone' => 'required|regex:/[0-9]{9}/');
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response = array(
                    'status' => false,
                    'errors' => $validator->getMessageBag()->toArray()
                );
                return response()->json($response);
            } else {
                $user = User::where('id', $request->hidden_id)->first();
                $user->first_name = $request->first_name;
                $user->last_name = $request->last_name;
                $user->phone = $request->phone;
                $user->save();
                return response()->json(['status' => 'success']);
            }
        } else if ($request->type == 'mail') {
            $rules = array('old_mail' => 'required|email','new_mail' => 'required|email');
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response = array(
                    'status' => 0,
                    'errors' => $validator->getMessageBag()->toArray()
                );
                return response()->json($response);
            } else {
                $user = User::where('id', $request->hidden_id)->first();
                if($request->old_mail != $user->email) {
                    return response()->json(['status' => 1]);
                } else {
                    if (User::where('email', $request->new_mail)->count() > 0) {
                        return response()->json(['status' => 3]);
                    } else {
                        $user = User::where('id', $request->hidden_id)->first();
                        $user->email = $request->new_mail;
                        $user->save();
                        return response()->json(['status' => 2]);
                    }
                }
            }
        } else if ($request->type == 'private') {
            $user = User::where('id', $request->hidden_id)->first();
            $user->fee = $request->fee;
            $user->save();
            return response()->json(['success' => true]);
        } else {
            $rules = array('old_password' => 'required','new_password' => 'required');
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response = array(
                    'status' => 0,
                    'errors' => $validator->getMessageBag()->toArray()
                );
                return response()->json($response);
            } else {
                $user = User::where('id', $request->hidden_id)->first();
                if (Hash::check($request->old_password, $user->password)) {
                    $user->password = Hash::make($request->new_password);
                    $user->save();
                    return response()->json(['status' => 1]);
                } else {
                    return response()->json(['status' => 2]);
                }
            }
        }
    }

    public function createCategory(Request $request) {
        if($request->type == 'profile') {
            $rules = array('category_name' => 'required|unique:categories', 'category_url' => 'required|unique:categories','category_description' => 'required|max:220', 'vat' => 'required|min:0');
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response = array(
                    'status' => false,
                    'errors' => $validator->getMessageBag()->toArray()
                );
                return response()->json($response);
            } else {
                $category = Categories::create([
                    'category_name' => $request->category_name,
                    'category_name_no' => $request->category_name_no,
                    'category_url' => strtolower(str_replace(" ", "_", $request->category_url)),
                    'category_description' => $request->category_description,
                    'category_description_no' => $request->category_description_no,
                    'vat' => $request->vat,
                    'category_icon' => $request->select_file
                ]);
                return response()->json(['status' => true, 'id' => $category->id]);
            }
        } else if ($request->type == 'meta') {
            $category = Categories::where('id', $request->hidden_id)->update([
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
            ]);
            return response()->json(['status' => true]);
        }
    }
    public function updateCategory(Request $request) {
        if($request->type == 'profile') {
            $rules = array('category_name' => 'required', 'category_name_no' => 'required', 'category_url' => 'required','category_description' => 'required', 'category_description_no' => 'required', 'vat' => 'required|min:0');
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response = array(
                    'status' => false,
                    'errors' => $validator->getMessageBag()->toArray()
                );
                return response()->json($response);
            } else {
                $category = Categories::where('id', $request->hidden_id)->update([
                    'category_name' => $request->category_name,
                    'category_name_no' => $request->category_name_no,
                    'category_url' => strtolower(str_replace(" ", "_", $request->category_url)),
                    'category_description' => $request->category_description,
                    'category_description_no' => $request->category_description_no,
                    'vat' => $request->vat
                ]);
                return response()->json(['status' => true]);
            }
        } else if ($request->type == 'meta') {
            $category = Categories::where('id', $request->hidden_id)->update([
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description
            ]);
            return response()->json(['status' => 'true']);
        } else {
            $validation = Validator::make($request->all(), [
                'select_file' => 'required|image|mimes:jpeg,png,jpg,gif|max:256'
            ]);
            $category = Categories::where('id', $request->hidden_id)->update([
                'category_icon' => $request->select_file
            ]);
            return response()->json(['status' => true]);
        }
    }

    public function createPage(Request $request) {
        if ($request->type == "page") {
            $rules = array('page_name' => 'required', 'page_url' => 'required');
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response = array(
                    'status' => false,
                    'errors' => $validator->getMessageBag()->toArray()
                );
                return response()->json($response);
            } else {
                $page = new Page;
                $page->page_name = $request->page_name;
                $page->page_url = strtolower(str_replace(" ", "_", $request->page_url));
                $page->save();
                return response()->json(['status' => true, 'id' => $page->id]);
            }
        } else if ($request->type == 'meta') {
            $rules = array('meta_title' => 'required|max:55', 'meta_description' => 'required|max:55');
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response = array(
                    'status' => false,
                    'errors' => $validator->getMessageBag()->toArray()
                );
                return response()->json($response);
            } else {
                $page = Page::where('id', $request->hidden_id)->first();
                $page->meta_title = $request->meta_title;
                $page->meta_description = $request->meta_description;
                $page->save();
                return response()->json(['status' => true]);
            }
        } else {
            $rules = array('page_body' => 'required');
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response = array(
                    'status' => false,
                    'errors' => $validator->getMessageBag()->toArray()
                );
                return response()->json($response);
            } else {
                $page = Page::where('id', $request->hidden_id)->first();
                $page->page_body = $request->page_body;
                $page->save();
                return response()->json(['status' => true]);
            }
        }
    }
    public function updatePage(Request $request) {
        if ($request->type == "page") {
            $rules = array('page_name' => 'required', 'page_url' => 'required');
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response = array(
                    'status' => false,
                    'errors' => $validator->getMessageBag()->toArray()
                );
                return response()->json($response);
            } else {
                $page = Page::where('id', $request->hidden_id)->first();
                $page->page_name = $request->page_name;
                $page->page_url = strtolower(str_replace(" ", "_", $request->page_url));
                $page->save();
                return response()->json(['status' => true]);
            }
        } else if ($request->type == 'meta') {
            $rules = array('meta_title' => 'required|max:55', 'meta_description' => 'required|max:55');
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response = array(
                    'status' => false,
                    'errors' => $validator->getMessageBag()->toArray()
                );
                return response()->json($response);
            } else {
                $page = Page::where('id', $request->hidden_id)->first();
                $page->meta_title = $request->meta_title;
                $page->meta_description = $request->meta_description;
                $page->save();
                return response()->json(['status' => true]);
            }
        } else {
            $rules = array('page_body' => 'required');
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response = array(
                    'status' => false,
                    'errors' => $validator->getMessageBag()->toArray()
                );
                return response()->json($response);
            } else {
                $page = Page::where('id', $request->hidden_id)->first();
                $data = json_decode($page->page_body);

                if ($page->id == 63) {
                    $key = $request->detail_type;
                    if (strstr($key, 'benefit_title')) {
                        $data->benefit_list->en_title = $request->page_body['en'];
                        $data->benefit_list->no_title = $request->page_body['no'];
                    } else if (strstr($key, 'review_title')) {
                        $data->reviews->en_title = $request->page_body['en'];
                        $data->reviews->no_title = $request->page_body['no'];
                    } else if (strstr($key, 'benefit_arr')) {
                        $data->benefit_list->arr = $request->page_body;
                    } else if (strstr($key, 'benefit_button')) {
                        $data->benefit_list->buttons = $request->page_body;
                    } else if (strstr($key, 'review_arr')) {
                        $data->reviews->arr = $request->page_body;
                    } else {
                        $data->$key = $request->page_body;
                    }
                }

                if ($page->id == 1) {
                    $key = $request->detail_type;
                    if (strstr($key, 'review_title')) {
                        $data->review_list->en_title = $request->page_body['en'];
                        $data->review_list->no_title = $request->page_body['no'];
                    } else if (strstr($key, 'review_arr')) {
                        $data->review_list->arr = $request->page_body;
                    } else {
                        $data->$key = $request->page_body;
                    }
                }

                if ($page->id == 2) {
                    $key = $request->detail_type;
                    if (strstr($key, 'platform_title')) {
                        $data->platform_list->en_title = $request->page_body['en'];
                        $data->platform_list->no_title = $request->page_body['no'];
                        $data->platform_list->plat_img = $request->page_body['plat_img'];
                    } else if (strstr($key, 'become_consult_arr')) {
                        $data->list = $request->page_body;
                    } else if (strstr($key, 'review_title')) {
                        $data->review_list->en_title = $request->page_body['en'];
                        $data->review_list->no_title = $request->page_body['no'];
                    } else if (strstr($key, 'review_arr')) {
                        $data->review_list->arr = $request->page_body;
                    } else if (strstr($key, 'register_title')) {
                        $data->register_list->en_title = $request->page_body['en'];
                        $data->register_list->no_title = $request->page_body['no'];
                        $data->register_list->en_des_title = $request->page_body['en_des'];
                        $data->register_list->no_des_title = $request->page_body['no_des'];
                    } else if (strstr($key, 'register_arr')) {
                        $data->register_list->arr = $request->page_body;
                    } else {
                        $data->$key = $request->page_body;
                    }
                }

                if ($page->id == 3) {
                    $key = $request->detail_type;
                    if (strstr($key, 'article_title')) {
                        $data->article_list->en_title = $request->page_body['en'];
                        $data->article_list->no_title = $request->page_body['no'];
                    } else if (strstr($key, 'article_arr')) {
                        $data->article_list->arr = $request->page_body;
                    } else if (strstr($key, 'team_title')) {
                        $data->team->en_part_title = $request->page_body['en_part_title'];
                        $data->team->no_part_title = $request->page_body['no_part_title'];
                        $data->team->en_title = $request->page_body['en_title'];
                        $data->team->no_title = $request->page_body['en_title'];
                    } else if (strstr($key, 'team_arr')) {
                        $data->team = $request->page_body;
                    } else if (strstr($key, 'get_started_title')) {
                        $data->get_started->en_title = $request->page_body['en'];
                        $data->get_started->no_title = $request->page_body['no'];
                    } else if (strstr($key, 'get_started_arr')) {
                        $data->get_started->arr = $request->page_body;
                    } else {
                        $data->$key = $request->page_body;
                    }
                }

                if ($page->id == 10) {
                    $key = $request->detail_type;
                    if (strstr($key, 'service_title')) {
                        $data->services->en_title = $request->page_body['en_title'];
                        $data->services->no_title = $request->page_body['no_title'];
                    } else if(strstr($key, 'service_arr')) {
                        $data->services->arr = $request->page_body;
                    } else {
                        $data->$key = $request->page_body;
                    }
                }
                if ($page->id == 8 || $page->id == 7 || $page->id == 6 || $page->id == 4 || $page->id == 5 || $page->id == 9) {
                    $key = $request->detail_type;
                    $data->$key = $request->page_body;
                }

                $page->page_body = json_encode($data);
                $page->save();
                return response()->json(['status' => true]);
            }
        }
    }

    public function homeHelpImageUpload(Request $request) {
        if ($request->file('file')->isValid()){
            $url = url("/assets/uploads/home") ."/" . $request->file->store('', 'home');
            $arr = explode("/", $url);
            $path = "/".$arr[3]."/".$arr[4]."/".$arr[5]."/".$arr[6];
            return response()->json(['url' => $path, 'status' => true]);
        } else {
            return response()->json(['status' => false]);
        }
    }

    public function homeBenefitImageUpload(Request $request) {
        if ($request->file('file')->isValid()){
            $url = url("/assets/uploads/home") ."/" . $request->file->store('', 'home');
            $arr = explode("/", $url);
            $path = "/".$arr[3]."/".$arr[4]."/".$arr[5]."/".$arr[6];
            return response()->json(['url' => $path, 'status' => true]);
        } else {
            return response()->json(['status' => false]);
        }
    }

    public function homeReviewImageUpload(Request $request) {
        if ($request->file('file')->isValid()){
            $url = url("/assets/uploads/home") ."/" . $request->file->store('', 'home');
            $arr = explode("/", $url);
            $path = "/".$arr[3]."/".$arr[4]."/".$arr[5]."/".$arr[6];
            return response()->json(['url' => $path, 'status' => true]);
        } else {
            return response()->json(['status' => false]);
        }
    }

    public function becomeConsultantPlatformImageUpload(Request $request) {
        if ($request->file('file')->isValid()){
            $url = url("/assets/uploads/become_consultant") ."/" . $request->file->store('', 'become_consultant');
            $arr = explode("/", $url);
            $path = "/".$arr[3]."/".$arr[4]."/".$arr[5]."/".$arr[6];
            return response()->json(['url' => $path, 'status' => true]);
        } else {
            return response()->json(['status' => false]);
        }
    }

    public function adminBannerImageUpload(Request $request) {
        if ($request->file('file')->isValid()){
            $url = url("/assets/uploads/banner") ."/" . $request->file->store('', 'banner');
            $arr = explode("/", $url);
            $path = "/".$arr[3]."/".$arr[4]."/".$arr[5]."/".$arr[6];
            $page = Page::where('id', $request->id)->first();
            $data = json_decode($page->page_body);
            if ($request->type == "desktop") {
                $data->desktop_banner_img = $path;
            } else {
                $data->mobile_banner_img = $path;
            }
            $page->page_body = json_encode($data);
            $page->save();
            return response()->json(['status' => true]);
        } else {
            return response()->json(['status' => false]);
        }
    }

    public function createConsultant(Request $request) {
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
            'active' => 0
        ]);

        $profile = Profile::create([
            'avatar' => $request->profile_avatar,
            'profession' => $request->profession,
            'from' => $request->from,
            'country' => $request->country,
            'region' => $request->region,
            'gmt' => $request->gmt,
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
        return redirect()->back();
    }
    public function updateConsultant(Request $request) {
        if ($request->type == "activate") {
            $user = User::where('id', $request->hidden_id)->first();
            $user->update(['active' => $request->value]);
            if ($request->value == "1") {
                Mail::to($user->email)->send(new UserRegister($user->first_name, $user->role));
            } else {
                Mail::to($user->email)->send(new ConsultantRegisterFailed());
            }
            return response()->json(['status' => true]);
        } else if ($request->type == "profile") {
            $rules = array('first_name' => 'required', 'last_name' => 'required', 'phone' => 'required|regex:/[0-9]{9}/','profession' => 'required');
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response = array(
                    'status' => false,
                    'errors' => $validator->getMessageBag()->toArray()
                );
                return response()->json($response);
            } else {
                $user = User::where('id', $request->hidden_id)->update([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'phone' => $request->phone,
                ]);
                return response()->json(['status' => true]);
            }
        } else if ($request->type == "private") {
            $consultant = Consultant::where('id', $request->hidden_id)->first();
            Profile::where('id', $consultant->profile_id)->update([
                "birth" => $request->birth,
                "gender" => $request->gender,
                "street" => $request->street,
                "zip_code" => $request->zip_code,
                "gmt" => $request->gmt,
                "timezone" => $request->timezone,
                "from" => $request->from,
                "country" => $request->country,
                "region" => $request->region,
            ]);
            return response()->json(['status' => true]);
        } else if ($request->type == "company") {
            $consultant = Consultant::where('id', $request->hidden_id)->first();
            Company::where('id', $consultant->company_id)->update([
                "company_name" => $request->company_name,
                "organization_number" => $request->organization_number,
                "bank_account" => $request->bank_account,
                "first_name" => $request->first_name,
                "last_name" => $request->last_name,
                "address" => $request->address,
                "country" => $request->country,
                "zip_place" => $request->zip_place,
                "zip_code" => $request->zip_code
            ]);
            return response()->json(['status' => true]);
        } else if ($request->type == "consultant_pro") {
            $consultant = Consultant::where('id', $request->hidden_id)->first();
            $consultant->update([
                "hourly_rate" => $request->hourly_rate,
                "currency" => $request->currency
            ]);
            Profile::where('id', $consultant->profile_id)->update([
                "profession" => $request->profession,
                "description" => $request->description
            ]);
            return response()->json(['status' => true]);
        } else if ($request->type == "company") {
            $consultant = Consultant::where('user_id', $request->hidden_id)->first();
            Company::where('id', $consultant->company_id)->update([
                "company_name" => $request->company_name,
                "organization_number" => $request->organization_number,
                "bank_account" => $request->bank_account,
                "first_name" => $request->first_name,
                "last_name" => $request->last_name,
                "address" => $request->address,
                "country" => $request->country,
                "zip_place" => $request->zip_place,
                "zip_code" => $request->zip_code
            ]);
            return response()->json(['status' => 'success']);
        } else if ($request->type == "contact") {
            $customer = Consultant::where('user_id', $request->hidden_id)->update([
                'phone_contact' => $request->phone_contact,
                'chat_contact' => $request->chat_contact,
                'video_contact' => $request->video_contact,
            ]);
            return response()->json(['status' => true]);
        } else if ($request->type == "password") {
            $consultant = User::where('id', $request->hidden_id)->first();
            if ($request->password == $request->confirm_password) {
                $consultant->password = Hash::make($request->confirm_password);
                $consultant->save();
                return response()->json(['status' => true]);
            } else {
                return response()->json(['status' => false]);
            }
        } else {
            $consultant = Consultant::where('id', $request->hidden_id)->first();
            Profile::where('id', $consultant->profile_id)->update(['avatar' => $request->prof_img]);
            return response()->json(['status' => true]);
        }
    }

    public function createCustomer(Request $request) {
        if ($request->type == "profile") {
            $rules = array('first_name' => 'required', 'last_name' => 'required','email' => 'required|email', 'phone' => 'required|regex:/[0-9]{9}/');
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response = array(
                    'status' => false,
                    'errors' => $validator->getMessageBag()->toArray()
                );
                return response()->json($response);
            } else {
                $user = User::create([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'password' => Hash::make($request->password),
                    'role' => 'customer',
                    'status' => 'offline',
                    'balance' => '0',
                    'api_token' => str_random(60),
                    'active' => 0
                ]);

                $customer = Customer::create([
                    'user_id' => $user->id
                ]);

                $profile = Profile::create([
                    'avatar' => $request->prof_image
                ]);
                $customer->update(['profile_id' => $profile->id]);
                $link = URL::route('account-activate', $user->api_token);
                Mail::to($request->email)->send(new VerificationEmail($link));
                return response()->json(['status' => 1, 'id' => $user->id]);
            }
        } else if ($request->type == "invoice") {
            $customer = Customer::where('user_id', $request->hidden_id)->first();
            $customer->company_name = $request->company_name;
            $customer->invoice_mail = $request->invoice_mail;
            $customer->invoice_first_name = $request->invoice_first_name;
            $customer->invoice_last_name = $request->invoice_last_name;
            $customer->invoice_address = $request->address;
            $customer->invoice_zip_code = $request->zip_code;
            $customer->invoice_zip_place = $request->zip_place;
            $customer->save();
            return response()->json(['status' => 'success']);
        } else if ($request->type == "contact") {
            $customer = Customer::where('user_id', $request->hidden_id)->first();
            $customer->phone_contact = $request->phone_contact;
            $customer->chat_contact = $request->chat_contact;
            $customer->video_contact = $request->video_contact;
            $customer->save();
            return response()->json(['status' => 'success']);
        }
    }
    public function updateCustomer(Request $request) {
        if ($request->type == "profile") {
            $rules = array('first_name' => 'required', 'last_name' => 'required', 'phone' => 'required|regex:/[0-9]{9}/');
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response = array(
                    'status' => false,
                    'errors' => $validator->getMessageBag()->toArray()
                );
                return response()->json($response);
            } else {
                $user = User::where('id', $request->hidden_id)->update([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'phone' => $request->phone,
                ]);
                return response()->json(['status' => true]);
            }
        } else if ($request->type == "invoice") {
            $customer = Customer::where('user_id', $request->hidden_id)->first();
            $customer->company_name = $request->company_name;
            $customer->invoice_mail = $request->invoice_mail;
            $customer->invoice_first_name = $request->invoice_first_name;
            $customer->invoice_last_name = $request->invoice_last_name;
            $customer->invoice_address = $request->address;
            $customer->invoice_zip_code = $request->zip_code;
            $customer->invoice_zip_place = $request->zip_place;
            $customer->save();
            return response()->json(['status' => 'success']);
        } else if ($request->type == "contact") {
            $customer = Customer::where('user_id', $request->hidden_id)->update([
                'phone_contact' => $request->phone_contact,
                'chat_contact' => $request->chat_contact,
                'video_contact' => $request->video_contact,
            ]);
            return response()->json(['status' => 'success']);
        } else if ($request->type == "password") {
            $user = User::where('id', $request->hidden_id)->first();
            if (Hash::check($request->old_password, $user->password)) {
                $user->password = Hash::make($request->new_password);
                $user->save();
                return response()->json(['status' => 'success']);
            } else {
                return response()->json(['status' => 1]);
            }
        } else {
            $customer = Customer::where('id', $request->hidden_id)->first();
            Profile::where('id', $customer->profile_id)->update(['avatar' => $request->prof_img]);
            return response()->json(['status' => 'success']);
        }
    }

    public function manageStatus(Request $request) {
        $requestData = $request->all();
        $user = User::where('id', $request->id)->first();
        $user->status = $request->status;
        $user->save();
        broadcast(new UserStatus($user))->toOthers();
        if ($request->type != 'closeEvent') {
            if ($user->role == "consultant") {
                $profile = Consultant::where('user_id', $user->id)->with("profile")->first();
            } else {
                $profile = Customer::where('user_id', $user->id)->with("profile")->first();
            }
            return response()->json($profile);
        }
    }

    public function manageTransaction(Request $request) {
        // manage user status and balance
        $user = User::where('id', $request->id)->first();
        $user->balance = (float)$user->balance - ( $request->total_amount ?? $request->cost );
        $user->save();
        // update session table
        $type = $user->role == "customer" ? 'BOOKING' : 'CONTOCON';
        Session::create(['customer_id' => $request->id, 'consultant_id' => $request->consultant_id, 'type' => $type]);
        // update transaction table
        $transaction = [
            'transaction_id' => $this->getTransactionID(),
            'receiver_id' => $request->consultant_id,
            'payer_id' => $request->id,
            'amount' => $request->cost,
            'vat_amount' => $request->vat_amount ?? 0,
            'total_amount' => $request->total_amount ?? $request->cost,
            'time_spent' => $request->time,
            'type' => $type
        ];
        Transactions::create($transaction);
        return response()->json($user->balance);
    }

    public function manageReview(Request $request) {
        $review = Review::where('sender_id', $request->sender_id)->where('receiver_id', $request->receiver_id)->first();
        $new_session_count = 0;
        if (isset($review)) {
            $new_session_count = $review->session + 1;
            Review::create([
                'sender_id' => $request->sender_id,
                'receiver_id' => $request->receiver_id,
                'rate' => number_format($request->rate),
                'description' => $request->description,
                'type' => $request->type,
                'session' => $new_session_count
            ]);
            Review::where('sender_id', $request->sender_id)->where('receiver_id', $request->receiver_id)->update(['session' => $new_session_count]);
        } else {
            $new_session_count = 1;
            Review::create([
                'sender_id' => $request->sender_id,
                'receiver_id' => $request->receiver_id,
                'rate' => number_format($request->rate),
                'description' => $request->description,
                'type' => $request->type,
                'session' => 1
            ]);
        }

        $rates = Review::where('sender_id', $request->sender_id)->where('receiver_id', $request->receiver_id)->get();
        $total_val = 0;
        foreach($rates as $item) {
            $total_val += $item->rate;
        }
        $avg_rate = count($rates) > 0 ? number_format($total_val / count($rates), 1) : number_format(0, 1);
        if ($request->type == 'CUSTOCON') {
            Consultant::where('user_id', $request->receiver_id)->update(['rate' => $avg_rate ]);
            Customer::where('user_id', $request->sender_id)->update(['completed_sessions' => $new_session_count]);
        } else {
            Customer::where('user_id', $request->receiver_id)->update(['rate' => $avg_rate ]);
            Consultant::where('user_id', $request->sender_id)->update(['completed_sessions' => $new_session_count]);
        }
        return response()->json('success');
    }

    public function getTransactionID(){
        mt_srand((double)microtime()*10000);
        $charid = md5(uniqid(rand(), true));
        $c = unpack("C*",$charid);
        $c = implode("",$c);

        return "GTC001".substr($c,0,15);
    }

    public function getUniversities() {
        $file = file_get_contents(public_path('world_universities_and_domains.json'));
        $array = json_decode($file, true);
        return response()->json(['array' => $array]);
    }

    public function updateMemberProfile(Request $request) {
        $user = User::where('id', $request->user_id)->first();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->phone = $request->phone;
        // $user->email = $request->email;
        $user->save();

        if ($user->role == 'consultant') {
            $consultant = Consultant::where('user_id', $request->user_id)->first();
            $profile = Profile::where('id', $consultant->profile_id)->first();
            if (isset($profile)) {
                $profile->cover_img = $request->cover_image;
                $profile->avatar = $request->avatar;
                $profile->skype = $request->skype;
                $profile->profession = $request->profession;
                $profile->from = $request->from;
                $profile->country = $request->country;
                $profile->region = $request->region;
                $profile->college = $request->college;
                $profile->gmt = $request->gmt;
                $profile->timezone = $request->timezone;
                $profile->description = $request->description;
                $profile->save();
            } else {
                $data = [
                    'cover_img' => $request->cover_image,
                    'avatar' => $request->avatar,
                    'skype' => $request->skype,
                    'profession' => $request->profession,
                    'from' => $request->from,
                    'country' => $request->country,
                    'region' => $request->region,
                    'college' => $request->college,
                    'gmt' => $request->gmt,
                    'timezone' => $request->timezone,
                    'description' => $request->description
                ];
                $profile = Profile::create($data);
                $consultant->profile_id = $profile->id;
                $consultant->save();
            }
        } else {
            $customer = Customer::where('user_id', $request->user_id)->first();
            $profile = Profile::where('id', $customer->profile_id)->first();
            if (isset($profile)) {
                $profile->cover_img = $request->cover_image;
                $profile->avatar = $request->avatar;
                $profile->from = $request->from;
                $profile->country = $request->country;
                $profile->region = $request->region;
                $profile->gmt = $request->gmt;
                $profile->timezone = $request->timezone;
                $profile->description = $request->description;
                $profile->save();
            } else {
                $data = [
                    'cover_img' => $request->cover_image,
                    'avatar' => $request->avatar,
                    'from' => $request->from,
                    'country' => $request->country,
                    'region' => $request->region,
                    'gmt' => $request->gmt,
                    'timezone' => $request->timezone,
                    'description' => $request->description
                ];
                $profile = Profile::create($data);
                $customer->profile_id = $profile->id;
                $customer->save();
            }
        }
        return response()->json(['status' => true]);
    }

    public function memberImageUpload(Request $request) {
        if ($request->remove_url && file_exists($request->remove_url)) {
            unlink(public_path($request->remove_url));
        }
        if ($request->file('file')->isValid()){
            $url = url("/assets/uploads/member") ."/" . $request->file->store('', 'member');
            $arr = explode("/", $url);
            $path = "/".$arr[3]."/".$arr[4]."/".$arr[5]."/".$arr[6];
            return response()->json(['url' => $path, 'status' => true]);
        } else {
            return response()->json(['status' => false]);
        }
    }
    public function memberImageDelete(Request $request) {
        $profile = Profile::where('id', $request->profileId)->first();
        if ($request->type == 'cover') {
            if (file_exists(public_path().$profile->cover_img)) {
                unlink(public_path().$profile->cover_img);
                $profile->cover_img = null;
            }
        } else {
            if (file_exists(public_path().$profile->avatar)) {
                unlink(public_path().$profile->avatar);
                $profile->avatar = null;
            }
        }
        $profile->save();
        return response()->json(['status' => 'success', 'src' => '/images/white-logo.svg']);
    }

    public function updateMemberSetting(Request $request) {
        if ($request->type == "contact") {
            if ($request->role == 'consultant') {
                $consultant = Consultant::where('user_id', $request->user_id)->first();
                $consultant->update([
                    'phone_contact' => $request->phone_contact,
                    'chat_contact' => $request->chat_contact,
                    'video_contact' => $request->video_contact,
                    'currency' => $request->currency,
                    'hourly_rate' => $request->rate
                ]);
            } else {
                $customer = Customer::where('user_id', $request->user_id)->update([
                    'phone_contact' => $request->phone_contact,
                    'chat_contact' => $request->chat_contact,
                    'video_contact' => $request->video_contact,
                    'currency' => $request->currency,
                ]);
            }
            return response()->json(['status' => 'success']);
        } else if($request->type == "education") {
            $consultant = Consultant::where('user_id', $request->user_id)->first();
            $profile = Profile::where('id', $consultant->profile_id)->update(['college' => $request->college]);
            return response()->json(['status' => 'success']);
        } else if($request->type == 'company') {
            $customer = Customer::where('user_id', $request->user_id)->first();
            if (isset($customer->company_id)) {
                $company = Company::where('id', $customer->company_id)->update([
                    'company_name' => $request->company_name,
                    'organization_number' => $request->organization_number,
                    'bank_account' => $request->bank_account,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'address' => $request->address,
                    'zip_code' => $request->zip_code,
                    'zip_place' => $request->zip_place,
                    'country' => $request->country,
                ]);
            } else {
                $company = Company::create([
                    'company_name' => $request->company_name,
                    'organization_number' => $request->organization_number,
                    'bank_account' => $request->bank_account,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'address' => $request->address,
                    'zip_code' => $request->zip_code,
                    'zip_place' => $request->zip_place,
                    'country' => $request->country
                ]);
                $customer->update(['company_id' => $company->id]);
            }
            return response()->json(['status' => 'success']);
        } else if ($request->type == "password") {
            $user = User::where('id', $request->user_id)->first();
            if (Hash::check($request->old_password, $user->password)) {
                $user->update(['password' => Hash::make($request->new_password)]);
                return response()->json(['status' => 'success']);
            } else {
                return response()->json(['status' => 1]);
            }
        }
    }

    public function consultantDoc(Request $request) {
        if ($request->file('file')->isValid()){
            $url = url("/assets/uploads/member") ."/" . $request->file->store('', 'member');
            $arr = explode("/", $url);
            $path = "/".$arr[3]."/".$arr[4]."/".$arr[5]."/".$arr[6];
            return response()->json(['url' => $path, 'status' => true]);
        } else {
            return response()->json(['status' => false]);
        }
    }

    public function get_reviews(Request $request) {
        if ($request->user['role'] == "consultant") {
            $reviews = Review::where('type', 'CUSTOCON')->where('receiver_id', $request->user_id)->orderBy('created_at', 'desc')->paginate(3);
        } else {
            $reviews = Review::where('type', 'CONTOCUS')->where('receiver_id', $request->user_id)->orderBy('created_at', 'desc')->paginate(3);
        }
        return response()->json($reviews);
    }

    public function addRequest(Request $request) {
        $customer = Customer::where('user_id', $request->customer_id)->first();
        Requests::create(['customer_id' => $customer->id, 'consultant_id' => $request->consultant_id,]);
        return response()->json(['status' => true]);
    }

    public function find_new_registered_user(Request $request) {
        $user = User::where('id', $request->id)->first();
        if ($user->role == 'consultant') {
            $res = Consultant::where('user_id', $user->id)->with(["profile", "user"])->first();
        } else if ($user->role == "customer") {
            $res = Customer::where('user_id', $user->id)->with(["profile", "user"])->first();
        } else {
            $res = null;
        }
        return response()->json($res);
    }

    public function chargeBalance(Request $request) {
        $requestData = $request->all();
\Log::info('-1 chargeBalance $requestData ::' . print_r($requestData, true));
        $user = User::where('id', $request->user_id)->first();
        $user->update(['balance' => $user->balance + $request->balance]);
        $transactions = ChargingTransactions::where('user_id', $request->user_id)->orderBy('created_at', 'desc')->get();
        return response()->json(['status' => 'success', 'balance' => $user->balance, 'transactions' => $transactions]);
    }

    public function stripeCharge(Request $request) {
        $requestData = $request->all();
        \Log::info('-1 stripeCharge $requestData ::' . print_r($requestData, true));
        $appEnv= strtolower(config('app.env'));

        if( $appEnv == 'local' or $appEnv == 'dev' ) {
            \Stripe\Stripe::setApiKey( config('app.STRIPE_TEST_KEY') );
        }
        if( $appEnv == 'production' ) {
            \Stripe\Stripe::setApiKey( config('app.STRIPE_LIVE_KEY') );
        }
        $user = User::where('id', $request->user_id)->first();
        if ($request->type == 'new') {
            if ($request->checked == "true") {
                if ($user->stripe_cus_id != "") {
                    $customer_id = $user->stripe_cus_id;
                } else {
                    $customer = \Stripe\Customer::create([
                        'source' => $request->token,
                        'name' => $user->first_name." ".$user->last_name,
                        'email' => $user->email
                    ]);
                    $customer_id = $customer->id;
                    $user->stripe_cus_id = $customer->id;
                    $user->payment_method = 'stripe';
                }
                $cards = json_decode($user->stripe_cards);
                if (isset($cards)) {
                    foreach ($cards as $card) {
                        if ($card->id != $request->card['id']) {
                            array_push($cards, ["last4" => $request->card['last4'], "id" => $request->card['id']]);
                        }
                    }
                } else {
                    $cards = [];
                    array_push($cards, ["last4" => $request->card['last4'], "id" => $request->card['id']]);
                }
                $user->stripe_cards = json_encode($cards);
                $user->payment_method = 'stripe';
                $user->save();

                try {
                    $charge = \Stripe\Charge::create([
                        'amount' => $request->amount * 100,
                        'currency' => $request->currency,
                        'customer' => $customer_id
                    ]);
                    \Log::info('-9 stripeCharge $charge ::' . print_r($charge, true));

                    ChargingTransactions::create([
                        'user_id' => $user->id,
                        'type' => $request->card['brand'],
                        'amount' => $request->amount,
                        'currency' => $request->currency,
                        'transaction_id' => $charge->id,
                        'status' => $charge->status
                    ]);
                    return response()->json(['status' => 'success', 'transaction' => $charge]);
                } catch (\Stripe\Exception\ApiErrorException $e) {
                    return response()->json(['status' => 'failed', 'err_msg' => $e->getMessage()]);
                }
            } else {
                try {
                    $charge = \Stripe\Charge::create([
                        'amount' => $request->amount * 100,
                        'currency' => $request->currency,
                        'source' => $request->token,
                    ]);
                    \Log::info('-10 stripeCharge $charge ::' . print_r($charge, true));

                    ChargingTransactions::create([
                        'user_id' => $user->id,
                        'type' => $request->card['brand'],
                        'amount' => $request->amount,
                        'currency' => $request->currency,
                        'transaction_id' => $charge->id,
                        'status' => $charge->status
                    ]);
                    return response()->json(['status' => 'success', 'transaction' => $charge]);
                } catch (\Stripe\Exception\ApiConnectionException $e) {
                    return response()->json(['status' => 'failed', 'err_msg' => $e->getMessage()]);
                }
            }
        } else {
            $customer_id = $user->stripe_cus_id;
            try {
                $charge = \Stripe\Charge::create([
                    'amount' => $request->amount * 100,
                    'currency' => $request->currency,
                    'customer' => $customer_id
                ]);
                \Log::info('-12 stripeCharge $charge ::' . print_r($charge, true));

                ChargingTransactions::create([
                    'user_id' => $user->id,
                    'type' => $request->card['brand'],
                    'amount' => $request->amount,
                    'currency' => $request->currency,
                    'transaction_id' => $charge->id,
                    'status' => $charge->status
                ]);
                return response()->json(['status' => 'success', 'transaction' => $charge]);
            } catch (\Stripe\Exception\ApiErrorException $e) {
                return response()->json(['status' => 'failed', 'err_msg' => $e->getMessage()]);
            }
        }
    }

    public function unique_multidim_array($array, $key) {
        $temp_array = array();
        $i = 0;
        $key_array = array();

        foreach($array as $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i] = $val[$key];
                $temp_array[$i] = $val;
            }
            $i++;
        }
        return $temp_array;
    }

    public function memberDashboardGet(Request $request) {
        $auth_user = User::where('id', $request->id)->first();
        $categories = Categories::get();
        if ($auth_user->role == "consultant") {
            $user_info = Consultant::where('user_id', $request->id)->first();
            $recent_sessions = [];
            $sessions = Session::where('consultant_id', $user_info->id)->orWhere('customer_id', $request->id)->latest('created_at')->take(5)->get();
            foreach ($sessions as $session) {
                if ($session->type == 'CUSTOCON') {
                    $customer = Customer::where('user_id', $session->customer_id)->with('profile', 'user')->first();
                    array_push($recent_sessions, $customer);
                } else {
                    if ($session->customer_id == $request->id) {
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
        } else {
            $sessions = Session::where('customer_id', $auth_user->id)->latest('created_at')->take(5)->get();
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
        }
        return response()->json(['status' => true, 'recent_sessions' => $recent_sessions, 'recommended_consultants' => $recommended_consultants, 'categories' => $categories]);
    }

    public function updateBookingStatus(Request $request) {
        $booking = Booking::where('id', $request->id)->first();
        if($booking)
        {
            $booking->status = 'paid';
            $booking->save();
        }
        return response()->json(['status' => 'success']);
    }

    public function deletePlanSession($id) {
        PlanSession::destroy($id);
        return response()->json(['status' => 'success']);
    }
}
