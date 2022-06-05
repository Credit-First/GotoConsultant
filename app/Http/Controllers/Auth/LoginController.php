<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Session;
use DB;

use App\Models\Page;
use App\Models\MissedNotification;
use App\User;
use App\Events\UserStatus;
use App;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        $page = Page::where('id', 7)->first();
        $data = json_decode($page->page_body);
        return view('auth.login',  compact('data'), ['title' => $page->meta_title, 'description' => $page->meta_description]);
    }

    public function logout(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();
        $user->update(['status' => 'offline']);
        broadcast(new UserStatus($user))->toOthers();
        Auth::logout();
        $lang = App::getLocale();
        if ($lang == 'en') {
            return redirect('/login');
        } else {
            return redirect('/no/logg-inn');
        }
    }

    public function login(Request $request) {
        $lang = App::getLocale();
        $rules = array('email' => 'required|email', 'password' => 'required');

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $lang == 'en' ? Redirect::to('/login')->withErrors($validator) : Redirect::to('/no/logg-inn')->withErrors($validator);
        } else {
            // create our user data for the authentication
            $userdata = array(
                'password'  => $request->password,
                'email'     => $request->email
            );
            $user = User::where('email', $request->email)->first();
            if (isset($user)) {
                $missedNotifications= MissedNotification
                    ::getByReceiverId($user->id)
                    ->select('sender_id', DB::raw('count(*) as sender_total'))
                    ->groupBy('sender_id')
                    ->get()
                    ->toArray();
                Session::put('missedNotifications', $missedNotifications);

                if ($user->active == 1) {
                    if (Auth::attempt($userdata,true)) {
                        $user->status = "available";
                        $user->save();
                        broadcast(new UserStatus($user))->toOthers();
                        if (Auth::user()->role == "admin") {
                            return $lang == 'en' ? redirect('/admin-dashboard') : redirect('/no/admin-dashbord');
                        } else {
                            return $lang == 'en' ? redirect("/dashboard") : redirect("/no/oversikt");
                        }
                    } else {
                        return $lang == 'en' ? Redirect::to('/login')->with('alert-error', 'Enter Correct Email and Password.') : Redirect::to('/no/logg-inn')->with('alert-error', 'Skriv inn riktig e-postadresse og passord.');
                    }
                } else {
                    if ($user->role == "customer") {
                        return $lang == 'en' ? Redirect::to('/login')->with('alert-error', 'An activation link has been sent to your email. Please check your email to activate your account.') : Redirect::to('/no/logg-inn')->with('alert-error', 'En aktiveringskobling er sendt til e-posten din. Sjekk e-postadressen din for å aktivere kontoen din.');
                    } else {
                        if ($user->active == 0) {
                            return $lang == 'en' ? Redirect::to('/login')->with('alert-error', 'Your account has been deactivated. Please contact support if you have any questions.') : Redirect::to('/no/logg-inn')->with('alert-error', 'Din konto har blitt deaktivert. Ta kontakt med kundestøtte hvis du har spørsmål.');
                        } else {
                            return $lang == 'en' ? Redirect::to('/login')->with('alert-error', 'Your consultant application is under process. We will inform you once your account is activated.') : Redirect::to('/no/logg-inn')->with('alert-error', 'Din konsulentsøknad er under behandling. Vi vil informere deg når kontoen din er aktivert.');
                        }
                    }
                }
            } else {
                return $lang == 'en' ? Redirect::to('/login')->with('alert-error', 'Enter Correct Email and Password.') : Redirect::to('/no/logg-inn')->with('alert-error', 'Skriv inn riktig e-postadresse og passord.');
            }
        }
    }
}
